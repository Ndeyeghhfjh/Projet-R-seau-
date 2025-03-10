<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Client</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Tableau de bord</a></li>
            <li class="breadcrumb-item active text-white" aria-current="page">Nouveau Client</li>
        </ol>
    </nav>

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
                                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">Informations générales</button>
                            </li>
                        </ul>

                        <!-- Contenu de l'onglet Informations générales -->
                        <div class="tab-content" id="clientTabsContent">
                            <!-- Onglet Informations générales -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel" aria-labelledby="info-tab">
                                <form action="ajouter_client.php" method="POST">
                                    <div class="form-section">
                                        <h5 class="form-section-title">Informations de l'entreprise</h5>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="companyName" class="form-label required-field">Nom de l'entreprise</label>
                                                <input type="text" class="form-control" id="companyName" name="companyName" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="contact" class="form-label required-field">Nom du contact</label>
                                                <input type="text" class="form-control" id="contact" name="contact" required />
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="email" class="form-label required-field">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" required />
                                            </div>
                                            <div class="col-md-6">
                                                <label for="telephone" class="form-label">Numéro de téléphone</label>
                                                <input type="text" class="form-control" id="telephone" name="telephone" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <button type="button" class="btn btn-secondary" onclick="window.location.href='index.html';">Retourner à l'accueil</button>
                                        <button type="submit" class="btn btn-primary">Créer Client</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
