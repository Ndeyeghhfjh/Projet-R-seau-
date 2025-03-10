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

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérifier si un fichier a été téléversé
    if (isset($_FILES['document']) && $_FILES['document']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['document'];
        $nom = basename($file['name']);
        $type = $file['type'];
        $taille = $file['size'];
        $tmpPath = $file['tmp_name'];

        // Vérification de la taille (max 5MB)
        if ($taille > 5 * 1024 * 1024) {
            echo "<p style='color: red;'>Erreur : Le fichier est trop volumineux (max 5MB).</p>";
            exit();
        }

        // Connexion au serveur FTP
        $conn_id = ftp_connect($ftp_host);

        if (!$conn_id) {
            die("Impossible de se connecter au serveur FTP.");
        }

        // Connexion avec les informations d'identification FTP
        if (!ftp_login($conn_id, $ftp_user, $ftp_pass)) {
            die("Impossible de se connecter avec les informations d'identification FTP.");
        }

        // Changer le répertoire de travail si nécessaire
        $uploadDir = 'uploads/';
        if (!ftp_chdir($conn_id, $uploadDir)) {
            echo "<p style='color: red;'>Le répertoire de destination n'existe pas sur le serveur FTP.</p>";
            ftp_close($conn_id);
            exit();
        }

        // Uploader le fichier vers le serveur FTP
        if (ftp_put($conn_id, $nom, $tmpPath, FTP_BINARY)) {
            try {
                // Insérer les informations dans la base de données
                $sql = "INSERT INTO document (nom, typedoc, taille, ajoute_par) VALUES (:nom, :typedoc, :taille, 'Admin')";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':typedoc', $type);
                $stmt->bindParam(':taille', $taille);
                $stmt->execute();

                echo "<p style='color: green;'>Fichier téléversé avec succès sur FTP.</p>";
                // Rediriger vers la liste des documents après téléversement
                header("Location: gestion_documents.php");
                exit();
            } catch (PDOException $e) {
                echo "Erreur SQL : " . $e->getMessage();
            }
        } else {
            echo "<p style='color: red;'>Erreur lors du téléversement sur le serveur FTP.</p>";
        }

        // Fermer la connexion FTP
        ftp_close($conn_id);
    } else {
        echo "<p style='color: red;'>Aucun fichier sélectionné ou erreur lors de l'envoi.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uploader un Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Uploader un Document sur FTP</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="document" class="form-label">Sélectionner un fichier</label>
                <input type="file" class="form-control" id="document" name="document" required>
            </div>
            <div class="mb-3">
                <label for="typedoc" class="form-label">Type de document</label>
                <input type="text" class="form-control" id="typedoc" name="typedoc" required>
            </div>
            <button type="submit" class="btn btn-primary">Téléverser</button>
            <a href="GestionDocument.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
