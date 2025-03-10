<?php
// Connexion à la base de données
$host = 'localhost'; // Adresse du serveur MySQL
$dbname = 'smarttech'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur MySQL
$password = ''; // Mot de passe MySQL (vide si vous utilisez un environnement local)

try {
    // Créer la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Définir l'option d'erreur pour afficher les erreurs SQL
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si la connexion échoue, afficher une erreur
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}

// Récupérer les dossiers de la base de données
$query = "SELECT * FROM dossiers ORDER BY creation_date DESC";
$stmt = $pdo->query($query);
$dossiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les documents associés à un dossier
$documentsQuery = "SELECT * FROM document ORDER BY upload_date DESC";
$documentsStmt = $pdo->query($documentsQuery);
$documents = $documentsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Système de Gestion - Documents</title>
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
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

      .page-header {
        background: linear-gradient(
          135deg,
          var(--primary-color),
          var(--dark-blue)
        );
        color: white;
        padding: 30px 0;
        margin-bottom: 30px;
      }

      .table thead {
        background-color: var(--primary-color);
        color: white;
      }

      .action-buttons .btn {
        margin-right: 5px;
      }

      .document-card {
        transition: transform 0.3s;
      }

      .document-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
      }

      .document-icon {
        font-size: 2.5rem;
        color: var(--primary-color);
      }

      .file-upload-container {
        border: 2px dashed var(--primary-color);
        border-radius: 5px;
        padding: 30px;
        text-align: center;
        background-color: var(--light-blue);
        cursor: pointer;
        transition: all 0.3s;
      }

      .file-upload-container:hover {
        background-color: #e8f0fe;
      }

      .folder-list .list-group-item {
        cursor: pointer;
        transition: all 0.2s;
      }

      .folder-list .list-group-item:hover {
        background-color: var(--light-blue);
      }

      .folder-list .list-group-item.active {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
      }
    </style>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="#">Système de Gestion</a>
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
              <a class="nav-link" href="#">Accueil</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Employés</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Clients</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="#">Documents</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="page-header">
      <div class="container">
        <h1>Gestion des Documents</h1>
        <p>Organisez, stockez et retrouvez facilement vos documents</p>
      </div>
    </div>

    <!-- Liste des dossiers -->
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Dossiers</h5>
              <button
                class="btn btn-primary btn-sm"
                data-bs-toggle="modal"
                data-bs-target="#addFolderModal"
              >
                <i class="fas fa-folder-plus"></i> Ajouter un dossier
              </button>
            </div>
            <div class="card-body">
              <ul class="list-group folder-list">
                <!-- Liste des dossiers sera ajoutée dynamiquement ici -->
              </ul>
            </div>
          </div>
        </div>

        <!-- Documents -->
        <div class="col-md-9">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Documents</h5>
              <button
                class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#uploadDocumentModal"
              >
                <i class="fas fa-upload me-1"></i> Téléverser
              </button>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Type</th>
                      <th>Dossier</th>
                      <th>Ajouté par</th>
                      <th>Date d'ajout</th>
                      <th>Taille</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!-- Les documents seront ajoutés dynamiquement ici -->
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal pour ajouter un dossier -->
    <div class="modal fade" id="addFolderModal" tabindex="-1" aria-labelledby="addFolderModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="addFolderModalLabel">Créer un nouveau dossier</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="addFolderForm">
              <div class="mb-3">
                <label for="folderName" class="form-label">Nom du dossier</label>
                <input type="text" class="form-control" id="folderName" required />
              </div>
              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" rows="3"></textarea>
              </div>
              <div class="mb-3">
                <label for="createdBy" class="form-label">Créé par</label>
                <input type="text" class="form-control" id="createdBy" required />
              </div>
              <div class="mb-3">
                <label for="creationDate" class="form-label">Date de création</label>
                <input type="date" class="form-control" id="creationDate" required />
              </div>
              <button type="submit" class="btn btn-primary w-100">Créer</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal pour téléverser un document -->
    <div class="modal fade" id="uploadDocumentModal" tabindex="-1" aria-labelledby="uploadDocumentModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="uploadDocumentModalLabel">Téléverser un document</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form id="uploadDocumentForm" enctype="multipart/form-data">
              <div class="mb-3">
                <label for="documentFile" class="form-label">Choisir un fichier</label>
                <input type="file" class="form-control" id="documentFile" name="fileInput" required />
              </div>
              <div class="mb-3">
                <label for="documentFolder" class="form-label">Dossier</label>
                <select class="form-control" id="documentFolder" name="dossier_id" required>
                  <option value="">Sélectionner un dossier</option>
                  <!-- Les dossiers seront ajoutés dynamiquement ici -->
                  <!-- Exemple de dossier -->
                  <!-- <option value="1">Dossier 1</option> -->
                </select>
              </div>
              <div class="mb-3">
                <label for="addedBy" class="form-label">Ajouté par</label>
                <input type="text" class="form-control" id="addedBy" name="addedBy" required />
              </div>
              <button type="submit" class="btn btn-primary w-100">Téléverser</button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Charger les dossiers dynamiquement
      fetch("get_folders.php")
        .then((response) => response.json())
        .then((data) => {
          const folderSelect = document.getElementById("documentFolder");
          data.folders.forEach((folder) => {
            const option = document.createElement("option");
            option.value = folder.id;
            option.textContent = folder.name;
            folderSelect.appendChild(option);
          });
        })
        .catch((error) => {
          console.error("Erreur lors de la récupération des dossiers:", error);
        });

      // Gestion de l'upload de fichier
      document.getElementById("uploadDocumentForm").addEventListener("submit", function (event) {
        event.preventDefault(); // Empêcher la soumission classique du formulaire

        let formData = new FormData(this);

        fetch("upload.php", {
          method: "POST",
          body: formData,
        })
          .then((response) => response.json())
          .then((data) => {
            if (data.success) {
              alert(data.message);
              location.reload(); // Rafraîchir la page pour afficher les documents
            } else {
              alert(data.message);
            }
          })
          .catch((error) => {
            console.error("Erreur lors de l'upload:", error);
            alert("Une erreur est survenue lors de l'upload.");
          });
      });
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
  </body>
</html>