<?php
// Connexion à la base
$host = 'localhost';
$dbname = 'smarttech';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $docId = $_GET['id'];

    // Récupérer le nom du fichier dans la base
    $sql = "SELECT nom FROM document WHERE iddoc = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $docId, PDO::PARAM_INT);
    $stmt->execute();
    $document = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($document) {
        $fileName = $document['nom'];
        $filePath = "uploads/" . $fileName;  // 🔹 Ajouter le dossier fixe

        if (file_exists($filePath)) {
            // Forcer le téléchargement
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        } else {
            die("Erreur : Le fichier n'existe pas dans le dossier uploads.");
        }
    } else {
        die("Erreur : Document introuvable.");
    }
} else {
    die("Erreur : ID invalide.");
}
?>
