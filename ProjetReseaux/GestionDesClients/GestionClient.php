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

// Récupérer le nombre de clients enregistrés
$sql_clients = "SELECT COUNT(*) AS count FROM client";
$result_clients = $conn->query($sql_clients);
$row_clients = $result_clients->fetch_assoc();
$clients_count = $row_clients['count'];

// Récupérer les clients
$sql = "SELECT * FROM client";
$result = $conn->query($sql);

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Gestion des Clients</title>
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
        margin-bottom: 20px;
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
              <a class="nav-link" href="index.php">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="GestionDesClients/GestionClient.php">Clients</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="GestionDesEmployes/index.php">Employés</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="GestionDesDocuments/GestionDocument.php">Documents</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- Section d'en-tête -->
    <div class="hero-section">
      <div class="container text-center">
        <h1>Gestion des Clients</h1>
        <p class="lead">
          Gérez efficacement vos relations clientèle et suivez les interactions
        </p>
      </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Liste des Clients</h2>
        <a href="Nouveauclient.php" class="btn btn-primary">Créer un Nouveau Client</a>
      </div>

      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom de l'entreprise</th>
            <th>Type</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Afficher les clients récupérés depuis la base de données
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              echo "<tr>
                      <td>" . $row['idclient'] . "</td>
                      <td>" . htmlspecialchars($row['societe']) . "</td>
                      <td>" . htmlspecialchars($row['contact']) . "</td>
                      <td>" . htmlspecialchars($row['email']) . "</td>
                      <td>
                        <a href='voir-client.php?id=" . $row['idclient'] . "' class='btn btn-sm btn-info'>Voir</a>
                        <a href='modifier-client.php?id=" . $row['idclient'] . "' class='btn btn-sm btn-warning'>Modifier</a>
                        <a href='supprimer-client.php?id=" . $row['idclient'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Voulez-vous vraiment supprimer ce client ?\");'>Supprimer</a>
                      </td>
                    </tr>";
            }
          } else {
            echo "<tr><td colspan='5'>Aucun client trouvé</td></tr>";
          }
          ?>
        </tbody>
      </table>

      <div class="row mt-4">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Statistiques</h5>
            </div>
            <div class="card-body">
              <div class="row text-center">
                <div class="col-md-4">
                  <h3><?php echo $clients_count; ?></h3>
                  <p>Clients enregistrés</p>
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
