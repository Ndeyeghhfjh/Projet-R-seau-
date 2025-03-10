<?php
session_start();
$error = "";

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $server = $_POST['server'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Connexion à la base de données distante
    $conn = new mysqli($server, "root", "", "smarttech");

    if ($conn->connect_error) {
        $error = "Connexion au serveur échouée.";
    } else {
        // Vérification des identifiants
        $stmt = $conn->prepare("SELECT idemploye FROM employes WHERE nom = ? AND password = ?");
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['employe_id'] = $username;
            header("Location: dashboard.php"); // Redirige après connexion réussie
            exit();
        } else {
            $error = "Nom d'utilisateur ou mot de passe incorrect.";
        }

        $stmt->close();
        $conn->close();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accès à Distance</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js"></script>
    <style>
        body { background-color: #f8f9fa; }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .login-container .form-control { padding-left: 40px; }
        .login-container .input-group-text {
            background: #0d6efd; color: white; border: none;
        }
        .login-container .btn-primary { width: 100%; }
    </style>
</head>
<body>
    <div class="login-container">
        <h3 class="text-center">Connexion à Distance</h3>
        
        <!-- Affichage du message d'erreur -->
        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form action="connexion.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Nom d'utilisateur</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                    <input type="text" class="form-control" name="username" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Mot de passe</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input type="password" class="form-control" name="password" required>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse du serveur</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-server"></i></span>
                    <input type="text" class="form-control" name="server" placeholder="ex: 192.168.1.1" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>
