<?php
session_start();
if ($_SESSION['admin'] && isset($_SESSION['admin'])) {
require_once "../../database/config.php";

class Admin {
  private $pdo;

  function __construct() {
    try {
      $db = new Database();
      $this->pdo = $db->getPDO();
    } catch (PDOException $e) {
      die("Erreur de base de données : " . $e->getMessage());
    }
  }

  function getAdmin() {
    try {
      $stmt = $this->pdo->prepare("SELECT * FROM admins WHERE id_admin = :v1");
      $stmt->bindParam(':v1', $_GET['id']);
      $stmt->execute();
      return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Erreur lors de la récupération de l admin : " . $e->getMessage());
    }
  }

  function getOffres() {
    try {
      $id_admin = $_SESSION['admin'];

      if (isset($_GET['search']) && !empty(trim($_GET['search']))) {
        $search = '%' . trim($_GET['search']) . '%';
        $stmt = $this->pdo->prepare("
          SELECT * FROM offres 
          WHERE id_admin = :id_admin 
          AND (titre LIKE :search OR entreprise LIKE :search)
          ORDER BY date_debut DESC
        ");
        $stmt->bindParam(':search', $search);
      } else {
        $stmt = $this->pdo->prepare("
          SELECT * FROM offres 
          WHERE id_admin = :id_admin
          ORDER BY date_debut DESC
        ");
      }

      $stmt->bindParam(':id_admin', $id_admin['id_admin']);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
      die("Erreur lors de la récupération des offres : " . $e->getMessage());
    }
  }

  function getCandidaturesByOffre($id_offre) {
    $stmt = $this->pdo->prepare("SELECT e.nom_etu FROM candidatures c JOIN etudiants e ON c.id_etu = e.id_etu WHERE c.id_offre = ?");
    $stmt->execute([$id_offre]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
}

$admin = new Admin();
$i_admin = $admin->getAdmin();
$offre = $admin->getOffres();

$candidaturesParOffre = [];
foreach ($offre as $o) {
  $candidaturesParOffre[$o['id_offre']] = $admin->getCandidaturesByOffre($o['id_offre']);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
  <title>Offres de stage - Admin</title>
  <link rel="stylesheet" href="admin.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../../index/logo.png" alt="Logo">
      <span class="text-white ms-2">Logo</span>
    </a>
    
    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-primary active" href="#">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="profile.php">Profil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="reception.php">Reception</a>
        </li>
      </ul>
    </div>

    <div class="d-flex align-items-center dec">
      <i class="bi bi-person-fill text-primary fs-5 me-2"></i>
      <a href="../../index/deconnexion.php" class="text-white me-3 text-decoration-none">Déconnexion</a>
    </div>
  </div>
</nav>

<!-- Formulaire de recherche + bouton Ajouter -->
<div class="d-flex justify-content-center mt-4">
  <form method="GET" class="input-group w-75 me-2">
    <input type="text" name="search" class="form-control" placeholder="Rechercher une offre..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
    <button class="btn btn-outline-primary" type="submit">Rechercher</button>
  </form>
  <a href="../offres/creeroffres.php" class="btn btn-primary">Ajouter une offre</a>
</div>

<div class="container mt-3">
  <h2 class="text-center mb-4 text-primary">Liste des Offres de Stage</h2>

  <div class="container-fluid">
    <div class="row">
      
      <!-- Liste des offres -->
      <div class="col-md-5 offer-list">
        <?php foreach ($offre as $o): ?>
          <div class="offer-card" onclick="loadDetails('<?= addslashes($o['titre']) ?>', '<?= addslashes($o['description']) ?>', '<?= addslashes($o['entreprise']) ?>', <?= $o['id_offre'] ?>)">
            <div class="offer-title"><?= $o['titre'] ?></div>
            <div class="text-muted small"><?= $o['entreprise'] ?> · Remote</div>
            <span class="badge badge-stage mt-2">Stage</span>
            <div class="text-muted mt-2" style="font-size: 0.85em;">
              Candidature simplifiée<br>
              Début : <?= $o['date_debut'] ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Détail de l'offre -->
      <div class="col-md-7">
        <div class="detail-panel" id="detailPanel">
          <h4 id="detailTitle">Sélectionnez une offre</h4>
          <p class="text-muted" id="detailCompany">Aucune entreprise sélectionnée.</p>
          <p id="detailDesc">Cliquez sur une offre à gauche pour afficher les détails ici.</p>
          <a id="candid" class="btn apply-btn btn-primary mt-3" style="display: none;">Voir Candidatures</a>
          <ul id="liste"></ul>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  const candidaturesParOffre = <?= json_encode($candidaturesParOffre) ?>;
  const listeElement = document.getElementById('liste');
  const candidBtn = document.getElementById('candid');
  let currentOffreId = null;

  function loadDetails(titre, description, entreprise, idOffre) {
    document.getElementById('detailTitle').innerText = titre;
    document.getElementById('detailCompany').innerText = entreprise;
    document.getElementById('detailDesc').innerText = description;
    candidBtn.style.display = 'inline-block';
    currentOffreId = idOffre;
    candidBtn.href = "candidateurs.php?id_offre=" + currentOffreId;
    listeElement.innerHTML = ''; // reset list
  }
</script>

</body>
</html>

<?php 
} else {
  header('location: ../../index/index.html');
  exit;
}
?>
