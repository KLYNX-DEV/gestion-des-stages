<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: ../../index/index.html');
    exit();
}

require_once "../../database/config.php";

class Update {
    private $pdo;

    function __construct() {
        $db = new Database();
        $this->pdo = $db->getPDO();

        $id = $_POST['id_etu'];
        $nom = $_POST['nom_etu'];
        $prenom = $_POST['prenom_etu'];
        $competence = $_POST['competence'];

        $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE id_etu = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $current = $stmt->fetch();

       $profile_img = $current['profile_etu'];
$cv = $current['cv'];

// upload image profil
if (isset($_FILES['profile_img']) && $_FILES['profile_img']['error'] === 0) {
    $file_name = $_FILES['profile_img']['name'];
    $tempname = $_FILES['profile_img']['tmp_name'];
    $folder = 'uploads/profile_pics/';
    $extension = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($extension, $allowed)) {
        move_uploaded_file($tempname, $folder . $file_name);
        $profile_img = $file_name;
    }
}

// upload cv
if (isset($_FILES['cv']) && $_FILES['cv']['error'] === 0) {
    $cv_name = $_FILES['cv']['name'];
    $cv_tmp = $_FILES['cv']['tmp_name'];
    $cv_folder = 'uploads/cv/';
    $cv_extension = strtolower(pathinfo($cv_name, PATHINFO_EXTENSION));
    $allowed_cv = ['pdf', 'doc', 'docx'];

    if (in_array($cv_extension, $allowed_cv)) {
        move_uploaded_file($cv_tmp, $cv_folder . $cv_name);
        $cv = $cv_folder . $cv_name;
    }
}

if (empty($cv)) {
    $cv = '';
}

$statement = $this->pdo->prepare("
    UPDATE etudiants 
    SET nom_etu = :nom, 
        prenom_etu = :prenom, 
        competence = :competence,
        profile_etu = :profile, 
        cv = :cv 
    WHERE id_etu = :id
");

$statement->bindParam(':nom', $nom);
$statement->bindParam(':prenom', $prenom);
$statement->bindParam(':competence', $competence);
$statement->bindParam(':profile', $profile_img);
$statement->bindParam(':cv', $cv);
$statement->bindParam(':id', $id);
$statement->execute();

        header("Location: etudiant.php");
        exit();
    }
}

new Update();
