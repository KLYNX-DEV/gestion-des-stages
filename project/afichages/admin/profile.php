<?php
session_start();
if ($_SESSION['admin'] && isset($_SESSION['admin'])) {
    require_once "../../database/config.php";
    class Profile {
        private $pdo;
        function __construct() {
            $db = new Database();
            $this->pdo = $db->getPDO();
        }
        function getProfile() {
            return $_SESSION['admin'];
        }
    }

    $p = new Profile();
    $result = $p->getProfile();

    $photo = !empty($result['image_admin']) ? $result['image_admin'] : 'default.jpg';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
  <title>Modifier le Profil</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .profile-img {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #6c757d;
        cursor: pointer;
        transition: transform 0.2s ease-in-out;
    }
    .profile-img:hover {
        transform: scale(1.05);
    }
    #photo {
        display: none;
    }
  </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h4 class="card-title text-center mb-4">Modifier les informations</h4>
                    <form action="update.php" method="POST" enctype="multipart/form-data">

                        <div class="text-center mb-3">
                            <label for="photo">
                                <img  id="profilePreview" src="uploads/<?= $result['image_admin'] ?>" class="profile-img" alt="Photo de profil">
                            </label>
                            <input type="file" name="image_admin" id="photo" accept="image/*">
                        </div>

                        <input type="hidden" name="id_admin" value="<?= $result['id_admin'] ?>">

                        <div class="mb-3">
                            <label class="form-label">Nom</label>
                            <input type="text" name="nom_admin" value="<?= $result['nom_admin'] ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prénom</label>
                            <input type="text" name="prenom_admin" value="<?= $result['prenom_admin'] ?>" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email_admin" value="<?= $result['email_admin'] ?>" class="form-control" readonly>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                            <a href="admin.php" class="btn btn-primary mt-3 "><-Retour</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS Bootstrap + Preview Script -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.getElementById('photo').addEventListener('change', function(event) {
    const [file] = event.target.files;
    if (file) {
        document.getElementById('profilePreview').src = URL.createObjectURL(file);
    }
});
</script>

</body>
</html>

<?php
} else {
    header('Location: ../../index/index.html');
    exit;
}
?>
