<?php
session_start();

// Initialiser le panier si ce n'est pas déjà fait
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Ajouter le produit au panier si les informations sont envoyées
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $product = array(
        'id' => $_POST['product_id'],
        'name' => $_POST['product_name'],
        'image' => $_POST['product_image'],
        'price' => $_POST['product_price']
    );

    // Ajouter le produit à la session panier
    $_SESSION['panier'][] = $product;
}

// Supprimer un produit du panier si l'ID est envoyé en POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['remove_product_id'])) {
    $remove_id = $_POST['remove_product_id'];
    foreach ($_SESSION['panier'] as $key => $item) {
        if ($item['id'] == $remove_id) {
            unset($_SESSION['panier'][$key]);
            break; // Sortir de la boucle dès que l'article est supprimé
        }
    }
    // Réindexer le tableau après la suppression
    $_SESSION['panier'] = array_values($_SESSION['panier']);
}

// Afficher les produits dans le panier
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
        <img src="assets/images/logo.png" alt="Logo"> <!-- Ajoutez le chemin correct vers votre image ici -->
    </header>

    <section class="cart">
        <h1>Votre Panier</h1>
        <?php if (empty($_SESSION['panier'])): ?>
            <p>Votre panier est vide.</p>
        <?php else: ?>
            <?php foreach ($_SESSION['panier'] as $item): ?>
                <div class="cart-item">
                    <img src="<?php echo isset($item['image']) ? htmlspecialchars($item['image']) : ''; ?>" alt="<?php echo isset($item['name']) ? htmlspecialchars($item['name']) : ''; ?>">
                    <div class="item-details">
                        <p><?php echo isset($item['name']) ? htmlspecialchars($item['name']) : ''; ?></p>
                        <?php
                        // Vérifier si $item['price'] est une chaîne valide représentant un nombre
                        if (isset($item['price']) && is_numeric($item['price'])) {
                            $formatted_price = number_format((float)$item['price'], 2) . ' EUR';
                            echo '<p>' . $formatted_price . '</p>';
                        } else {
                            echo '<p>Prix non disponible</p>'; // Ou toute autre gestion d'erreur appropriée
                        }
                        ?>
                    </div>
                    <form method="post">
                        <input type="hidden" name="remove_product_id" value="<?php echo $item['id']; ?>">
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
