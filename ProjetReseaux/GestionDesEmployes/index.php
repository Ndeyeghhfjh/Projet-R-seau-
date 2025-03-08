<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gestion des Employés</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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
            background: linear-gradient(135deg, var(--primary-color), var(--dark-blue));
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

        table {
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        thead {
            background: var(--primary-color);
            color: white;
        }

        tbody tr:hover {
            background: #f1f1f1;
        }

        .btn-sm {
            margin-right: 5px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #a71d2a;
        }
    </style>
</head>
<body>
    <!-- Barre de navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Système de Gestion</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Employés</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#">Clients</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Documents</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- En-tête de page -->
    <div class="page-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1>Gestion des Employés</h1>
                    <p>Liste des employés de l'entreprise</p>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="#" class="text-white">Accueil</a></li>
                        <li class="breadcrumb-item active text-white" aria-current="page">Gestion des Employés</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <a href="ajouter.php" class="btn btn-success mb-3">➕ Ajouter un Employé</a>
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Liste des Employés</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Prénom</th>
                                    <th>Email</th>
                                    <th>Poste</th>
                                    <th>Salaire (€)</th>
                                    <th>Date d'Embauche</th>
                                    <th>Département</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                include 'db.php';
                                
                                if ($conn->connect_error) {
                                    die("Échec de la connexion : " . $conn->connect_error);
                                }

                                $sql = "SELECT id, nom, prenom, email, poste, salaire, date_embauche, departement FROM employes";
                                $result = $conn->query($sql);

                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td>" . htmlspecialchars($row['id']) . "</td>
                                            <td>" . htmlspecialchars($row['nom']) . "</td>
                                            <td>" . htmlspecialchars($row['prenom']) . "</td>
                                            <td>" . htmlspecialchars($row['email']) . "</td>
                                            <td>" . htmlspecialchars($row['poste']) . "</td>
                                            <td>" . htmlspecialchars($row['salaire']) . "€</td>
                                            <td>" . htmlspecialchars($row['date_embauche']) . "</td>
                                            <td>" . htmlspecialchars($row['departement']) . "</td>
                                            <td>
                                                <a href='modifier.php?id=" . urlencode($row['id']) . "' class='btn btn-primary btn-sm'>✏️ Modifier</a>
                                                <a href='supprimer.php?id=" . urlencode($row['id']) . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Êtes-vous sûr ?\");'>🗑️ Supprimer</a>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='9' class='text-center text-muted'>Aucun employé trouvé</td></tr>";
                                }

                                $conn->close();
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
