<?php
session_start();

// Si l'employé est déjà connecté, rediriger vers l'accueil
if (isset($_SESSION['employe_id'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connexion à la base de données
    $servername = "localhost";
    $username = "root"; // votre utilisateur de base de données
    $password = ""; // votre mot de passe
    $dbname = "smarttech"; // votre base de données

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Récupérer les valeurs du formulaire
    $employe_nom = $_POST['nom']; // Nom
    $employe_prenom = $_POST['prenom']; // Prénom
    $employe_password = $_POST['password']; // Mot de passe

    // Protéger contre les injections SQL
    $employe_nom = $conn->real_escape_string($employe_nom);
    $employe_prenom = $conn->real_escape_string($employe_prenom);
    $employe_password = $conn->real_escape_string($employe_password);

    // Vérifier si l'employé existe dans la base de données
    $sql = "SELECT * FROM employes WHERE nom = '$employe_nom' AND prenom = '$employe_prenom' AND password = '$employe_password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // L'employé existe, démarrer une session et rediriger vers la page d'accueil
        $_SESSION['employe_id'] = $result->fetch_assoc()['id'];
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Nom, prénom ou mot de passe incorrect.";
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Connexion - Système de Gestion</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
    <div class="container mt-5">
        <h2>Se connecter</h2>
        <?php if (isset($error_message)) { echo "<div class='alert alert-danger'>$error_message</div>"; } ?>
        <form method="POST" action="connexion.php">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>
