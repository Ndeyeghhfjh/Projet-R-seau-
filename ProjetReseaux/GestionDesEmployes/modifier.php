<?php
include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID invalide.");
}

$id = intval($_GET['id']); // Sécurisation de l'ID

// Préparation de la requête pour éviter les injections SQL
$stmt = $conn->prepare("SELECT * FROM employes WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    die("Employé non trouvé.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $poste = $_POST['poste'];
    $salaire = $_POST['salaire'];
    $date_embauche = $_POST['date_embauche'];
    $departement = $_POST['departement'];

    // Requête préparée pour sécuriser la mise à jour
    $stmt = $conn->prepare("UPDATE employes SET nom = ?, prenom = ?, email = ?, poste = ?, salaire = ?, date_embauche = ?, departement = ? WHERE id = ?");
    $stmt->bind_param("ssssdssi", $nom, $prenom, $email, $poste, $salaire, $date_embauche, $departement, $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour : " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Employé</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier un Employé</h2>
        <form method="POST">
            <div class="mb-3">
                <label>Nom :</label>
                <input type="text" name="nom" value="<?= htmlspecialchars($row['nom']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Prénom :</label>
                <input type="text" name="prenom" value="<?= htmlspecialchars($row['prenom']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Email :</label>
                <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Poste :</label>
                <input type="text" name="poste" value="<?= htmlspecialchars($row['poste']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Salaire :</label>
                <input type="number" name="salaire" value="<?= htmlspecialchars($row['salaire']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Date d'embauche :</label>
                <input type="date" name="date_embauche" value="<?= htmlspecialchars($row['date_embauche']) ?>" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Département :</label>
                <input type="text" name="departement" value="<?= htmlspecialchars($row['departement']) ?>" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Modifier</button>
        </form>
    </div>
</body>
</html>
