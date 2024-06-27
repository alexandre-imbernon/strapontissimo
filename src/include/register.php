<?php
require_once '../config/database.php'; // Assurez-vous que ce chemin est correct

$db = new DataBase();
$conn = $db->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $adresse = $_POST['adresse'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $tel = $_POST['tel'];
    $registerdate = date('Y-m-d');

    try {
        $sql = "INSERT INTO users (nom, prenom, email, password, adresse, city, postcode, tel, registerdate) 
                VALUES (:nom, :prenom, :email, :password, :adresse, :city, :postcode, :tel, :registerdate)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':adresse', $adresse);
        $stmt->bindParam(':city', $city);
        $stmt->bindParam(':postcode', $postcode);
        $stmt->bindParam(':tel', $tel);
        $stmt->bindParam(':registerdate', $registerdate);
        $stmt->execute();
        
        echo "Inscription réussie. Vous pouvez maintenant <a href='../include/login.php'>vous connecter</a>.";
    } catch (PDOException $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
</head>
<body>
    <h2>Créer un compte</h2>
    <form action="register.php" method="post">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" required><br>
        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" required><br>
        <label for="email">Email:</label>
        <input type="email" name="email" required><br>
        <label for="password">Mot de passe:</label>
        <input type="password" name="password" required><br>
        <label for="adresse">Adresse:</label>
        <input type="text" name="adresse" required><br>
        <label for="city">Ville:</label>
        <input type="text" name="city" required><br>
        <label for="postcode">Code postal:</label>
        <input type="text" name="postcode" required><br>
        <label for="tel">Téléphone:</label>
        <input type="text" name="tel" required><br>
        <input type="submit" value="S'inscrire">
    </form>
</body>
</html>
