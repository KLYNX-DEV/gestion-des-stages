<?php
require_once '../../database/config.php';

class Contact {
    private $pdo;

    public function __construct() {
        try {

            $db = new Database();
            $this->pdo = $db->getPDO();

            
            $sql = "INSERT INTO messages (nom, prenom, email, sujet ,message) 
                    VALUES (:v1, :v2, :v3, :v4,:v5)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':v1', $_POST['nom']);
            $stmt->bindParam(':v2', $_POST['prenom']);
            $stmt->bindParam(':v3', $_POST['email']);
            $stmt->bindParam(':v4', $_POST['sujet']);
            $stmt->bindParam(':v5', $_POST['message']);
            $stmt->execute();
            header("Location: ../etudiant/offres.php");
            exit();
            

        } catch (PDOException $e) {
            die("Erreur de base de données : " . $e->getMessage());
        }
    }
}

new Contact();
?>
