<?php
session_start();

// Inclure votre fichier de configuration et votre classe de base de données
require_once __DIR__ . '/config/config.php'; // Assurez-vous du chemin correct pour config.php
require_once __DIR__ . '/config/DataBase.php'; // Assurez-vous du chemin correct pour DataBase.php

// Récupérer l'ID de l'utilisateur depuis la session
$user_id = $_SESSION['user_id'];

// Créer une instance de la classe DataBase pour la connexion
$db = new DataBase();
$connection = $db->getConnection();

// Récupérer les informations de l'utilisateur
$user_info = [];
$sql_user = "SELECT nom, prenom, adresse, email, password, city, postcode, tel, registerdate FROM users WHERE id_user = ?";
$stmt_user = $connection->prepare($sql_user);
$stmt_user->execute([$user_id]);

if ($stmt_user->rowCount() > 0) {
    $user_info = $stmt_user->fetch(PDO::FETCH_ASSOC);
}

// Récupérer l'historique des commandes de l'utilisateur
$order_history = [];
$sql_commandes = "SELECT id_commande, date_commande, statut, id_product, qté FROM commande WHERE id_user = ? ORDER BY date_commande DESC";
$stmt_commandes = $connection->prepare($sql_commandes);
$stmt_commandes->execute([$user_id]);

if ($stmt_commandes->rowCount() > 0) {
    $order_history = $stmt_commandes->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Utilisateur</title>
    <style>
        /* Styles CSS pour la mise en page */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }
        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Informations Utilisateur</h1>
        <table>
            <tr>
                <th>Nom</th>
                <td><?= htmlspecialchars($user_info['nom'] ?? '') ?></td>
            </tr>
            <tr>
                <th>Prénom</th>
                <td><?= htmlspecialchars($user_info['prenom'] ?? '') ?></td>
            </tr>
            <tr>
                <th>Adresse</th>
                <td><?= htmlspecialchars($user_info['adresse'] ?? '') ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?= htmlspecialchars($user_info['email'] ?? '') ?></td>
            </tr>
            <tr>
                <th>Ville</th>
                <td><?= htmlspecialchars($user_info['city'] ?? '') ?></td>
            </tr>
            <tr>
                <th>Code Postal</th>
                <td><?= htmlspecialchars($user_info['postcode'] ?? '') ?></td>
            </tr>
            <tr>
                <th>Téléphone</th>
                <td><?= htmlspecialchars($user_info['tel'] ?? '') ?></td>
            </tr>
        </table>

        <h1>Historique des Commandes</h1>
        <?php if (!empty($order_history)): ?>
            <table>
                <tr>
                    <th>ID Commande</th>
                    <th>Date Commande</th>
                    <th>Statut</th>
                    <th>ID Produit</th>
                    <th>Quantité</th>
                </tr>
                <?php foreach ($order_history as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id_commande']) ?></td>
                        <td><?= htmlspecialchars($order['date_commande']) ?></td>
                        <td><?= htmlspecialchars($order['statut']) ?></td>
                        <td><?= htmlspecialchars($order['id_product']) ?></td>
                        <td><?= htmlspecialchars($order['qté']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>Aucune commande trouvée.</p>
        <?php endif; ?>
    </div>
</body>
</html>
