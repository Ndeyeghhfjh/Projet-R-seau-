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
    // Récupération des données du formulaire
    $nomDossier = isset($_POST['folderName']) ? trim($_POST['folderName']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $ajoutePar = isset($_POST['createdBy']) ? trim($_POST['createdBy']) : '';
    $dateCreation = isset($_POST['creationDate']) ? $_POST['creationDate'] : date('Y-m-d'); // Utilise la date actuelle si non fournie

    // Vérification des champs obligatoires
    if (empty($nomDossier) || empty($ajoutePar)) {
        echo json_encode(['success' => false, 'message' => 'Le nom du dossier et le champ "Ajouté par" sont obligatoires.']);
        exit();
    }

    try {
        // Insertion du dossier dans la base de données
        $sql = "INSERT INTO dossiers (name, description, created_by, creation_date) 
                VALUES (:name, :description, :created_by, :creation_date)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $nomDossier);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':created_by', $ajoutePar);
        $stmt->bindParam(':creation_date', $dateCreation);
        $stmt->execute();

        // Redirection après ajout réussi
        header("Location: GestionDocument.php?success=ajout");
        exit();

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erreur SQL: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Requête invalide.']);
}
?>
