<?php
session_start();

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strapontissimo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/panier.css">
    
</head>
<body>
<header>

    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../assets/images/logoo.png" alt="Logo" href="index.php" class="navbar-logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="adminDropdown">
                            <a class="dropdown-item" href="login.php">Connexion</a>
                            <a class="dropdown-item" href="register.php">Inscription</a>
                            <a class="dropdown-item" href="#">Administration</a>
                            <div class="dropdown-divider"></div>
                            
                    </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-shopping-cart"></i>  
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="products.php">Nos produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">S'enregistrer</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
</header>

<main>
<div class="container main-container">
    <div class="row">
        <div class="col-md-8">
            <section class="cart">
                <h1>Votre Panier</h1>
                <hr>
                <?php if (empty($_SESSION['panier'])): ?>
                    <p>Votre panier est vide.</p>
                <?php else: ?>
                    <?php foreach ($_SESSION['panier'] as $item): ?>
                        <div class="cart-item">
                            <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                            <div class="item-details">
                                <p><?php echo htmlspecialchars($item['name']); ?></p>
                                <p><?php echo number_format($item['price'], 2, ',', '.') . ' EUR'; ?></p>
                                <p><strong>Quantité : </strong>x <?php echo htmlspecialchars($item['quantity']); ?></p>
                            </div>
                            <form method="post">
                                <input type="hidden" name="remove_product_id" value="<?php echo htmlspecialchars($item['id']); ?>">
                                <button type="submit" class="remove-button">
                                    <i class="fas fa-trash-alt"></i> </button>
                                
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </section>
        </div>
        <div class="col-md-4">
            <?php
            $totalItems = 0;
            $totalPrice = 0.0;

            // Calculer le nombre total d'articles et le total en euros
            foreach ($_SESSION['panier'] as $item) {
                $totalItems += $item['quantity'];
                $totalPrice += $item['price'] * $item['quantity'];
            }
            ?>

            <?php if (!empty($_SESSION['panier'])): ?>
                <div class="cart-summary">
                    <h5> Récapitulatif de votre commande </h5>
                    <hr>
                    <p>Total des articles : <?php echo $totalItems; ?></p>
                    <p> Livraison : 50 €</p>
                    <hr>
                    <p>Total en euros : <?php echo number_format($totalPrice, 2, ',', '.') . ' EUR'; ?></p>
                </div>

                <div class="cart-actions">
                    <button class="proceed-to-checkout-button" onclick="document.getElementById('payment-form').scrollIntoView({ behavior: 'smooth' });">Procéder au paiement</button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>


<footer>
    <p>© 2024 Strapontissimo - Le confort instantané</p>
</footer>

    <!-- Scripts Bootstrap et jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>