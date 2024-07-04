<?php
session_start();
require_once __DIR__ . '/config/config.php';


// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    $_SESSION['flash_message'] = "Pour ajouter des produits au panier, veuillez vous connecter.";
    header("Location: login.php");
    exit();
}

// Initialiser le panier de l'utilisateur s'il n'existe pas déjà dans la session
if (!isset($_SESSION['paniers'])) {
    $_SESSION['paniers'] = array();
}

$user_id = $_SESSION['user_id'];

// Initialiser le panier de l'utilisateur s'il n'existe pas déjà
if (!isset($_SESSION['paniers'][$user_id])) {
    $_SESSION['paniers'][$user_id] = array();
}

// Fonction pour ajouter un produit au panier de l'utilisateur
function addToCart($productId, $productName, $productImage, $productPrice, $quantity = 1) {
    global $user_id;
    foreach ($_SESSION['paniers'][$user_id] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += $quantity;
            return;
        }
    }

    $product = array(
        'id' => $productId,
        'name' => $productName,
        'image' => $productImage,
        'price' => $productPrice,
        'quantity' => $quantity
    );
    $_SESSION['paniers'][$user_id][] = $product;
}

// Traitement du formulaire d'ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $productName = $_POST['product_name'];
    $productImage = $_POST['product_image'];
    $productPrice = $_POST['product_price'];

    addToCart($productId, $productName, $productImage, $productPrice);
}

// Fonction pour supprimer un produit du panier
function removeFromCart($productId) {
    global $user_id;
    foreach ($_SESSION['paniers'][$user_id] as $key => $item) {
        if ($item['id'] == $productId) {
            unset($_SESSION['paniers'][$user_id][$key]);
            return;
        }
    }
}

// Traitement du formulaire de suppression d'un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $removeProductId = $_POST['remove_product_id'];
    removeFromCart($removeProductId);
}

// Créer la session de paiement Stripe
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $total = 0;
    $line_items = [];
    foreach ($_SESSION['paniers'][$user_id] as $item) {
        $total += $item['price'] * $item['quantity'];
        $line_items[] = [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => $item['name'],
                ],
                'unit_amount' => $item['price'] * 100,
            ],
            'quantity' => $item['quantity'],
        ];
    }

    $checkout_session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => $line_items,
        'mode' => 'payment',
        'success_url' => 'https://example.com/success.php',
        'cancel_url' => 'https://example.com/cancel.php',
    ]);

    header("Location: " . $checkout_session->url);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: 'Lora', serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .navbar-logo {
            height: 80px;
        }
        .main-container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .cart h1, .payment h1 {
            text-align: center;
            color: #444;
            margin-bottom: 20px;
        }
        .cart-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
        .cart-item img {
            max-width: 100px;
            margin-right: 20px;
        }
        .cart-item .item-details {
            flex-grow: 1;
        }
        .cart-item p {
            margin: 0;
        }
        .cart-item .remove-button {
            background-color: #ff6347;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .cart-summary {
            padding: 27px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .cart-summary p {
            margin: 5px 0;
        }
        .cart-actions {
            text-align: center;
            margin-top: 10px;
        }
        .cart {
            padding: 20px;
        }
        .proceed-to-checkout-button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
        .proceed-to-checkout-button:hover {
            background-color: #0056b3;
        }
        .payment {
            margin-top: 30px;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-control {
            border-radius: 5px;
        }
        footer {
            text-align: center;
            padding: 10px;
            background-color: #d1c7be;
            border-top: 1px solid #ddd;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="./assets/images/logoo.png" alt="Logo" href="index.php" class="navbar-logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-shopping-cart"></i> Panier
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="cart.html">Voir le panier</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">S'inscrire</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Se connecter</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<main class="main-container">
    <div class="cart">
        <h1>Mon Panier</h1>
        <?php if (isset($_SESSION['paniers'][$user_id]) && !empty($_SESSION['paniers'][$user_id])): ?>
            <div class="cart-items">
                <?php foreach ($_SESSION['paniers'][$user_id] as $item): ?>
                    <div class="cart-item">
                        <img src="<?= htmlspecialchars($item['image']) ?>" alt="Image du produit">
                        <div class="item-details">
                            <p><strong>Nom:</strong> <?= htmlspecialchars($item['name']) ?></p>
                            <p><strong>Prix:</strong> <?= htmlspecialchars($item['price']) ?>€</p>
                            <p><strong>Quantité:</strong> <?= htmlspecialchars($item['quantity']) ?></p>
                        </div>
                        <form action="panier.php" method="post">
                            <input type="hidden" name="remove_product_id" value="<?= htmlspecialchars($item['id']) ?>">
                            <button type="submit" class="remove-button">Supprimer</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="cart-summary">
                <?php
                $total = 0;
                foreach ($_SESSION['paniers'][$user_id] as $item) {
                    $total += $item['price'] * $item['quantity'];
                }
                ?>
                <p><strong>Total:</strong> <?= $total ?>€</p>
            </div>
            <div class="cart-actions">
                <form action="panier.php" method="post">
                    <button type="submit" name="checkout" class="proceed-to-checkout-button">Procéder au paiement</button>
                </form>
            </div>
        <?php else: ?>
            <p>Votre panier est vide.</p>
        <?php endif; ?>
    </div>
</main>
<footer>
    <p>&copy; 2023 Strapontissimo. Tous droits réservés.</p>
</footer>
</body>
</html>
