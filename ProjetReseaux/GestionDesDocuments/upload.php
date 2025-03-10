<?php
$host = 'localhost';
$dbname = 'smarttech'; // Nom de la base de données
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Vérification du fichier
        if (isset($_FILES['fileInput']) && $_FILES['fileInput']['error'] == 0) {
            $file = $_FILES['fileInput'];
            $fileName = basename($file['name']);
            $fileTmpPath = $file['tmp_name'];
            $fileSize = $file['size'];
            $fileType = $file['type'];

            // Définir le dossier d'upload
            $uploadDir = 'uploads/';
            $uploadFile = $uploadDir . $fileName;

            // Déplacer le fichier dans le dossier d'upload
            if (move_uploaded_file($fileTmpPath, $uploadFile)) {
                // Récupérer les données du formulaire
                $dossierId = $_POST['dossier_id'];
                $addedBy = $_POST['addedBy'];

                // Insertion dans la base de données
                $sql = "INSERT INTO document (name, type, dossier_id, added_by, size, file_path) VALUES (:name, :type, :dossierId, :addedBy, :size, :filePath)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':name', $fileName);
                $stmt->bindParam(':type', $fileType);
                $stmt->bindParam(':dossierId', $dossierId);
                $stmt->bindParam(':addedBy', $addedBy);
                $stmt->bindParam(':size', $fileSize);
                $stmt->bindParam(':filePath', $uploadFile);

                if ($stmt->execute()) {
                    echo json_encode(['success' => true, 'message' => 'Document téléchargé avec succès']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Erreur lors de l\'upload du document']);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Erreur lors du déplacement du fichier']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Aucun fichier téléchargé']);
        }
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur de connexion à la base de données: ' . $e->getMessage()]);
}
?>
