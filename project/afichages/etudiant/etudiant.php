<?php
session_start();
if ($_SESSION['user'] && isset($_SESSION['user'])) {
require_once "../../database/config.php";

class Etudiants {
  private $pdo;

  function __construct() {
    try {
      $db = new Database();
      $this->pdo = $db->getPDO();
    } catch (PDOException $e) {
      die("Erreur de base de données : " . $e->getMessage());
    }
  


  } 
  function getEtu(){
    $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE id_etu = :id_etu");
    $stmt->bindParam(":id_etu",$_SESSION['user']['id_etu']);
    $stmt->execute();
    return $stmt->fetch();
  }
  }
  $etu = new Etudiants();
   $etu = $etu->getEtu();
   $_SESSION['user'] = $etu;
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
  <title>Student Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      padding: 0;
      background: linear-gradient(to right, #2c3e50, #3498db);
      background-size: cover;
      height: 100vh;
      color: white;
      font-family: 'Segoe UI', sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .dashboard {
      backdrop-filter: blur(10px);
      background: rgba(255, 255, 255, 0.1);
      border-radius: 16px;
      padding: 40px;
      width: 90%;
      max-width: 1000px;
      display: flex;
      gap: 30px;
      box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
    }
    .profile-img {
      width: 140px;
      height: 140px;
      border-radius: 50%;
      overflow: hidden;
      border: 4px solid #fff;
      cursor: pointer;
    }
    .profile-img img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .info {
      flex: 1;
    }
    .info h2 {
      color: #fff;
    }
    .info p {
      color: #ddd;
    }
    .links a {
      margin-right: 20px;
      color: #fff;
      font-weight: 500;
      text-decoration: none;
      transition: 0.3s;
    }
    .links a:hover {
      color: #ffe600;
      text-decoration: underline;
    }
    .edit-profile {
      margin-top: 15px;
    }
    .edit-profile a {
      text-decoration: none;
      font-size: 14px;
      color: #ccc;
    }
    .edit-profile a:hover {
      color: #fff;
    }
  </style>
</head>
<body>
<?php
var_dump($etu['profile_etu']);
?>
<div class="dashboard">
  <div class="profile-section text-center">
    <div class="profile-img" onclick="window.location.href='pr.php'">
      <img src="uploads/profile_pics/<?=$etu['profile_etu']?>" alt="Profile">
    </div>
    <div class="edit-profile">
      <a href="pr.php"><i class="bi bi-pencil-square"></i> Edit Profile</a>
    </div>
  </div>

  <div class="info">
    <h2>Welcome, <?= $_SESSION['user']['nom'] ?? 'Student'; ?> 👋</h2>
    <p>Welcome to your internship management platform. Apply for offers, manage your documents, and track your journey here.</p>
    <div class="links mt-4">
      <a href="offres.php"><i class="bi bi-briefcase-fill"></i> Offers</a>
      <a href="cv.php"><i class="bi bi-upload"></i> voir CV</a>
      <a href="../contact/contact.php"><i class="bi bi-envelope-fill"></i> Contact</a>
      <a href="../../index/deconnexion.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
  </div>
</div>

</body>
</html>
<?php 
} else {
  header('Location: ../../index/index.html');
  exit;
}
?>
