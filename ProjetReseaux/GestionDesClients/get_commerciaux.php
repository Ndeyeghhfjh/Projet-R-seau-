<?php
header('Content-Type: application/json');

// Connexion à la base de données
$host = "localhost"; // Remplace par ton hôte
$dbname = "smarttech"; // Remplace par le nom de ta base de données
$username = "root"; // Remplace par ton utilisateur MySQL
$password = ""; // Remplace par ton mot de passe MySQL

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Requête pour récupérer les commerciaux
    $stmt = $pdo->query("SELECT id, nom FROM commerciaux");
    $commerciaux = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($commerciaux);
} catch (PDOException $e) {
    echo json_encode(["error" => "Erreur de connexion à la base de données : " . $e->getMessage()]);
}
?>
