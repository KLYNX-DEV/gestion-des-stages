<?php
session_start();

if (!isset($_SESSION['admin'])) {
    header('Location: ../../index/index.html');
    exit();
}
require_once "../../database/config.php";
$db = new Database();
$pdo = $db->getPDO();

$stmt = $pdo->query("SELECT * FROM messages ORDER BY date_envoi DESC");
$stmt->execute();
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
    <title>Messages reçus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body>
    
<div class="container my-5">

    <h1 class="mb-4 text-center">Messages des étudiants</h1>

    <?php if (count($messages) === 0): ?>
        <div class="alert alert-info" role="alert">
            Aucun message reçu pour l'instant.
        </div>
    <?php else: ?>

        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th scope="col">Sujet</th>
                        <th scope="col">Nom & Prénom</th>
                        <th scope="col">Email</th>
                        <th scope="col">Date d'envoi</th>
                        <th scope="col" style="width: 150px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($messages as $msg): ?>
                    <tr>
                        <td><?= $msg['sujet'] ?: '(Pas de sujet)' ?></td>
                        <td><?= $msg['nom'] ?> <?= $msg['prenom'] ?></td>
                        <td>
                            <a href="mailto:<?= $msg['email'] ?>" class="text-decoration-none">
                                <i class="bi bi-envelope-fill"></i> <?= $msg['email'] ?>
                            </a>
                        </td>
                        <td><i class="bi bi-calendar-event"></i> <?= $msg['date_envoi'] ?></td>
                        <td>
                            <!-- Bouton afficher -->
                            <button 
                                type="button" 
                                class="btn btn-sm btn-primary me-2" 
                                data-bs-toggle="modal" 
                                data-bs-target="#viewMessageModal" 
                                data-subject="<?= $msg['sujet']  ?>"
                                data-message="<?= $msg['message'] ?>"
                                data-sender="<?= $msg['nom'] . ' ' . $msg['prenom'] ?>"
                                data-email="<?= $msg['email']?>"
                                data-date="<?= $msg['date_envoi'] ?>"
                            >
                                <i class="bi bi-eye"></i> Afficher
                            </button>


                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $msg['id'] ?>">
                                <i class="bi bi-trash"></i> Supprimer
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

    <?php endif; ?>

</div>

<div class="modal fade" id="viewMessageModal" tabindex="-1" aria-labelledby="viewMessageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewMessageModalLabel">Détails du message</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <h5 id="modalSubject"></h5>
        <p><strong>Expéditeur :</strong> <span id="modalSender"></span></p>
        <p><strong>Email :</strong> <a href="#" id="modalEmailLink"></a></p>
        <p><strong>Date d'envoi :</strong> <span id="modalDate"></span></p>
        <hr />
        <p id="modalMessage" style="white-space: pre-wrap;"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <form method="POST" action="delete_message.php" id="deleteForm">
        <input type="hidden" name="id" id="deleteId" value="">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLabel">Confirmer la suppression</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
          </div>
          <div class="modal-body">
            Êtes-vous sûr de vouloir supprimer ce message ? Cette action est irréversible.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
            <button type="submit" class="btn btn-danger">Supprimer</button>
          </div>
        </div>
    </form>
    
  </div>
</div>
  <a href="admin.php" class="btn btn-primary ms-5 mb-3"><-Retour</a>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const viewModal = document.getElementById('viewMessageModal');
    viewModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        document.getElementById('modalSubject').textContent = button.getAttribute('data-subject');
        document.getElementById('modalSender').textContent = button.getAttribute('data-sender');
        const email = button.getAttribute('data-email');
        const emailLink = document.getElementById('modalEmailLink');
        emailLink.textContent = email;
        emailLink.href = 'mailto:' + email;
        document.getElementById('modalDate').textContent = button.getAttribute('data-date');
        document.getElementById('modalMessage').textContent = button.getAttribute('data-message');
    });

    // Modal suppression : passer l'id au formulaire
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget;
        const messageId = button.getAttribute('data-id');
        document.getElementById('deleteId').value = messageId;
    });
</script>
</body>
</html>
