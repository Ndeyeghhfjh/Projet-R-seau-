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

    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Dossiers</h5>
            </div>
            <div class="card-footer">
              <button
                class="btn btn-primary btn-sm w-100"
                data-bs-toggle="modal"
                data-bs-target="#addFolderModal"
              >
                <i class="fas fa-folder-plus me-1"></i> Nouveau dossier
              </button>
            </div>
          </div>
        </div>

        <div class="col-md-9">
          <div class="card">
            <div
              class="card-header d-flex justify-content-between align-items-center"
            >
              <h5 class="mb-0">Documents</h5>
              <div>
                <button
                  class="btn btn-primary"
                  data-bs-toggle="modal"
                  data-bs-target="#uploadDocumentModal"
                >
                  <i class="fas fa-upload me-1"></i> Téléverser
                </button>
              </div>
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
                    <tr>
                      <td>
                        <i class="fas fa-file-pdf text-danger me-2"></i>
                        Rapport_Annuel_2024.pdf
                      </td>
                      <td>PDF</td>
                      <td>Rapports</td>
                      <td>Jean Dupont</td>
                      <td>15/01/2025</td>
                      <td>2.4 MB</td>
                      <td class="action-buttons">
                        <button class="btn btn-sm btn-info">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-success">
                          <i class="fas fa-download"></i>
                        </button>
                        <button class="btn btn-sm btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <i class="fas fa-file-word text-primary me-2"></i>
                        Contrat_Client_TechSolutions.docx
                      </td>
                      <td>DOCX</td>
                      <td>Contrats</td>
                      <td>Sophie Martin</td>
                      <td>20/02/2025</td>
                      <td>567 KB</td>
                      <td class="action-buttons">
                        <button class="btn btn-sm btn-info">
                          <i class="fas fa-eye"></i>
                        </button>
                        <button class="btn btn-sm btn-success">
                          <i class="fas fa-download"></i>
                        </button>
                        <button class="btn btn-sm btn-danger">
                          <i class="fas fa-trash"></i>
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div
      class="modal fade"
      id="addFolderModal"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Nouveau Dossier</h5>
            <button
              type="button"
              class="btn-close btn-close-white"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form id="createFolderForm">
              <div class="mb-3">
                <label for="folderName" class="form-label">Nom du dossier</label>
                <input
                  type="text"
                  class="form-control"
                  id="folderName"
                  required
                />
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Annuler
            </button>
            <button type="submit" form="createFolderForm" class="btn btn-primary">
              Créer
            </button>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal pour téléverser un document -->
    <div
      class="modal fade"
      id="uploadDocumentModal"
      tabindex="-1"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Téléverser un document</h5>
            <button
              type="button"
              class="btn-close btn-close-white"
              data-bs-dismiss="modal"
              aria-label="Close"
            ></button>
          </div>
          <div class="modal-body">
            <form id="uploadForm" enctype="multipart/form-data">
              <div class="mb-4">
                <div
                  class="file-upload-container"
                  onclick="document.getElementById('fileInput').click()"
                >
                  <input type="file" id="fileInput" class="d-none" multiple />
                  <i
                    class="fas fa-cloud-upload-alt fa-3x mb-3"
                    style="color: var(--primary-color)"
                  ></i>
                  <h5>Glissez et déposez des fichiers ici</h5>
                  <p class="text-muted mb-0">
                    ou cliquez pour sélectionner des fichiers
                  </p>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="documentName" class="form-label">Nom du document</label>
                  <input type="text" class="form-control" id="documentName" />
                </div>
                <div class="col-md-6">
                  <label for="documentFolder" class="form-label">Dossier</label>
                  <select class="form-select" id="documentFolder">
                    <option value="">Sélectionner un dossier</option>
                    <option value="contrats">Contrats</option>
                    <option value="factures">Factures</option>
                    <option value="rh">Ressources humaines</option>
                    <option value="marketing">Marketing</option>
                    <option value="projets">Projets</option>
                  </select>
                </div>
              </div>

              <div class="mb-3">
                <label for="documentDescription" class="form-label">Description</label>
                <textarea
                  class="form-control"
                  id="documentDescription"
                  rows="3"
                ></textarea>
              </div>

              <div class="row">
                <div class="col-md-6">
                  <label for="documentTags" class="form-label">Tags (séparés par des virgules)</label>
                  <input
                    type="text"
                    class="form-control"
                    id="documentTags"
                    placeholder="rapport, annuel, finance"
                  />
                </div>
                <div class="col-md-6">
                  <label for="documentAccess" class="form-label">Niveau d'accès</label>
                  <select class="form-select" id="documentAccess">
                    <option value="public">Public (tous les utilisateurs)</option>
                    <option value="restricted">Restreint (certains utilisateurs)</option>
                    <option value="private">Privé (moi uniquement)</option>
                  </select>
                </div>
              </div>
            </form>
            <div id="fileDetails" class="mt-3"></div>
          </div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-secondary"
              data-bs-dismiss="modal"
            >
              Annuler
            </button>
            <button type="button" class="btn btn-primary" id="uploadBtn">
              Téléverser
            </button>
          </div>
        </div>
      </div>
    </div>

    <footer class="footer">
      <div class="container text-center">
        <p>© 2025 Système de Gestion. Tous droits réservés.</p>
      </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
      document.getElementById("fileInput").addEventListener("change", function(event) {
        let file = event.target.files[0];
        if (file) {
          document.getElementById("fileDetails").innerHTML = ` 
            <strong>Fichier sélectionné :</strong> ${file.name} <br/> 
            <strong>Type :</strong> ${file.type} <br/> 
            <strong>Taille :</strong> ${(file.size / 1024).toFixed(2)} KB
          `;
        }
      });

      document.getElementById("uploadBtn").addEventListener("click", function() {
        let fileInput = document.getElementById("fileInput");
        if (fileInput.files.length > 0) {
          document.getElementById("uploadForm").submit();
        } else {
          alert("Veuillez sélectionner un fichier avant de téléverser.");
        }
      });
    </script>
  </body>
</html>
