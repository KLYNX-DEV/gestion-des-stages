
<?php 
session_start();
if ($_SESSION['user'] && isset($_SESSION['user'])) {

require_once '../../database/config.php';

class Etudiant {
    private $pdo;

    public function __construct() {
        try {
            $db = new Database();
            $this->pdo = $db->getPDO();
            if (!empty("etudiants['profile_etu']")) {
                $stmt = $this->pdo->prepare("UPDATE etudiants SET profile_etu = :v1 WHERE profile_etu IS NULL");
                $profile = 'profileetu.jpeg';
                $stmt->bindParam(':v1', $profile);
                $stmt->execute();
            }
        } catch (PDOException $e) {
            die("Erreur de base de données : " . $e->getMessage());
        }
    }

    public function getEtudiantById() {
        $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE id_etu = :v1");
        $stmt->bindParam(':v1', $_GET['id']);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function offres() {
        $stmt = $this->pdo->prepare("SELECT * FROM offres WHERE id_offre NOT IN (SELECT id_offre FROM candidatures  WHERE id_etu = :id_etu) ORDER BY date_debut DESC");
        $stmt->bindParam(":id_etu",$_SESSION['user']['id_etu']);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}

$etu = new Etudiant();
$info_etu = $etu->getEtudiantById();
$offres = $etu->offres();
$today =  new DateTime();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Offres de Stage</title>
  <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="offres.css">
  <style>
    @media (min-width: 768px) {
      .offer-list {
        border-right: 1px solid #dee2e6;
      }
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="../../index/logo.png" alt="Logo">
    </a>
    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link " href="mes_demandes.php">mes dmds</a></li>
        <li class="nav-item"><a class="nav-link" href="etudiant.php">Profile</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Offres</a></li>
        <li class="nav-item"><a class="nav-link" href="pr.php">Add CV</a></li>
        <li class="nav-item"><a class="nav-link" href="../contact/contact.php">Contact</a></li>
      </ul>
    </div>

    <div class="d-flex align-items-center dec">
      <i class="bi bi-person-fill fs-5 me-2"></i>
      <a href="../../index/deconnexion.php" class="text-white me-3 text-decoration-none">Deconnexion</a>
    </div>
  </div>
</nav>

<h1 class="mt-4">Nos Offres de Stage</h1>

<div class="container-fluid">
  <div class="row g-4 flex-column-reverse flex-md-row">

    <!-- Liste des offres -->
    <div class="col-md-5 offer-list">
      <?php foreach ($offres as $o): 
        if($o['date_fin']<$today){
        ?>
        <div class="offer-card" onclick="loadDetails('<?= addslashes($o['titre']) ?>', '<?= addslashes($o['description']) ?>', '<?= addslashes($o['entreprise']) ?>', <?= $o['id_offre'] ?>)">
          <div class="offer-title"><?= $o['titre'] ?></div>
          <div class="text-muted small"><?= $o['entreprise'] ?> · Remote</div>
          <span class="badge badge-stage mt-2">Stage</span>
          <div class="text-muted mt-2" style="font-size: 0.85em;">
            Candidature simplifiée<br>
            Début : <?= $o['date_debut'] ?>
          </div>
        </div>
      <?php } endforeach; ?>
    </div>

    <!-- Détails de l'offre -->
    <div class="col-md-7">
      <div class="detail-panel" id="detailPanel">
        <h4 id="detailTitle">Sélectionnez une offre</h4>
        <p class="text-muted" id="detailCompany">Aucune entreprise sélectionnée.</p>
        <p id="detailDesc">Cliquez sur une offre à gauche pour afficher les détails ici.</p>
        <form action="postuler.php" method="post">
  <input type="hidden" name="id_offre" id="id_offre_input" value="">
  <button type="submit" id="candid" class="apply-btn mt-3" style="display: none;">Postuler</button>
</form>
      </div>
    </div>

  </div>
</div>

<script>
  const formPostuler = document.querySelector('form[action^="postuler.php"]');
  const candidBtn = document.getElementById('candid');
  let currentOffreId = null;

  function loadDetails(titre, description, entreprise, idOffre) {
    document.getElementById('detailTitle').innerText = titre;
    document.getElementById('detailCompany').innerText = entreprise;
    document.getElementById('detailDesc').innerText = description;
    candidBtn.style.display = 'inline-block';
    formPostuler.action = `postuler.php?id_offre=${idOffre}`;
    currentOffreId = idOffre;
  }
  const idOffreInput = document.getElementById('id_offre_input');


</script>

</body>
</html>

<?php 
} else {
  header('location: ../../index/index.html');
  exit;
}
?>
