<?php
require_once __DIR__ . '/config.php'; // Chemin relatif pour config.php
require_once __DIR__ . '/DataBase.php'; // Chemin relatif pour DataBase.php
session_start();

$user_id = $_SESSION['user_id'];

try {
    $db = new DataBase();
    $connection = $db->getConnection();
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Insertion de la commande dans la base de données
$date_commande = date('Y-m-d');
$statut = "En attente"; // Statut initial de la commande
$id_product = $_SESSION['paniers'][$user_id][0]['id'];
$qté = $_SESSION['paniers'][$user_id][0]['quantity'];

$sql = "INSERT INTO commande (id_user, date_commande, statut, id_product, qté) VALUES (?, ?, ?, ?, ?)";
$stmt = $connection->prepare($sql);
$stmt->execute([$user_id, $date_commande, $statut, $id_product, $qté]);

// Vider le panier après la commande réussie
$_SESSION['paniers'][$user_id] = [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Réussi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f8f9fa;
            font-family: 'Lora', serif;
        }
        .success-container {
            text-align: center;
            padding: 50px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .success-container h1 {
            color: #28a745;
            margin-bottom: 20px;
        }
        .success-container p {
            color: #6c757d;
            margin-bottom: 30px;
        }
        .spinner {
            display: inline-block;
            width: 50px;
            height: 50px;
            border: 6px solid rgba(0, 0, 0, 0.1);
            border-top: 6px solid #28a745;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h1>Paiement Réussi!</h1>
        <p>Merci pour votre achat. Vous allez être redirigé vers la page d'accueil.</p>
        <div class="spinner"></div>
    </div>

    <script>
        // Redirection après 5 secondes
        setTimeout(function(){
            window.location.href = '../index.php';
        }, 5000);
    </script>
</body>
</html>
