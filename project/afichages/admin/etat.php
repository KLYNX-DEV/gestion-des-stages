<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../../index/index.html');
    exit;
}

require_once "../../database/config.php";

class Etat {
    private $pdo;

    function __construct() {
        try {
            $db = new Database();
            $this->pdo = $db->getPDO();
        } catch (PDOException $e) {
            die("Erreur de base de données : " . $e->getMessage());
        }
    }

    function getIdEtu() {
        $stmt = $this->pdo->prepare("SELECT id_etu FROM etudiants WHERE id_etu IN (SELECT id_etu FROM candidatures where id_cand = :id_cand)");
        $stmt->bindParam(":id_cand",$_GET['id_cand']);
        $stmt->execute();
        return $stmt->fetch();
    }

    function ChangeEtat() {
        if (!isset($_GET['etat']) || !isset($_GET['id_offre'])) {
            die("Paramètres manquants.");
        }


  

        if ($_GET['etat'] == "accepte") {
            $etat = "acceptée";
        } elseif ($_GET['etat'] == "refuser") {
            $etat = "refusée";
        } else {
            die("État invalide.");
        }

        $stmt = $this->pdo->prepare("UPDATE candidatures SET etat = :etat WHERE id_cand = :id_cand AND id_offre = :id_offre LIMIT 1");

        $stmt->bindParam(":etat", $etat);
        $stmt->bindParam(":id_cand", $_GET['id_cand']);
        $stmt->bindParam(":id_offre", $_GET['id_offre']);
        $stmt->execute();

        header("Location: candidateurs.php?id_offre=" . $_GET['id_offre']);
        exit;
    }
}

$etat = new Etat();
$etat->ChangeEtat();


