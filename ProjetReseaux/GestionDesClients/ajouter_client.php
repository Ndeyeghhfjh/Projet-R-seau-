<?php
header('Content-Type: application/json');

// Connexion à la base de données
$host = "localhost";
$dbname = "smarttech";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Vérifie si toutes les données sont bien reçues
    if (!isset($_POST['companyName']) || !isset($_POST['contact']) || !isset($_POST['email'])) {
        echo json_encode(["success" => false, "message" => "Données manquantes"]);
        exit;
    }

    // Récupération des données du formulaire
    $companyName = $_POST['companyName'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'] ?? null;
    $dateAjout = date('Y-m-d');  // Date actuelle pour l'ajout

    // Requête SQL pour insérer le client
    $stmt = $pdo->prepare("INSERT INTO client (societe, contact, email, telephone, date_ajout) 
                           VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$companyName, $contact, $email, $telephone, $dateAjout]);

    echo json_encode(["success" => true]);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => "Erreur : " . $e->getMessage()]);
}
?>
