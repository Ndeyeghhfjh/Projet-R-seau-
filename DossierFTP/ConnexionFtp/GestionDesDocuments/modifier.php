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

// Vérifier si un ID de document est fourni dans l'URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $docId = $_GET['id'];

    // Récupérer les informations actuelles du document
    $sql = "SELECT * FROM document WHERE iddoc = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $docId, PDO::PARAM_INT);
    $stmt->execute();
    $document = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$document) {
        die("Document introuvable.");
    }
} else {
    die("ID de document invalide.");
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = isset($_POST['nom']) ? trim($_POST['nom']) : '';
    $typedoc = isset($_POST['typedoc']) ? trim($_POST['typedoc']) : '';
    $descriptiondoc = isset($_POST['descriptiondoc']) ? trim($_POST['descriptiondoc']) : '';

    // Vérifier que les champs obligatoires ne sont pas vides
    if (empty($nom) || empty($typedoc)) {
        echo "<p style='color: red;'>Le nom et le type du document sont obligatoires.</p>";
    } else {
        try {
            // Mise à jour du document dans la base de données
            $sql = "UPDATE document SET nom = :nom, typedoc = :typedoc, descriptiondoc = :descriptiondoc WHERE iddoc = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':typedoc', $typedoc);
            $stmt->bindParam(':descriptiondoc', $descriptiondoc);
            $stmt->bindParam(':id', $docId, PDO::PARAM_INT);
            $stmt->execute();

            // Redirection après modification
            header("Location: GestionDocument.php?success=modification");
            exit();
        } catch (PDOException $e) {
            echo "Erreur lors de la modification : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier le Document</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du document</label>
                <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($document['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="typedoc" class="form-label">Type de document</label>
                <input type="text" class="form-control" id="typedoc" name="typedoc" value="<?= htmlspecialchars($document['typedoc']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="descriptiondoc" class="form-label">Description</label>
                <textarea class="form-control" id="descriptiondoc" name="descriptiondoc"><?= htmlspecialchars($document['descriptiondoc']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="GestionDocument.php" class="btn btn-secondary">Annuler</a>
        </form>
    </div>
</body>
</html>
