<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../../index/index.html');
    exit;
}

require_once "../../database/config.php";

class Candidateurs {
    private $pdo;

    function __construct() {
        try {
            $db = new Database();
            $this->pdo = $db->getPDO();
        } catch (PDOException $e) {
            die("Erreur de base de données : " . $e->getMessage());
        }
    }

    function getCandidateurs($id_offre, $search = null) {
        $sql = "
            SELECT c.*, o.id_offre, o.titre, e.nom_etu, e.prenom_etu, e.email_etu, e.cv, e.profile_etu
            FROM candidatures c
            JOIN etudiants e ON c.id_etu = e.id_etu
            JOIN offres o ON c.id_offre = o.id_offre
            WHERE c.id_offre = :id_offre
        ";

        if ($search) {
            $sql .= " AND (e.nom_etu LIKE :search OR e.prenom_etu LIKE :search OR e.email_etu LIKE :search )";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(":id_offre", $id_offre);

        if ($search) {
            $likeSearch = "%$search%";
            $stmt->bindParam(":search", $likeSearch);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }
}

$id_offre = $_GET['id_offre'] ?? null;
if (!$id_offre) {
    die("Erreur : id_offre manquant.");
}

$search = $_GET['search'] ?? null;

$can = new Candidateurs();
$candidateurs = $can->getCandidateurs($id_offre, $search);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
    <title>Liste des candidateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Liste de tous les candidateurs</h2>

    <form method="GET" action="" class="mb-4 d-flex">
        <input 
            type="text" 
            name="search" 
            class="form-control me-2" 
            placeholder="Rechercher un candidat (nom, prénom, email, )..."
            value="<?= $search ?>"
        >
        <!-- Important : garder l'id_offre dans le formulaire -->
        <input type="hidden" name="id_offre" value="<?= $id_offre ?>">

        <button type="submit" class="btn btn-primary">Rechercher</button>
    </form>

    <table class="table table-bordered table-hover text-center align-middle">
        <thead class="table-dark">
            <tr>
                <th>Photo</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Titre d'offre</th>
                <th>cv</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (count($candidateurs) === 0): ?>
            <tr>
                <td colspan="6" class="text-muted">Aucun candidat trouvé.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($candidateurs as $candidateur): ?>
                <tr>
                    <td>
                        <?php if (!empty($candidateur['profile_etu'])): ?>
                            <img src="../etudiant/uploads/profile_pics/<?= $candidateur['profile_etu'] ?>" width="60" height="60" class="rounded-circle" alt="Photo de <?= $candidateur['nom_etu'] ?>">
                        <?php else: ?>
                            <span class="text-muted">Aucune</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $candidateur['nom_etu'] ?></td>
                    <td><?= $candidateur['prenom_etu'] ?></td>
                    <td><?= $candidateur['email_etu'] ?></td>
                    <td><?= $candidateur['titre'] ?></td>
                    <td>
                        <?php if($candidateur['cv']){ ?>
                        <a href="../etudiant/cv.php?id_cand=<?= $candidateur['id_cand'] ?>" class="btn btn-secondary">voir cv</a>
                    <?php } 
                    else{?>aucun cv <?php } ?>
                    </td>
                    <td>
                        <?php if ($candidateur['etat'] == "envoyée"): ?>
                            <a href="etat.php?etat=accepte&id_cand=<?= $candidateur['id_cand'] ?>&id_offre=<?= $candidateur['id_offre'] ?>" 
                               class="btn btn-warning btn-sm" 
                               onclick="return confirm('Êtes-vous sûr de vouloir accepter cette candidature ?');">
                                Accepter
                            </a>

                            <a href="etat.php?etat=refuser&id_cand=<?= $candidateur['id_cand'] ?>&id_offre=<?= $candidateur['id_offre'] ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Êtes-vous sûr de vouloir refuser cette candidature ?');">
                                Refuser
                            </a>
                        <?php else: ?>
                            <p>
                                <?= $candidateur['etat'] ?> 
                                <a href="modifieretat.php?id_cand=<?= $candidateur['id_cand'] ?>&id_offre=<?= $candidateur['id_offre'] ?>" class="btn btn-primary p-1">
                                    Modifier
                                </a>
                            </p>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <a href="admin.php" class="btn btn-primary"> <- retour</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
