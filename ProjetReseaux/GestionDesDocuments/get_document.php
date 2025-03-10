<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'smarttech';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Récupérer les documents avec les informations du dossier
    $query = "SELECT d.id, d.nom AS document_nom, d.type, d.taille, d.upload_date, d.ajoute_par, 
                     dossier.nom AS dossier_nom
              FROM document d
              LEFT JOIN dossiers dossier ON d.dossier_id = dossier.id
              ORDER BY d.upload_date DESC";

    $stmt = $pdo->query($query);
    $documents = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['documents' => $documents]);

} catch (PDOException $e) {
    echo json_encode(['error' => 'Erreur de connexion ou récupération: ' . $e->getMessage()]);
}
?>
