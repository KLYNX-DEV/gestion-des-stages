<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: ../../index/index.html');
    exit;

}
require_once "../../database/config.php";
class Etat{
    private $pdo;

  function __construct() {
    try {
      $db = new Database();
      $this->pdo = $db->getPDO();
      $stmt = $this->pdo->prepare('UPDATE candidatures set etat = "envoyée" WHERE id_cand = :id');
      $stmt->bindParam(":id",$_GET['id_cand']);
      $stmt->execute();
      header("location: candidateurs.php?id_offre=".$_GET['id_offre']);
      exit;
    } catch (PDOException $e) {
      die("Erreur de base de données : " . $e->getMessage());
    }
  }
}
new Etat();