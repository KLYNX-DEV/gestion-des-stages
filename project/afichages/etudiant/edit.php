<?php 
session_start();
if ($_SESSION['user'] && isset($_SESSION['user']) ) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <div class="form-container">
  <h2>Modifier Étudiant</h2>
  <form action="update.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id_etu" value="<?= $_SESSION['user']['id_etu'] ?>">

    
    <label>Nom</label>
    <input type="text" name="nom_etu" value="<?= $_SESSION['user']['nom_etu'] ?>" required>
    
    <label>Prénom</label>
    <input type="text" name="prenom_etu" value="<?=  $_SESSION['user']['prenom_etu'] ?>" required>
    
    <label>Email</label>
    <input type="email" name="email_etu" value="<?=  $_SESSION['user']['email_etu'] ?>" readonly>
    
    <label>Formation</label>
    <textarea name="formation"><?=  $_SESSION['user']['formation'] ?></textarea>

    <label>Compétence</label>
    <textarea name="competence"><?=  $_SESSION['user']['competence'] ?></textarea>

    <div class="btn-container">
        <button type="submit" class="btn">Enregistrer les modifications</button>
    </div>
  </form>
</div>
</body>
</html>
<?php }
else{
  header('location: ../../index/index.html');
}
?>