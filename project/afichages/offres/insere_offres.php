<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../../index/index.html');
    exit();
}
require_once "../../database/config.php" ;

class Offres{
  private $pdo;
  function __construct(){
    try {
            $db = new Database();
            $this->pdo = $db->getPDO();

            $sql = "INSERT INTO offres (titre, entreprise, id_admin, description, date_debut, date_fin ) 
                    VALUES (:v1, :v2, :v3, :v4, :v5, :v6)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':v1', $_POST['titre']);
            $stmt->bindParam(':v2', $_POST['entreprise']);
            $stmt->bindParam(':v3', $_SESSION['admin']['id_admin']);
            $stmt->bindParam(':v4', $_POST['description']);
            $stmt->bindParam(':v5', $_POST['date_debut']);
            $stmt->bindParam(':v6', $_POST['date_fin']);
            $stmt->execute();
           $lastId = $this->pdo->lastInsertId();
            header("location: ../admin/admin.php");
            exit();
        } catch (PDOException $e) {
            die("Erreur de base de données : " . $e->getMessage());
        }
  }
  
}
new Offres();

?>