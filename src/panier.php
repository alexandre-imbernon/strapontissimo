<?php
session_start();

// Configuration de la connexion à la base de données
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "strapontissimo";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialiser le panier s'il n'existe pas déjà dans la session
if (!isset($_SESSION['id_user'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit();
}

$id_user = $_SESSION['id_user'];

// Fonction pour ajouter un produit au panier
function addToCart($conn, $id_user, $productId, $quantity = 1) {
    // Vérifier si le produit est déjà dans le panier
    $sql = "SELECT * FROM panier WHERE id_user = ? AND id_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_user, $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Le produit existe déjà, incrémenter la quantité
        $sql = "UPDATE panier SET qté = qté + ? WHERE id_user = ? AND id_product = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $quantity, $id_user, $productId);
        $stmt->execute();
    } else {
        // Le produit n'est pas encore dans le panier, l'ajouter
        $sql = "INSERT INTO panier (id_user, id_product, qté) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iii", $id_user, $productId, $quantity);
        $stmt->execute();
    }
}

// Traitement du formulaire d'ajout au panier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 1;

    addToCart($conn, $id_user, $productId, $quantity);
}

// Fonction pour supprimer un produit du panier
function removeFromCart($conn, $id_user, $productId) {
    $sql = "DELETE FROM panier WHERE id_user = ? AND id_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_user, $productId);
    $stmt->execute();
}

// Traitement du formulaire de suppression d'un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_product_id'])) {
    $removeProductId = $_POST['remove_product_id'];
    removeFromCart($conn, $id_user, $removeProductId);
}

// Récupérer les éléments du panier de la base de données
$sql = "SELECT p.*, pr.nom, pr.image, pr.price FROM panier p JOIN products pr ON p.id_product = pr.id_product WHERE p.id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

$panierItems = $result->fetch_all(MYSQLI_ASSOC);

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

        .cart-summary {
            margin-top: 20px;
            padding: 10px;
            background-color: #f2f2f2;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        .cart-summary p {
            margin: 5px 0;
        }

        .cart-actions {
            text-align: center;
            margin-top: 10px;
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
    <?php if (empty($panierItems)): ?>
        <p>Votre panier est vide.</p>
    <?php else: ?>
        <?php foreach ($panierItems as $item): ?>
            <div class="cart-item">
                <img src="<?php echo htmlspecialchars($item['image']); ?>" alt="<?php echo htmlspecialchars($item['nom']); ?>">
                <div class="item-details">
                    <p><?php echo htmlspecialchars($item['nom']); ?></p>
                    <p><?php echo number_format((float)$item['price'], 2, ',', '.') . ' EUR'; ?></p>
                    <p>Quantité : <?php echo htmlspecialchars($item['qté']); ?></p>
                </div>
                <form method="post">
                    <input type="hidden" name="remove_product_id" value="<?php echo htmlspecialchars($item['id_product']); ?>">
                    <button type="submit" class="remove-button">Supprimer</button>
                </form>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php
$totalItems = 0;
$totalPrice = 0.0;

foreach ($panierItems as $item) {
    $totalItems += $item['qté'];
    $totalPrice += $item['price'] * $item['qté'];
}
?>

<section class="cart-summary">
    <p>Total des articles : <?php echo $totalItems; ?></p>
    <p>Total : <?php echo number_format((float)$totalPrice, 2, ',', '.') . ' EUR'; ?></p>
</section>

<section class="cart-actions">
    <button class="proceed-to-checkout-button">Passer à la caisse</button>
</section>

<footer>
    &copy; 2024 Strapontissimo. Tous droits réservés.
</footer>

</body>
</html>

<?php
// Fermer la connexion
$conn->close();
?>
