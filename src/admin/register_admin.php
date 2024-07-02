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
</head>
<body>
    <h2>Inscription Nouvel Administrateur</h2>
    <form action="register_admin.php" method="post">
        <label for="username">Nom d'utilisateur:</label><br>
        <input type="text" id="username" name="username" required><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="password">Mot de passe:</label><br>
        <input type="password" id="password" name="password" required><br>
        
        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>

