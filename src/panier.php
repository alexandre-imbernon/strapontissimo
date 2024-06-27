<?php
session_start();

// Connexion à la base de données
$conn = new mysqli('localhost', 'root', '', 'strapontissimo');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fonction pour ajouter un produit au panier
function addToCart($userId, $productId, $quantity) {
    global $conn;

    // Vérifier si l'utilisateur existe dans la table users
    $sqlUserCheck = "SELECT * FROM users WHERE id_user = ?";
    $stmtUserCheck = $conn->prepare($sqlUserCheck);
    $stmtUserCheck->bind_param('i', $userId);
    $stmtUserCheck->execute();
    $resultUserCheck = $stmtUserCheck->get_result();

    if ($resultUserCheck->num_rows == 0) {
        die("User ID does not exist in the users table.");
    }

    // Vérifier si le produit est déjà dans le panier
    $sqlCheck = "SELECT * FROM panier WHERE id_user = ? AND id_product = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param('ii', $userId, $productId);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();

    if ($resultCheck->num_rows > 0) {
        // Le produit est déjà dans le panier, incrémenter la quantité
        $row = $resultCheck->fetch_assoc();
        $newQuantity = $row['quantity'] + $quantity;

        $sqlUpdate = "UPDATE panier SET quantity = ? WHERE id_user = ? AND id_product = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param('iii', $newQuantity, $userId, $productId);
        $stmtUpdate->execute();
    } else {
        // Le produit n'est pas dans le panier, insérer une nouvelle entrée
        $sqlInsert = "INSERT INTO panier (id_user, id_product, quantity) VALUES (?, ?, ?)";
        $stmtInsert = $conn->prepare($sqlInsert);
        $stmtInsert->bind_param('iii', $userId, $productId, $quantity);
        $stmtInsert->execute();
    }
}

// Initialiser le panier si ce n'est pas déjà fait
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = array();
}

// Ajouter le produit au panier si les informations sont envoyées
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $userId = 1; // ID de l'utilisateur (à obtenir dynamiquement, par exemple depuis la session)
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_image = $_POST['product_image'];
    $product_price = $_POST['product_price'];

    // Vérifier si le produit existe déjà dans le panier de la session
    $product_found = false;
    foreach ($_SESSION['panier'] as &$item) {
        if ($item['id'] == $product_id) {
            $item['quantity']++;
            $product_found = true;
            break;
        }
    }

    // Si le produit n'existe pas, l'ajouter avec une quantité de 1
    if (!$product_found) {
        $product = array(
            'id' => $product_id,
            'name' => $product_name,
            'image' => $product_image,
            'price' => $product_price,
            'quantity' => 1
        );
        $_SESSION['panier'][] = $product;
    }

    // Ajouter le produit au panier dans la base de données
    addToCart($userId, $product_id, 1);
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

    // Supprimer le produit du panier dans la base de données
    $userId = 1; // ID de l'utilisateur (à obtenir dynamiquement, par exemple depuis la session)
    $sqlDelete = "DELETE FROM panier WHERE id_user = ? AND id_product = ?";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param('ii', $userId, $remove_id);
    $stmtDelete->execute();
}

$conn->close();
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
