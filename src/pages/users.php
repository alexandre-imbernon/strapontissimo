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
    <title>Panel Utilisateur</title>
    <style>
        /* Styles de base pour le formulaire */
        form {
            max-width: 600px;
            margin: auto;
            padding: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        input, button {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
        }
        .message {
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<h1>Modifier vos informations</h1>

<?php if (!empty($message)): ?>
    <div class="message"><?= htmlspecialchars($message) ?></div>
<?php endif; ?>

<form id="userForm" method="POST">
    <label for="nom">Nom:</label>
    <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user_info['nom'] ?? '') ?>" required>
    
    <label for="prenom">Prénom:</label>
    <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user_info['prenom'] ?? '') ?>" required>
    
    <label for="adresse">Adresse:</label>
    <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($user_info['adresse'] ?? '') ?>" required>
    
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= htmlspecialchars($user_info['email'] ?? '') ?>" required>
    
    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" value="<?= htmlspecialchars($user_info['password'] ?? '') ?>" required>
    
    <label for="city">Ville:</label>
    <input type="text" id="city" name="city" value="<?= htmlspecialchars($user_info['city'] ?? '') ?>" required>
    
    <label for="postcode">Code Postal:</label>
    <input type="text" id="postcode" name="postcode" value="<?= htmlspecialchars($user_info['postcode'] ?? '') ?>" required>
    
    <label for="tel">Téléphone:</label>
    <input type="tel" id="tel" name="tel" value="<?= htmlspecialchars($user_info['tel'] ?? '') ?>" required>
    
    <button type="submit">Mettre à jour</button>
</form>

<h1>Historique des commandes</h1>
<div id="orderHistory">
    <?php if (!empty($order_history)): ?>
        <?php foreach ($order_history as $order): ?>
            <div>Commande #<?= $order['id_commande'] ?> - <?= $order['date_commande'] ?> - <?= htmlspecialchars($order['statut']) ?></div>
        <?php endforeach; ?>
    <?php else: ?>
        <div>Aucune commande trouvée</div>
    <?php endif; ?>
</div>

</body>
</html>