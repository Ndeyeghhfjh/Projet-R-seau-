<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "smarttech"; // Correction du nom de la base de données

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Échec de la connexion : " . $conn->connect_error);
}
?>
