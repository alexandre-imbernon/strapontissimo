<?php
require '../config/config.php'; // Include the configuration file
require '../config/database.php'; // Include the database file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Fetch and validate form data
    $user = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $pass = $_POST['password'];

    if ($user && $email && $pass) {
        $hashed_pass = password_hash($pass, PASSWORD_BCRYPT);
        
        // Prepare the insert statement
        $sql = "INSERT INTO admin (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt === false) {
            die("Erreur lors de la préparation de la requête : " . $conn->error);
        }
        $stmt->bind_param("sss", $user, $email, $hashed_pass);

        if ($stmt->execute()) {
            echo "Nouvel administrateur enregistré avec succès.";
        } else {
            echo "Erreur: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Invalid input.";
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription Admin</title>
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <form action="register_admin.php" method="post">
                <h2>INSCRIPTION ADMIN</h2>
                <label for="username">Nom d'utilisateur:</label>
                <input type="text" id="username" name="username" required>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
                <input type="submit" value="S'inscrire">
                <p>Déjà inscrit ? <a href="login_admin.php">Connectez-vous ici</a></p>
            </form>
        </div>
        <div class="image-container image-inscription"></div>
    </div>
</body>
</html>
