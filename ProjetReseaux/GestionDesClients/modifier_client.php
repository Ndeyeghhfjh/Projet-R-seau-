<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "smarttech";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connexion échouée : " . $conn->connect_error);
}

$id = $_GET['id'];
$sql = "SELECT * FROM client WHERE id = $id";
$result = $conn->query($sql);
$client = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];

    $sql_update = "UPDATE client SET nom='$nom', prenom='$prenom', email='$email' WHERE id=$id";
    if ($conn->query($sql_update) === TRUE) {
        header("Location: GestionClient.php");
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
    <title>Modifier Client</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h2>Modifier Client</h2>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nom</label>
                <input type="text" class="form-control" name="nom" value="<?= $client['nom'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Prénom</label>
                <input type="text" class="form-control" name="prenom" value="<?= $client['prenom'] ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" value="<?= $client['email'] ?>" required>
            </div>
            <button type="submit" class="btn btn-success">Modifier</button>
            <a href="GestionClient.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
