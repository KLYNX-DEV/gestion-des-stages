<?php session_start();
if ($_SESSION['user'] && isset($_SESSION['user']) ) { ?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta name="author" content="MED AMINE HAITI ET RAYANE ELOUALID">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact KLY CARS</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .contact-header {
      background: #7494ec;
      background-size: cover;
      color: white;
      text-align: center;
      padding: 50px 0;
    }
    .contact-header .container{
        backdrop-filter: blur(25px);
        width: 100%;
    }

    .contact-header h1 {
      font-size: 3rem;
    }

    .form-control:focus {
      border-color: #007BFF;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }

    .btn-primary {
      background-color: #007BFF;
      border: none;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .contact-info {
      background-color: #f8f9fa;
      padding: 40px;
      border-radius: 10px;
    }
    .contact-info p a{
        text-decoration: none;

    }
    
  </style>
</head>

<body>

  <section class="contact-header">
    <div class="container">
      <h1 class="title">Contactez-nous</h1>
      <p class="hh">Nous sommes là pour répondre à toutes vos questions.</p>
    </div>
  </section>


  <section class="contact-section py-5">
    <div class="container">
      <div class="row">
        
        <div class="col-lg-6">
          <h2 class="mb-4">Envoyez-nous un message</h2>
          <form method="post" action="insererMsg.php">
            <div class="mb-3">
              <label for="name" class="form-label">Nom </label>
              <input type="text" name="nom" class="form-control" id="name" placeholder="Votre nom" required>
            </div>
            <div class="mb-3">
              <label for="name" class="form-label">Prenom </label>
              <input type="text" name="prenom" class="form-control" id="prename" placeholder="Votre prenom" required>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" name="email" class="form-control" id="email" placeholder="Votre email" required>
            </div>
            <div class="mb-3">
              <label for="subject" class="form-label">Sujet</label>
              <input type="text" name="sujet" class="form-control" id="subject" placeholder="Sujet de votre message">
            </div>
            <div class="mb-3">
              <label for="message" class="form-label">Message</label>
              <textarea class="form-control"name="message" id="message" rows="5" placeholder="Votre feedback" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Envoyer</button>
          </form>
        </div>


        <!-- Contact Info -->
        <div class="col-lg-6">
          <div class="contact-info">
            <h2 class="mb-4">Nos coordonnées</h2>
            <p><strong>Adresse :</strong>hay rahma sale</p>
            <p><strong>Téléphone :</strong> <a href="tel:+212668833220">+212 668833220</a></p>
            <p><strong>Email :</strong> <a href="mailto:mohammedaminehaiti@gmail.com">mohammedaminehaiti@gmail.com</a></p>
            <p><strong>instagram :</strong> <a href="https://www.instagram.com/mohamdino__">mohamdino__</a></p>
            <p><strong>Horaires :</strong><br>
              Lundi - Vendredi : 9h00 - 18h00<br>
              Samedi : 10h00 - 16h00<br>
              Dimanche : Fermé
            </p>
            <a href="../etudiant/offres.php" class="btn btn-primary">ACCEUIL</a>
          </div>
        </div>
      </div>
      
    </div>

  </section>


  <footer class="bg-dark text-light py-3 text-center">
    <p>&copy; 2025 GESTION STAGES. All rights reserved..</p>
  </footer>


</body>

</html>
<?php 
}
else{
  header('location: ../../index/index.html');
}
?>