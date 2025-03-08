<?php
// Connexion à la base de données
$servername = "localhost";
$username = "root"; // votre utilisateur de base de données
$password = ""; // votre mot de passe
$dbname = "smarttech"; // votre base de données

$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifiez la connexion
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Récupérer le nombre d'employés
$sql_employes = "SELECT COUNT(*) AS count FROM employes";
$result_employes = $conn->query($sql_employes);
$row_employes = $result_employes->fetch_assoc();
$employes_count = $row_employes['count'];

// Récupérer le nombre de clients enregistrés
$sql_clients = "SELECT COUNT(*) AS count FROM client";
$result_clients = $conn->query($sql_clients);
$row_clients = $result_clients->fetch_assoc();
$clients_count = $row_clients['count'];

// Récupérer le nombre de documents stockés
$sql_documents = "SELECT COUNT(*) AS count FROM document";
$result_documents = $conn->query($sql_documents);
$row_documents = $result_documents->fetch_assoc();
$documents_count = $row_documents['count'];

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Système de Gestion - Accueil</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <style>
      :root {
        --primary-color: #0d6efd;
        --secondary-color: #6c757d;
        --accent-color: #0dcaf0;
        --light-blue: #cfe2ff;
        --dark-blue: #084298;
      }

      body {
        background-color: #f8f9fa;
      }

      .navbar {
        background-color: var(--dark-blue);
      }

      .navbar-brand,
      .nav-link {
        color: white !important;
      }

      .card {
        border-color: var(--primary-color);
        transition: transform 0.3s;
        margin-bottom: 20px;
      }

      .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }

      .card-header {
        background-color: var(--primary-color);
        color: white;
      }

      .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
      }

      .btn-primary:hover {
        background-color: var(--dark-blue);
        border-color: var(--dark-blue);
      }

      .footer {
        background-color: var(--dark-blue);
        color: white;
        padding: 20px 0;
        margin-top: 40px;
      }

      .hero-section {
        background: linear-gradient(
          135deg,
          var(--primary-color),
          var(--dark-blue)
        );
        color: white;
        padding: 60px 0;
        margin-bottom: 40px;
      }
    </style>
  </head>

  <body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Smart-Tech</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" href="#">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#employes">Employés</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#clients">Clients</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#documents">Documents</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Section d'en-tête -->
    <div class="hero-section">
      <div class="container text-center">
        <h1>Système de Gestion Intégré</h1>
        <p class="lead">
          Une solution complète pour gérer vos employés, clients et documents
        </p>
      </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
      <div class="row">
        <div class="col-md-4">
          <div class="card" id="employes">
            <div class="card-header">
              <h5 class="mb-0">Gestion des Employés</h5>
            </div>
            <div class="card-body">
              <p>
                Ajoutez, modifiez et supprimez des informations sur les
                employés.
              </p>
              <a href="GestionEmployes.html" class="btn btn-primary">Accéder</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card" id="clients">
            <div class="card-header">
              <h5 class="mb-0">Gestion des Clients</h5>
            </div>
            <div class="card-body">
              <p>
                Gérez efficacement vos relations clientèle et suivez les
                interactions.
              </p>
              <a href="GestionDesClients/GestionClient.php" class="btn btn-primary">Accéder</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card" id="documents">
            <div class="card-header">
              <h5 class="mb-0">Gestion des Documents</h5>
            </div>
            <div class="card-body">
              <p>
                Organisez, stockez et retrouvez facilement vos documents
                importants.
              </p>
              <a href="GestionDesDocuments/GestionDocument.php" class="btn btn-primary"
                >Accéder</a
              >
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Tableau de bord</h5>
            </div>
            <div class="card-body">
              <div class="row text-center">
                <div class="col-md-4">
                  <h3><?php echo $employes_count; ?></h3>
                  <p>Employés actifs</p>
                </div>
                <div class="col-md-4">
                  <h3><?php echo $clients_count; ?></h3>
                  <p>Clients enregistrés</p>
                </div>
                <div class="col-md-4">
                  <h3><?php echo $documents_count; ?></h3>
                  <p>Documents stockés</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pied de page -->
    <footer class="footer mt-5">
      <div class="container text-center">
        <p>© Astou 2025 Système de Gestion. Tous droits réservés.</p>
      </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
