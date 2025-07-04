<?php
session_start();
if(!isset($_SESSION['user'])){
header('Location: ../../index/index.html');  exit;
}
require_once "../../database/config.php" ;

class Offres{
  private $pdo;
  function __construct(){
    try {
            $db = new Database();
            $this->pdo = $db->getPDO();

            $sql = "INSERT INTO candidatures (id_etu, id_offre) 
                    VALUES (:v1, :v2)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':v1', $_SESSION['user']['id_etu']);
            $stmt->bindParam(':v2', $_GET['id_offre']);
            $stmt->execute();
            header("location: offres.php") ;
            exit();
        } catch (PDOException $e) {
            die("Erreur de base de données : " . $e->getMessage());
        }
  }
  
}
new Offres();

?>