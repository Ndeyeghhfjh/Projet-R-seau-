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

$sql = "DELETE FROM client WHERE id = $id";
if ($conn->query($sql) === TRUE) {
    header("Location: GestionClient.php");
    exit();
} else {
    echo "Erreur : " . $conn->error;
}

$conn->close();
?>
