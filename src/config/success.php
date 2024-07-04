<?php
session_start();

// Inclusion du fichier de configuration
require_once __DIR__ . '/config.php'; // Chemin relatif pour config.php

// Inclusion de la classe DataBase
require_once __DIR__ . '/DataBase.php'; // Chemin relatif pour DataBase.php

// Récupération de l'id de l'utilisateur depuis la session
$user_id = $_SESSION['user_id'];

// Vérification et obtention d'une instance de connexion à la base de données
try {
    $db = new DataBase();
    $connection = $db->getConnection();
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Insertion de la commande dans la base de données
try {
    $date_commande = date('Y-m-d');
    $statut = "En attente"; // Statut initial de la commande
    $id_product = $_SESSION['paniers'][$user_id][0]['id'];
    $qté = $_SESSION['paniers'][$user_id][0]['quantity'];

    $sql = "INSERT INTO commande (id_user, date_commande, statut, id_product, qté) VALUES (?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$user_id, $date_commande, $statut, $id_product, $qté]);

    // Vider le panier après la commande réussie
    $_SESSION['paniers'][$user_id] = [];

    // Redirection vers index.php après un délai de 3 secondes
    header("refresh:3;url=../index.php");
    echo "Redirection vers l'accueil...";
    exit();
} catch (PDOException $e) {
    die("Erreur lors de l'insertion de la commande : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strapontissimo - Paiement Réussi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url("./assets/images/background.jpg");
            background-size: cover;
            color: white;
            text-shadow: 3px 3px 4px black;
            text-align: center;
        }
        h2 {
            font-size: 60px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #d1c7be;
            border-top: 1px solid #ddd;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <?php if (isset($_SESSION['user_first_name'])): ?>
            <div class="welcome-message">
                <h2>Paiement réussi, <?= htmlspecialchars($_SESSION['user_first_name']); ?>! Redirection dans 3 secondes...</h2>
            </div>
        <?php else: ?>
            <div class="welcome-message">
                <h2>Paiement réussi! Redirection dans 3 secondes...</h2>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>© 2024 Strapontissimo - Le confort instantané</p>
    </footer>

    <script>
        setTimeout(function() {
            window.location.href = "../index.php";
        }, 3000);
    </script>
</body>
</html>

