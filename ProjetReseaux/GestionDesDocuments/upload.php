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

        // Déplacer le fichier dans le dossier "uploads"
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $filePath = $uploadDir . $nom;

        if (move_uploaded_file($tmpPath, $filePath)) {
            try {
                // Insérer les infos dans la base de données
                $sql = "INSERT INTO document (nom, typedoc, taille, ajoute_par) VALUES (:nom, :typedoc, :taille, 'Admin')";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':nom', $nom);
                $stmt->bindParam(':typedoc', $type);
                $stmt->bindParam(':taille', $taille);
                $stmt->execute();

                echo "<p style='color: green;'>Fichier téléversé avec succès.</p>";
                // Rediriger vers la liste des documents après téléversement
                header("Location: gestion_documents.php");
                exit();

            } catch (PDOException $e) {
                echo "Erreur SQL : " . $e->getMessage();
            }
        } else {
            echo "<p style='color: red;'>Erreur lors du téléversement.</p>";
        }
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
        <h2>Uploader un Document</h2>
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
