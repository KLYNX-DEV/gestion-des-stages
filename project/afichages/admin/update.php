<?php
session_start();

if (isset($_SESSION['admin'])) {


   
        require_once "../../database/config.php";

        class Update {
            private $pdo;

            function __construct() {
                $db = new Database();
                $this->pdo = $db->getPDO();

                $statement = $this->pdo->prepare("UPDATE admins 
                    SET nom_admin = :nom, 
                        prenom_admin = :prenom, 
                        image_admin = :img
                    WHERE id_admin = :id");
                $file_name = $_FILES['image_admin']['name'];
                $tempname = $_FILES['image_admin']['tmp_name'];
                $folder = 'uploads/';
                $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                $allowed = ['jpg', 'jpeg', 'png', 'gif'];
                if(in_array($extension,$allowed)){
                move_uploaded_file($tempname,$folder.$file_name);

                $statement->bindParam(':nom', $_POST['nom_admin']);
                $statement->bindParam(':prenom', $_POST['prenom_admin']);
                $statement->bindParam(":img",$file_name);
                $statement->bindParam(':id', $_POST['id_admin']); 
                $statement->execute();
header("location: admin.php");
               
                
            }
        }
    }

        new Update();

    } 
 else {

    header('Location: ../../index/index.html');
    exit();
}
?>
