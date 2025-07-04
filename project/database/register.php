<?php
require_once 'config.php';

class Register {
    private $pdo;

    public function __construct() {
        try {
            // ✅ Crée une instance de Database et récupère le PDO
            $db = new Database();
            $this->pdo = $db->getPDO();

            $statement = $this->pdo->prepare("SELECT * FROM etudiants WHERE email_etu = :email");
            $statement->bindParam(":email",$_POST['email']);
            $statement->execute();
            $email = $statement->fetch();
            if(!$email){
            
            $sql = "INSERT INTO etudiants (nom_etu, prenom_etu, email_etu, password_etu) 
                    VALUES (:v1, :v2, :v3, :v4)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':v1', $_POST['nom']);
            $stmt->bindParam(':v2', $_POST['prenom']);
            $stmt->bindParam(':v3', $_POST['email']);
            $stmt->bindParam(':v4', $_POST['password']);
            $stmt->execute();

            header("Location: ../index/index.html");
            exit();
            }
            else{
                header("location: ../index/email_utiliser.html");
            }
            

        } catch (PDOException $e) {
            die("Erreur de base de données : " . $e->getMessage());
        }
    }
}

new Register();
?>
