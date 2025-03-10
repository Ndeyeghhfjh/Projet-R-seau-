<?php
// Connexion à la base de données
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

// Vérifier si un ID est fourni dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $docId = $_GET['id'];

    try {
        // Vérifier si le document existe avant de le supprimer
        $checkSql = "SELECT chemin FROM document WHERE iddoc = :id";
        $checkStmt = $pdo->prepare($checkSql);
        $checkStmt->bindParam(':id', $docId, PDO::PARAM_INT);
        $checkStmt->execute();
        $document = $checkStmt->fetch(PDO::FETCH_ASSOC);

        if ($document) {
            // Supprimer le fichier du serveur (optionnel)
            $filePath = $document['chemin'];
            if (file_exists($filePath)) {
                unlink($filePath); // Supprime le fichier physique
            }

            // Supprimer le document de la base de données
            $sql = "DELETE FROM document WHERE iddoc = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $docId, PDO::PARAM_INT);
            $stmt->execute();

            // Redirection après suppression
            header("Location: GestionDocument.php?success=1");
            exit();
        } else {
            echo "Document introuvable.";
        }
    } catch (PDOException $e) {
        echo "Erreur lors de la suppression : " . $e->getMessage();
    }
} else {
    echo "ID de document invalide.";
}
?>
