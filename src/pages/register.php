<?php
require_once '../config/database.php';

$db = new DataBase();
$conn = $db->getConnection();

$message = ""; // Variable pour stocker le message

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
        
        $message = "<strong>Inscription réussie.</strong> Vous pouvez maintenant <a href='login.php'>vous connecter</a>.";
    } catch (PDOException $e) {
        $message = "<strong>Erreur :</strong> " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/register.css">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../assets/images/logoo.png" alt="Logo" class="navbar-logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    
                    
                    <li class="nav-item">
                        <a class="nav-link" href="#">Connexion</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Inscription</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Administration</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
<div class="container-fluid">
        <div class="row">
            <div class="col-lg-6 p-0">
                <img src="../assets/images/str.jpg" class="img-fluid" alt="Left Image">
            </div>
            <div class="form-container col-lg-6"> 
            <form action="register.php" method="post" class="needs-validation" novalidate>
            <h2 class="text-center mb-4">Inscription</h2>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="nom">Nom:</label>
                        <input type="text" name="nom" class="form-control" id="nom" required>
                        <div class="invalid-feedback">
                            Veuillez entrer votre nom.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="prenom">Prénom:</label>
                        <input type="text" name="prenom" class="form-control" id="prenom" required>
                        <div class="invalid-feedback">
                            Veuillez entrer votre prénom.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                    <div class="invalid-feedback">
                        Veuillez entrer un email valide.
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Mot de passe:</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                    <div class="invalid-feedback">
                        Veuillez entrer un mot de passe.
                    </div>
                </div>
                <div class="form-group">
                    <label for="adresse">Adresse:</label>
                    <input type="text" name="adresse" class="form-control" id="adresse" required>
                    <div class="invalid-feedback">
                        Veuillez entrer votre adresse.
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="city">Ville:</label>
                        <input type="text" name="city" class="form-control" id="city" required>
                        <div class="invalid-feedback">
                            Veuillez entrer votre ville.
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="postcode">Code postal:</label>
                        <input type="text" name="postcode" class="form-control" id="postcode" required>
                        <div class="invalid-feedback">
                            Veuillez entrer votre code postal.
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="tel">Téléphone:</label>
                    <input type="text" name="tel" class="form-control" id="tel" required>
                    <div class="invalid-feedback">
                        Veuillez entrer votre numéro de téléphone.
                    </div>
                </div>
                <button type="submit" class="btn btn-block">S'inscrire</button>
                <?php if (!empty($message)): ?>
                        <div class="message mt-3">
                            <?php echo $message; ?>
                        </div>
                    <?php endif; ?>
            </form>
        </div>
    </div>
</main>

<footer class="text-center py-3">
    <p>© 2024 Strapontissimo - Le confort instantané</p>
</footer>

<!-- Scripts Bootstrap et jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
