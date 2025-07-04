<?php
session_start();
if (!isset($_SESSION['user'])) {
    header('Location: ../../index/index.html');
    exit;
    
}
    require_once "../../database/config.php";
 class Profile {
        private $pdo;
        function __construct() {
            $db = new Database();
            $this->pdo = $db->getPDO();
        }
        function getProfile() {
            $stmt = $this->pdo->prepare("SELECT * FROM etudiants WHERE id_etu = :id_etu");
            $stmt->bindParam(":id_etu",$_SESSION['user']['id_etu']);
            $stmt->execute();
            return $stmt->fetch();
        }
    }

    $p = new Profile();
    $result = $p->getProfile();


?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
  <title>Profil Étudiant</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <style>
    /* Reset basique */
    * {
      box-sizing: border-box;
    }
    body {
      margin: 0;
      background: linear-gradient(to right, #3498db, #2c3e50);
      min-height: 100vh;
      color: white;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      padding: 50px 20px;
      display: flex;
      justify-content: center;
      align-items: flex-start;
    }
    .profile-container {
      max-width: 700px;
      width: 100%;
      background: rgba(255, 255, 255, 0.1);
      border-radius: 15px;
      padding: 30px;
      backdrop-filter: blur(10px);
      box-shadow: 0 8px 32px rgba(0,0,0,0.4);
      text-align: center;
      align-items:center;
    }
    .profile-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #fff;
      cursor: pointer;
      margin: 0 auto;       
      display: block;       
      margin-bottom: 20px;
      transition: box-shadow 0.3s ease;

    }
    .profile-img:hover {
      box-shadow: 0 0 10px 3px #ffe600;
    }
    input[type="text"],
    input[type="email"],
    textarea,
    input[type="file"] {
      width: 100%;
      padding: 10px 12px;
      margin-top: 6px;
      margin-bottom: 16px;
      border: none;
      border-radius: 6px;
      background-color: rgba(255,255,255,0.2);
      color: white;
      font-size: 1rem;
      resize: vertical;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    textarea:focus {
      outline: none;
      border: 1px solid #ffe600;
      background-color: rgba(255,255,255,0.3);
    }
    textarea {
      min-height: 100px;
    }
    label {
      display: block;
      font-weight: 600;
      margin-bottom: 4px;
      color: #fff;
      text-align: left;
    }
    button.btn-save {
      background-color: #ffe600;
      color: #000;
      font-weight: bold;
      border: none;
      border-radius: 8px;
      padding: 12px 20px;
      font-size: 1.1rem;
      cursor: pointer;
      width: 100%;
      transition: background-color 0.3s ease;
    }
    button.btn-save:hover {
      background-color: #ffcc00;
    }
    a.btn-cv {
      display: inline-block;
      text-decoration: none;
      background-color: #27ae60;
      color: #fff;
      font-weight: bold;
      padding: 10px 15px;
      border-radius: 8px;
      margin-bottom: 16px;
      transition: background-color 0.3s ease;
    }
    a.btn-cv:hover {
      background-color: #219150;
    }
    .hidden-file-input {
      display: none;
    }
    .row {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-top: 20px;
      text-align: left;
    }
    .col-half {
      flex: 1 1 48%;
    }
    .col-full {
      flex: 1 1 100%;
    }
    .btn-retour {
      margin-top: 5px;
      width: 100%;
  display: inline-block;
  padding: 10px 20px;
  background-color: #6c757d; /* gris foncé */
  color: white;
  text-decoration: none;
  border-radius: 5px;
  font-weight: bold;
  transition: background-color 0.3s;
}

.btn-retour:hover {
  background-color: #5a6268;
}
  </style>
</head>
<body>

<div class="profile-container">
  <form action="update.php" method="POST" enctype="multipart/form-data" id="profileForm">
    <input type="hidden" name="id_etu" value="<?=$result['id_etu']?>">
    <label for="profileImgInput" title="Cliquez pour changer la photo">
      <img src="uploads/profile_pics/<?=$result['profile_etu']?>" alt="Photo de profil" class="profile-img" id="profilePreview">
    </label>
    <input type="file" name="profile_img" id="profileImgInput" class="hidden-file-input" accept="image/*">

    <h3><?= htmlspecialchars($result['nom_etu']) ?>'s Profile</h3>
    <p>Gérez vos informations de profil ci-dessous.</p>

    <div class="row">
      <div class="col-half">
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom_etu" value="<?= htmlspecialchars($result['prenom_etu']) ?>">
      </div>
      <div class="col-half">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom_etu" value="<?= htmlspecialchars($result['nom_etu']) ?>">
      </div>
      <div class="col-full">
        <label for="email">Email</label>
        <input type="email" id="email" name="email_etu" value="<?= htmlspecialchars($result['email_etu']) ?>" readonly>
      </div>
      <div class="col-full">
        <label for="competences">Compétences</label>
        <textarea id="competences" name="competence" placeholder="Listez vos compétences ici..."><?= htmlspecialchars($result['competence']) ?></textarea>
      </div>
    </div>

    
      <div class="col-full" style="margin-top: 10px;">
        <label for="cv">changer le CV</label>
        <input type="file" name="cv" id="cv" accept=".pdf,.doc,.docx" style="width: 100%;">
      </div>


    <button type="submit" class="btn-save">Enregistrer les modifications</button>
    <a class="btn-retour" href="offres.php">retour</a>
  </form>
</div>

<script>
  document.getElementById('profilePreview').addEventListener('click', function() {
    document.getElementById('profileImgInput').click();
  });

  document.getElementById('profileImgInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function(e) {
      document.getElementById('profilePreview').src = e.target.result;
    }
    reader.readAsDataURL(file);
  });
</script>

</body>
</html>
