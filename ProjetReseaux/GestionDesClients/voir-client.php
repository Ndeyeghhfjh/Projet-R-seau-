<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smarttech";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

// Vérifier si un ID est bien passé en paramètre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID client manquant.");
}

$id = intval($_GET['id']); // Sécuriser l'entrée pour éviter l'injection SQL

// Correction de la requête avec `idclient`
$sql = "SELECT * FROM client WHERE idclient = $id";
$result = $conn->query($sql);

// Vérifier si le client existe
if ($result->num_rows == 0) {
    die("Client introuvable.");
}

$client = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Client</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Détails du Client</h2>
        <p><strong>Nom de l'entreprise :</strong> <?= htmlspecialchars($client['societe']) ?></p>
        <p><strong>Contact :</strong> <?= htmlspecialchars($client['contact']) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($client['email']) ?></p>
        <a href="GestionClient.php" class="btn btn-primary">Retour</a>
    </div>
</body>
</html>
