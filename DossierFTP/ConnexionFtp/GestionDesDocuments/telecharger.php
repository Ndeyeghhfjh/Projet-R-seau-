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

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $docId = $_GET['id'];

    // Récupérer le nom du fichier dans la base de données
    $sql = "SELECT nom, chemin_ftp FROM document WHERE iddoc = :id"; // Ajouter le chemin FTP dans la base
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $docId, PDO::PARAM_INT);
    $stmt->execute();
    $document = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($document) {
        $fileName = $document['nom'];
        $ftpFilePath = $document['chemin_ftp']; // Chemin du fichier sur le serveur FTP

        // Détails de connexion FTP
        $ftpServer = '10.106.106.75'; // Remplacez par l'adresse de votre serveur FTP
        $ftpUsername = 'ftpuser';  // Remplacez par le nom d'utilisateur FTP
        $ftpPassword = 'passer';  // Remplacez par le mot de passe FTP

        // Connexion au serveur FTP
        $ftpConn = ftp_connect($ftpServer);
        if (!$ftpConn) {
            die("Erreur de connexion au serveur FTP.");
        }

        // Authentification sur le serveur FTP
        if (!ftp_login($ftpConn, $ftpUsername, $ftpPassword)) {
            die("Erreur de connexion avec les identifiants FTP.");
        }

        // Vérifier si le fichier existe sur le serveur FTP
        if (ftp_size($ftpConn, $ftpFilePath) != -1) {
            // Définir un fichier temporaire pour le téléchargement
            $tempFilePath = tempnam(sys_get_temp_dir(), 'ftp_');

            // Télécharger le fichier depuis le serveur FTP vers le fichier temporaire
            if (ftp_get($ftpConn, $tempFilePath, $ftpFilePath, FTP_BINARY)) {
                // Forcer le téléchargement du fichier
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($fileName) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($tempFilePath));

                // Lire le fichier temporaire et envoyer le contenu au client
                readfile($tempFilePath);

                // Supprimer le fichier temporaire après le téléchargement
                unlink($tempFilePath);

                exit;
            } else {
                die("Erreur de téléchargement du fichier depuis le serveur FTP.");
            }
        } else {
            die("Erreur : Le fichier n'existe pas sur le serveur FTP.");
        }

        // Fermer la connexion FTP
        ftp_close($ftpConn);
    } else {
        die("Erreur : Document introuvable.");
    }
} else {
    die("Erreur : ID invalide.");
}
?>
