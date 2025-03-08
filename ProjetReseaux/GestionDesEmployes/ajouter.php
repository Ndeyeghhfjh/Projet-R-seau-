<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $poste = mysqli_real_escape_string($conn, $_POST['poste']);
    $salaire = mysqli_real_escape_string($conn, $_POST['salaire']);
    $date_embauche = mysqli_real_escape_string($conn, $_POST['date_embauche']);
    $departement = mysqli_real_escape_string($conn, $_POST['departement']);

    $sql = "INSERT INTO employes (nom, prenom, email, poste, salaire, date_embauche, departement) 
            VALUES ('$nom', '$prenom', '$email', '$poste', '$salaire', '$date_embauche', '$departement')";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur : " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Employé</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
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

        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #343a40;
            font-weight: bold;
            margin-bottom: 20px;
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

        .footer {
            background-color: var(--dark-blue);
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }

        .btn-secondary:hover {
            background-color: var(--dark-blue);
            border-color: var(--dark-blue);
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h2>Ajouter un Employé</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label required-field">Nom :</label>
                <input type="text" id="nom" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label required-field">Prénom :</label>
                <input type="text" id="prenom" name="prenom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label required-field">Email :</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="poste" class="form-label required-field">Poste :</label>
                <input type="text" id="poste" name="poste" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="salaire" class="form-label required-field">Salaire :</label>
                <input type="number" id="salaire" name="salaire" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="date_embauche" class="form-label required-field">Date d'embauche :</label>
                <input type="date" id="date_embauche" name="date_embauche" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="departement" class="form-label required-field">Département :</label>
                <input type="text" id="departement" name="departement" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter l'Employé</button>
            <a href="index.php" class="btn btn-secondary ms-3">Retour à l'Accueil</a>
        </form>
    </div>

    <footer class="footer text-center">
        <p>&copy; 2025 Système de Gestion des Employés</p>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
</body>
</html>
