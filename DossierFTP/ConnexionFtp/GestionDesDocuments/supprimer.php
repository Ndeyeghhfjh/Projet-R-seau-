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

// Informations de connexion FTP
$ftp_host = '10.106.106.75';  // Remplacer par votre adresse FTP
$ftp_user = 'ftpuser';     // Nom d'utilisateur FTP
$ftp_pass = 'passer';     // Mot de passe FTP

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
            // Connexion au serveur FTP
            $conn_id = ftp_connect($ftp_host);

            if (!$conn_id) {
                die("Impossible de se connecter au serveur FTP.");
            }

            // Connexion avec les informations d'identification FTP
            if (!ftp_login($conn_id, $ftp_user, $ftp_pass)) {
                die("Impossible de se connecter avec les informations d'identification FTP.");
            }

            // Supprimer le fichier sur le serveur FTP
            $filePath = $document['chemin'];  // Le chemin du fichier sur le serveur FTP
            if (ftp_delete($conn_id, $filePath)) {
                echo "<p style='color: green;'>Fichier supprimé avec succès du serveur FTP.</p>";
            } else {
                echo "<p style='color: red;'>Erreur lors de la suppression du fichier sur le serveur FTP.</p>";
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
