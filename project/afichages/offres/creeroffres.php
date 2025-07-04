<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../../index/index.html');
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
    <title>Créer une offre</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container mt-5">
    <h1 class="mb-4">Créer une nouvelle offre</h1>
    <form action="insere_offres.php" method="post" class="needs-validation" novalidate>
        <div class="mb-3">
            <label for="title" class="form-label">Titre de l'offre</label>
            <input type="text" class="form-control" id="title" name="titre" required>
            <div class="invalid-feedback">
                Veuillez entrer un titre pour l'offre.
            </div>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
            <div class="invalid-feedback">
                Veuillez entrer une description.
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label for="price" class="form-label"> entreprise</label>
                <input type="text" step="0.01" min="0" class="form-control" id="price" name="entreprise" required>
                <div class="invalid-feedback">
                    Veuillez entrer un prix valide.
                </div>
            </div>

            <div class="col-md-4">
                <label for="start_date" class="form-label">Date de début</label>
                <input type="date" class="form-control" id="start_date" name="date_debut" required>
                <div class="invalid-feedback">
                    Veuillez sélectionner une date de début.
                </div>
            </div>

            <div class="col-md-4">
                <label for="end_date" class="form-label">Date de fin</label>
                <input type="date" class="form-control" id="end_date" name="date_fin" required>
                <div class="invalid-feedback">
                    Veuillez sélectionner une date de fin.
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Créer l'offre</button>
        <a href="../admin/admin.php" class="btn btn-primary">annuler</a>
    </form>
</div>

<!-- Bootstrap JS et Popper.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Exemple simple de validation Bootstrap personnalisée
(() => {
  'use strict'
  const forms = document.querySelectorAll('.needs-validation')
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }
      form.classList.add('was-validated')
    }, false)
  })
})()
</script>
</body>
</html>
