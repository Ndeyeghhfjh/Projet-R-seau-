<?php
// Connexion à la base de données
$host = 'localhost'; 
$dbname = 'smarttech'; 
$username = 'root'; 
$password = ''; 

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur de connexion : " . $e->getMessage()]);
    exit();
}

// Récupérer les dossiers
$query = "SELECT * FROM dossiers ORDER BY creation_date DESC";
$stmt = $pdo->query($query);
$dossiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les documents
$documentsQuery = "SELECT document.*, dossiers.name AS dossier_name
                   FROM document 
                   LEFT JOIN dossiers ON document.dossier_id = dossiers.id 
                   ORDER BY upload_date DESC";
$documentsStmt = $pdo->query($documentsQuery);
$documents = $documentsStmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Système de Gestion - Documents</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
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

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Système de Gestion</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
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

<div class="container mt-4">
    <div class="row">
        <!-- Liste des dossiers -->
        <div class="col-md-3">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Dossiers</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#addFolderModal">
                        <i class="fas fa-folder-plus"></i> Ajouter
                    </button>
                </div>
                <div class="card-body">
                    <ul class="list-group folder-list">
                        <?php foreach ($dossiers as $dossier): ?>
                            <li class="list-group-item"><?= htmlspecialchars($dossier['name']); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Liste des documents -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Documents</h5>
                      <a href="upload.php" class="btn btn-primary">
                        <i class="fas fa-upload"></i> Téléverser
                      </a>

                </div>
                <div class="card-body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Dossier</th>
                                <th>Ajouté par</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tbody>
                          <?php if (!empty($documents)): ?>
                              <?php foreach ($documents as $doc): ?>
                                  <tr>
                                      <td><?= htmlspecialchars($doc['nom'] ?? 'N/A') ?></td>
                                      <td><?= htmlspecialchars($doc['typedoc'] ?? 'N/A') ?></td>
                                      <td><?= htmlspecialchars($doc['dossier_id'] ?? 'N/A') ?></td>
                                      <td><?= htmlspecialchars($doc['ajoute_par'] ?? 'N/A') ?></td>
                                      <td><?= htmlspecialchars($doc['date_ajout'] ?? 'N/A') ?></td>
                                      <td>
                                      <td>
                                        <a href="modifier.php?id=<?= urlencode($doc['iddoc'] ?? '') ?>" class="btn btn-warning btn-sm">Modifier</a>
                                        <a href="telecharger.php?id=<?= urlencode($doc['iddoc'] ?? '') ?>" class="btn btn-success btn-sm">Télécharger</a>
                                        <a href="supprimer.php?id=<?= urlencode($doc['iddoc'] ?? '') ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');">Supprimer</a>
                                     </td>
>
                                      </td>
                                  </tr>
                              <?php endforeach; ?>
                          <?php else: ?>
                              <tr><td colspan="6">Aucun document trouvé.</td></tr>
                          <?php endif; ?>

                       </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ajout Dossier -->
<div class="modal fade" id="addFolderModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Créer un dossier</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
            <form action="ajouter_dossier.php" method="POST">
              <input type="text" name="folderName" placeholder="Nom du dossier" required>
              <input type="text" name="description" placeholder="Description">
              <input type="text" name="createdBy" placeholder="Créé par" required>
              <button type="submit">Créer</button>
            </form>

            </div>
        </div>
    </div>
</div>

<script>
document.getElementById("addFolderForm").addEventListener("submit", function (event) {
    event.preventDefault();

    let folderName = document.getElementById("folderName").value.trim();
    if (folderName === "") {
        alert("Le nom du dossier est requis.");
        return;
    }

    fetch("add_folder.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "folderName=" + encodeURIComponent(folderName),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Ajouter directement le dossier à la liste
            let folderList = document.querySelector(".folder-list");
            let newFolder = document.createElement("li");
            newFolder.classList.add("list-group-item");
            newFolder.textContent = folderName;
            folderList.prepend(newFolder);

            // Fermer le modal et réinitialiser le formulaire
            document.getElementById("addFolderForm").reset();
            let modal = bootstrap.Modal.getInstance(document.getElementById("addFolderModal"));
            modal.hide();
        } else {
            alert("Erreur: " + data.message);
        }
    })
    .catch(error => console.error("Erreur:", error));
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
