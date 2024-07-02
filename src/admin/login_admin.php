<?php
require '../config/config.php'; // Inclure le fichier de configuration
require '../config/database.php'; // Inclure le fichier de configuration

session_start(); // Démarrer la session au début

$message = ""; // Variable pour stocker le message à afficher

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupération et validation des données du formulaire
    $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $pass = $_POST['password'];

    if ($user && $pass) {
        // Préparation de la requête de sélection
        $sql = "SELECT * FROM admin WHERE username=?";
        $stmt = $conn->prepare($sql);
        
        if ($stmt === false) {
            error_log("Échec de la préparation de la requête : " . $conn->error);
            $message = "Erreur de préparation de la requête.";
        } else {
            $stmt->bind_param("s", $user);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result === false) {
                error_log("Erreur d'exécution de la requête : " . $stmt->error);
                $message = "Erreur d'exécution de la requête.";
            } elseif ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                if (password_verify($pass, $row['password'])) {
                    // Démarrage de la session et redirection vers la dashboard
                    session_regenerate_id(true);
                    $_SESSION['admin_logged_in'] = true;
                    $_SESSION['admin_id'] = $row['id'];
                    $_SESSION['username'] = $row['username'];
                    header("Location: dashboard.php");
                    exit();
                } else {
                    error_log("Mot de passe incorrect.");
                    $message = "Mot de passe incorrect.";
                }
            } else {
                error_log("Nom d'utilisateur incorrect.");
                $message = "Nom d'utilisateur incorrect.";
            }

            $stmt->close();
        }
    } else {
        $message = "Veuillez remplir tous les champs.";
        error_log("Champs requis non remplis.");
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <?php
            if (!empty($message)) {
                echo "<p>$message</p>";
            }
            ?>
            <form action="login_admin.php" method="post">
                <h2>CONNEXION ADMIN</h2>
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" required>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="Se connecter">
            </form>
        </div>
        <div class="image-container image-connexion"></div>
    </div>
</body>
</html>