<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'smarttech';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer tous les dossiers
    $query = "SELECT id, nom FROM dossiers ORDER BY creation_date DESC";
    $stmt = $pdo->query($query);
    $dossiers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['dossiers' => $dossiers]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion ou récupération: ' . $e->getMessage()]);
}
?>
