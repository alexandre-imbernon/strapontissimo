<?php
session_start();
require_once __DIR__ . '/../config/config.php'; // Assurez-vous du chemin correct

// Inclure votre classe de base de données
require_once __DIR__ . '/..//config/DataBase.php'; // Assurez-vous du chemin correct

$user_id = $_SESSION['user_id'];

// Créer une instance de la classe DataBase pour la connexion
$db = new DataBase();
$connection = $db->getConnection();

// Récupérer les informations de l'utilisateur
$user_info = [];
$sql = "SELECT nom, prenom, adresse, email, password, city, postcode, tel, registerdate FROM users WHERE id_user = ?";
$stmt = $connection->prepare($sql);
$stmt->execute([$user_id]);

if ($stmt->rowCount() > 0) {
    $user_info = $stmt->fetch(PDO::FETCH_ASSOC);
}

// Mettre à jour les informations de l'utilisateur
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $adresse = $_POST['adresse'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $tel = $_POST['tel'];

    $sql = "UPDATE users SET nom = ?, prenom = ?, adresse = ?, email = ?, password = ?, city = ?, postcode = ?, tel = ? WHERE id_user = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$nom, $prenom, $adresse, $email, $password, $city, $postcode, $tel, $user_id]);

    if ($stmt->rowCount() > 0) {
        $message = "Informations mises à jour avec succès";
        // Mettre à jour les informations utilisateur localement
        $user_info['nom'] = $nom;
        $user_info['prenom'] = $prenom;
        $user_info['adresse'] = $adresse;
        $user_info['email'] = $email;
        $user_info['password'] = $password;
        $user_info['city'] = $city;
        $user_info['postcode'] = $postcode;
        $user_info['tel'] = $tel;
    } else {
        $message = "Erreur lors de la mise à jour des informations";
    }
}

// Récupérer l'historique des commandes
$order_history = [];
$sql = "SELECT id_commande, date_commande, statut FROM commande WHERE id_user = ? ORDER BY date_commande DESC";
$stmt = $connection->prepare($sql);
$stmt->execute([$user_id]);

if ($stmt->rowCount() > 0) {
    $order_history = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Compte</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/users.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light ">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../assets/images/logoo.png" alt="Logo" href="index.php" class="navbar-logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Accueil</a>
                    </li>                                   
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Nos produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Mon compte</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="my-4">
    <div class="container">
        <h1 class="mb-4">Modifier vos informations</h1>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($message) ?></div>
        <?php endif; ?>

        <form id="userForm" method="POST">
            <div class="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" class="form-control" value="<?= htmlspecialchars($user_info['nom'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" class="form-control" value="<?= htmlspecialchars($user_info['prenom'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="adresse">Adresse:</label>
                <input type="text" id="adresse" name="adresse" class="form-control" value="<?= htmlspecialchars($user_info['adresse'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?= htmlspecialchars($user_info['email'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>


            <div class="form-group">
                <label for="city">Ville:</label>
                <input type="text" id="city" name="city" class="form-control" value="<?= htmlspecialchars($user_info['city'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="postcode">Code Postal:</label>
                <input type="text" id="postcode" name="postcode" class="form-control" value="<?= htmlspecialchars($user_info['postcode'] ?? '') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="tel">Téléphone:</label>
                <input type="tel" id="tel" name="tel" class="form-control" value="<?= htmlspecialchars($user_info['tel'] ?? '') ?>" required>
            </div>
            
            <button type="submit" class="btn btn-primary">Mettre à jour</button>
        </form>

        <div class="order-history my-4">
            <h2 class="mb-4">Historique des commandes</h2>
            <?php if (!empty($order_history)): ?>
                <?php foreach ($order_history as $order): ?>
                    <div class="order-item" id="order-<?= $order['id_commande'] ?>">
                        Commande #<?= $order['id_commande'] ?> - <?= $order['date_commande'] ?> - <?= $order['statut'] ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">Aucune commande trouvée</div>
            <?php endif; ?>
        </div>





    </div>
</main>
<footer class="text-center mt-5">
    <p>&copy; 2023 Strapontissimo. Tous droits réservés.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
