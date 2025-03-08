<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Système de Gestion - Nouveau Client</title>
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

      .form-control:focus,
      .form-select:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
      }

      .form-label {
        font-weight: 500;
      }

      .required-field::after {
        content: "*";
        color: red;
        margin-left: 4px;
      }

      .form-section {
        background-color: #f8f9fa;
        padding: 15px;
        border-radius: 5px;
        margin-bottom: 20px;
      }

      .form-section-title {
        color: var(--dark-blue);
        margin-bottom: 15px;
        font-weight: 600;
      }

      .nav-tabs .nav-link.active {
        color: var(--dark-blue);
        font-weight: 500;
        border-bottom: 3px solid var(--primary-color);
      }

      .nav-tabs .nav-link {
        color: var(--primary-color);
      }
    </style>
  </head>
  <body>
    <!-- Barre de navigation -->
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
              <a class="nav-link active" href="#">Clients</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Documents</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <!-- En-tête de page -->
    <div class="page-header">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <div>
            <h1>Nouveau Client</h1>
            <p>Ajoutez un nouveau client à votre système</p>
          </div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
              <li class="breadcrumb-item">
                <a href="#" class="text-white">Accueil</a>
              </li>
              <li class="breadcrumb-item">
                <a href="#" class="text-white">Clients</a>
              </li>
              <li class="breadcrumb-item active text-white" aria-current="page">
                Nouveau Client
              </li>
            </ol>
          </nav>
        </div>
      </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h5 class="mb-0">Formulaire d'ajout de client</h5>
            </div>
            <div class="card-body">
              <!-- Onglets du formulaire -->
              <ul class="nav nav-tabs mb-4" id="clientTabs" role="tablist">
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link active"
                    id="info-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#info"
                    type="button"
                    role="tab"
                  >
                    Informations générales
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="contact-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#contact"
                    type="button"
                    role="tab"
                  >
                    Contacts
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="address-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#address"
                    type="button"
                    role="tab"
                  >
                    Adresses
                  </button>
                </li>
                <li class="nav-item" role="presentation">
                  <button
                    class="nav-link"
                    id="settings-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#settings"
                    type="button"
                    role="tab"
                  >
                    Paramètres
                  </button>
                </li>
              </ul>

              <!-- Contenu des onglets -->
              <div class="tab-content" id="clientTabsContent">
                <!-- Onglet Informations générales -->
                <div
                  class="tab-pane fade show active"
                  id="info"
                  role="tabpanel"
                  aria-labelledby="info-tab"
                >
                  <form>
                    <div class="form-section">
                      <h5 class="form-section-title">
                        Informations de l'entreprise
                      </h5>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label
                            for="companyName"
                            class="form-label required-field"
                            >Nom de l'entreprise</label
                          >
                          <input
                            type="text"
                            class="form-control"
                            id="companyName"
                            required
                          />
                        </div>
                        <div class="col-md-6">
                          <label for="companyType" class="form-label"
                            >Type d'entreprise</label
                          >
                          <select class="form-select" id="companyType">
                            <option value="">Sélectionner...</option>
                            <option value="sarl">SARL</option>
                            <option value="sa">SA</option>
                            <option value="sas">SAS</option>
                            <option value="eurl">EURL</option>
                            <option value="ei">Entreprise Individuelle</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label for="siret" class="form-label required-field"
                            >SIRET</label
                          >
                          <input
                            type="text"
                            class="form-control"
                            id="siret"
                            required
                          />
                        </div>
                        <div class="col-md-6">
                          <label for="vatNumber" class="form-label"
                            >Numéro TVA</label
                          >
                          <input
                            type="text"
                            class="form-control"
                            id="vatNumber"
                          />
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label for="industry" class="form-label"
                            >Secteur d'activité</label
                          >
                          <select class="form-select" id="industry">
                            <option value="">Sélectionner...</option>
                            <option value="tech">Technologie</option>
                            <option value="finance">Finance</option>
                            <option value="health">Santé</option>
                            <option value="education">Éducation</option>
                            <option value="manufacturing">Industrie</option>
                            <option value="retail">Commerce de détail</option>
                            <option value="other">Autre</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label for="employees" class="form-label"
                            >Nombre d'employés</label
                          >
                          <select class="form-select" id="employees">
                            <option value="">Sélectionner...</option>
                            <option value="1-10">1-10</option>
                            <option value="11-50">11-50</option>
                            <option value="51-200">51-200</option>
                            <option value="201-500">201-500</option>
                            <option value="500+">500+</option>
                          </select>
                        </div>
                      </div>
                    </div>

                    <div class="form-section">
                      <h5 class="form-section-title">
                        Informations commerciales
                      </h5>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label for="clientCategory" class="form-label"
                            >Catégorie de client</label
                          >
                          <select class="form-select" id="clientCategory">
                            <option value="standard">Standard</option>
                            <option value="premium">Premium</option>
                            <option value="vip">VIP</option>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <label for="assignedTo" class="form-label"
                            >Assigné à</label
                          >
                          <select class="form-select" id="assignedTo">
                            <option value="">
                              Sélectionner un commercial...
                            </option>
                            <option value="1">Jean Dupont</option>
                            <option value="2">Sophie Martin</option>
                            <option value="3">Thomas Petit</option>
                          </select>
                        </div>
                      </div>
                      <div class="row mb-3">
                        <div class="col-md-6">
                          <label for="acquisitionSource" class="form-label"
                            >Source d'acquisition</label
                          >
                          <select class="form-select" id="acquisitionSource">
                            <option value="">Sélectionner...</option>
                            <option value="website">Site web</option>
                            <option value="referral">Recommandation</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>