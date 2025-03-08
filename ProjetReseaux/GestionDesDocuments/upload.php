<?php
// Vérifier si la méthode de la requête est POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES['fileInput'])) {
        $file = $_FILES['fileInput'];
        
        // Vérifier les erreurs d'upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            echo "Erreur lors de l'upload.";
            exit;
        }

        // Définir le chemin où le fichier sera stocké
        $uploadDir = 'uploads/';
        $uploadPath = $uploadDir . basename($file['name']);

        // Vérifier si le fichier existe déjà
        if (file_exists($uploadPath)) {
            echo "Le fichier existe déjà.";
            exit;
        }

        // Déplacer le fichier téléchargé dans le dossier spécifié
        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
            // Connexion à la base de données (ajoutez vos paramètres ici)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $dbname = "gestion_documents"; // Assurez-vous que la base de données existe

            // Créer une connexion
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Vérifier la connexion
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Obtenez les informations du fichier
            $fileName = $file['name'];
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileSize = $file['size'];
            $uploadDate = date("Y-m-d H:i:s");

            // Préparer et exécuter la requête d'insertion dans la base de données
            $sql = "INSERT INTO documents (file_name, file_type, file_size, upload_date) 
                    VALUES ('$fileName', '$fileType', '$fileSize', '$uploadDate')";

            if ($conn->query($sql) === TRUE) {
                echo "Le fichier a été téléchargé et les informations ont été enregistrées dans la base de données.";
            } else {
                echo "Erreur d'insertion dans la base de données: " . $conn->error;
            }

            // Fermer la connexion
            $conn->close();
        } else {
            echo "Une erreur s'est produite lors du téléchargement.";
        }
    } else {
        echo "Aucun fichier n'a été téléchargé.";
    }
}
?>
