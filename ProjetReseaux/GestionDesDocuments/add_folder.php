<?php
// Connexion à la base de données
$host = 'localhost';
$dbname = 'smarttech';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Vérifier si les données sont envoyées via POST
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nom = $_POST['nom'];
        $description = $_POST['description'];
        $cree_par = $_POST['cree_par'];
        $creation_date = $_POST['creation_date'];

        // Insérer le dossier dans la base de données
        $query = "INSERT INTO dossiers (nom, description, cree_par, creation_date) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($query);
        $stmt->execute([$nom, $description, $cree_par, $creation_date]);

        // Récupérer l'ID du dossier ajouté
        $id = $pdo->lastInsertId();

        echo json_encode(['success' => true, 'id' => $id, 'nom' => $nom]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Méthode non autorisée']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Erreur : ' . $e->getMessage()]);
}
?>
