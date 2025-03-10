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
    echo "Erreur de connexion : " . $e->getMessage();
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $folderName = isset($_POST['folderName']) ? trim($_POST['folderName']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $createdBy = isset($_POST['createdBy']) ? trim($_POST['createdBy']) : '';
    $creationDate = isset($_POST['creationDate']) ? $_POST['creationDate'] : '';

    // Vérification des champs obligatoires
    if (empty($folderName) || empty($createdBy)) {
        echo json_encode(['success' => false, 'message' => 'Le nom du dossier et "créé par" sont obligatoires.']);
        exit();
    }

    // Si la date n'est pas définie, on utilise la date actuelle
    if (empty($creationDate)) {
        $creationDate = date('Y-m-d');
    }

    try {
        // Préparer et exécuter l'insertion du dossier
        $sql = "INSERT INTO dossiers (name, description, created_by, creation_date) VALUES (:name, :description, :createdBy, :creationDate)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $folderName);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':createdBy', $createdBy);
        $stmt->bindParam(':creationDate', $creationDate);
        $stmt->execute();

        // Rediriger vers la page d'accueil ou afficher un message de succès
        echo json_encode(['success' => true, 'message' => 'Dossier ajouté avec succès.']);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
    }
}
?>
