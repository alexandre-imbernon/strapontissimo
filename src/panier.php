<?php
session_start();
var_dump($_SESSION);

// Initialiser le panier s'il n'existe pas déjà dans la session
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Fonction pour ajouter un produit au panier
function addToCart($productId, $productName, $productImage, $productPrice, $quantity = 1) {
    // Vérifier si le produit est déjà dans le panier
    foreach ($_SESSION['panier'] as &$item) {
        if ($item['id'] == $productId) {
            // Le produit existe déjà, incrémenter la quantité
            $item['quantity'] += $quantity;
            return; // Sortir de la fonction après mise à jour
        }
    }

    // Le produit n'est pas encore dans le panier, l'ajouter
    $product = array(
        'id' => $productId,
        'name' => $productName,
        'image' => $productImage,
        'price' => $productPrice,
        'quantity' => $quantity
    );
    $_SESSION['panier'][] = $product;
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
    foreach ($_SESSION['panier'] as $key => $item) {
        if ($item['id'] == $productId) {
            unset($_SESSION['panier'][$key]);
            return; // Sortir de la fonction après suppression
        }
    }
}

// Traitement du formulaire de suppression d'un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $removeProductId = $_POST['remove_product_id'];
    removeFromCart($removeProductId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: white;
            text-align: center;
            padding: 1rem 0;
        }

        .cart {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .cart h1 {
            text-align: center;
            color: #444;
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

        footer {
            margin-top: 20px;
            text-align: center;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <header>
        <img src="assets/images/logo.png" alt="Logo"> <!-- Assurez-vous d'ajouter le chemin correct vers votre image ici -->
    </header>
    <section class="cart">
    <h1>Votre Panier</h1>
    <?php if (empty($_SESSION['panier'])): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <?php foreach ($_SESSION['panier'] as $item): ?>
            <div class="cart-item">
                <img src="<?php echo htmlspecialchars($item['image'] ?? ''); ?>" alt="<?php echo htmlspecialchars($item['name'] ?? ''); ?>">
                <div class="item-details">
                    <p><?php echo htmlspecialchars($item['name'] ?? ''); ?></p>
                    <?php if (isset($item['price']) && is_numeric($item['price'])): ?>
                        <p><?php echo number_format((float)$item['price'], 2, ',', '.') . ' EUR'; ?></p>
                    <?php else: ?>
                        <p>Prix non disponible</p>
                    <?php endif; ?>
                    <?php
                        // Afficher la quantité avec "x1", "x2", etc.
                        $quantityDisplay = ($item['quantity'] > 1) ? 'x' . $item['quantity'] : 'x1';
                        ?>
                        <p>Quantité : <?php echo htmlspecialchars($quantityDisplay); ?></p>
                </div>
                <form method="post">
                    <input type="hidden" name="remove_product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                    <button type="submit" class="remove-button">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

    <footer>
        <p>© 2024 Strapontissimo - Le confort instantané</p>
    </footer>
</body>
</html>