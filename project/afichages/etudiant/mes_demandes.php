<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../../index/index.html'); 
    exit;
}

require_once "../../database/config.php";

class MesDemandes {
    private $pdo;
    private $id_etu;

    public function __construct() {
        try {
            $db = new Database();
            $this->pdo = $db->getPDO();
        } catch (PDOException $e) {
            die("Erreur base de données : " . $e->getMessage());
        }
    }

    public function getDemandes() {
        $sql = "
            SELECT c.*, o.titre, o.description, o.created_at
            FROM candidatures c
            JOIN offres o ON c.id_offre = o.id_offre
            WHERE c.id_etu = :id_etu
            ORDER BY c.date_postulation DESC
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id_etu', $_SESSION['user']['id_etu']);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}


$mesDemandes = new MesDemandes();
$demandes = $mesDemandes->getDemandes();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
    <title>Mes demandes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-center">Mes candidatures aux offres</h2>

    <?php if (empty($demandes)): ?>
        <p class="text-center text-muted">Vous n'avez postulé à aucune offre pour le moment.</p>
    <?php else: ?>
        <table class="table table-bordered table-hover text-center align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Titre de l'offre</th>
                    <th>Description</th>
                    <th>Date de publication</th>
                    <th>État de la candidature</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($demandes as $demande): ?>
                <tr>
                    <td><?= $demande['titre'] ?></td>
                    <td><?= nl2br(($demande['description'])) ?></td>
                    <td><?= date('d/m/Y', strtotime($demande['date_postulation'])) ?></td>
                    <td>
                        <?php
                        $etat = $demande['etat'];
                        if ($etat == 'envoyée') {
                            echo '<span class="badge bg-warning text-dark">Envoyée</span>';
                        } elseif ($etat == 'accepte') {
                            echo '<span class="badge bg-success text-dark">Acceptée</span>';
                        } elseif ($etat == 'refuser') {
                            echo '<span class="badge bg-danger text-dark">Refusée</span>';
                        } else {
                            echo htmlspecialchars($etat);
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    <a href="offres.php" class="btn btn-primary"><-Retour</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
