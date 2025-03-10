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

// Exécuter la requête pour obtenir le nombre d'employés
$result_employes = $conn->query("SELECT COUNT(*) AS count FROM employes");

// Vérifier si la requête a été exécutée correctement
if ($result_employes) {
    // Récupérer le résultat sous forme de tableau associatif
    $row_employes = $result_employes->fetch_assoc();
    
    // Récupérer le nombre d'employés
    $employes_count = $row_employes['count'];
    
    
} else {
    echo "Erreur lors de la récupération du nombre d'employés : " . $conn->error;
}


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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
    <style>
      body { background-color: #f8f9fa; }
      .navbar { background-color: #084298; }
      .navbar-brand, .nav-link { color: white !important; }
      .footer { background-color: #084298; color: white; padding: 20px 0; margin-top: 40px; }
      .card {
        border-color: #0d6efd;
        transition: transform 0.3s;
        margin-bottom: 20px;
      }
      .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }
      .card-header {
        background-color: #0d6efd;
        color: white;
      }
      .btn-primary {
        background-color: #0d6efd;
        border-color: #0d6efd;
      }
      .btn-primary:hover {
        background-color: #084298;
        border-color: #084298;
      }
    </style>
  </head>
  <body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="index.php">Smart-Tech</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
            <li class="nav-item"><a class="nav-link" href="GestionDesEmployes/index.php">Employés</a></li>
            <li class="nav-item"><a class="nav-link" href="GestionDesClients/GestionClient.php">Clients</a></li>
            <li class="nav-item"><a class="nav-link" href="GestionDesDocuments/GestionDocument.php">Documents</a></li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Contenu principal -->
    <div class="container mt-4">
      <div class="row">
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Gestion des Employés</div>
            <div class="card-body">
              <p>Ajoutez, modifiez et supprimez des informations sur les employés.</p>
              <a href="GestionEmployes.php" class="btn btn-primary">Accéder</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Gestion des Clients</div>
            <div class="card-body">
              <p>Gérez efficacement vos relations clientèle et suivez les interactions.</p>
              <a href="GestionDesClients/GestionClient.php" class="btn btn-primary">Accéder</a>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">
            <div class="card-header">Gestion des Documents</div>
            <div class="card-body">
              <p>Organisez, stockez et retrouvez facilement vos documents importants.</p>
              <a href="GestionDesDocuments/GestionDocument.php" class="btn btn-primary">Accéder</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Tableau de bord -->
      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">Tableau de bord</div>
            <div class="card-body text-center">
              <div class="row">
                <div class="col-md-4"><h3><?php echo $employes_count; ?></h3><p>Employés actifs</p></div>
                <div class="col-md-4"><h3><?php echo $clients_count; ?></h3><p>Clients enregistrés</p></div>
                <div class="col-md-4"><h3><?php echo $documents_count; ?></h3><p>Documents stockés</p></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pied de page -->
    <footer class="footer text-center">
      <p>© Astou 2025 Système de Gestion. Tous droits réservés.</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>

