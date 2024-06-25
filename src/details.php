<?php
// Inclure la classe DataBase.php
require_once 'database.php';

// Vérifier si un ID de produit est passé dans l'URL
if (isset($_GET['id_product']) && is_numeric($_GET['id_product'])) {
    $productId = intval($_GET['id_product']);

    // Créer une instance de la classe DataBase
    $db = new DataBase();

    // Utiliser la connexion pour exécuter une requête par exemple
    try {
        // Obtenez la connexion
        $conn = $db->getConnection();

        // Requête SQL pour récupérer les détails du produit
        $sql = "SELECT * FROM products WHERE id_product = :id_product";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id_product', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si le produit existe
        if (!$product) {
            echo "Produit non trouvé";
            exit;
        }
    } catch (PDOException $e) {
        echo "Erreur de requête : " . $e->getMessage();
        exit;
    }
} else {
    echo "ID de produit invalide";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header{
            background-color: white;
            color: white;
            text-align: center;
            padding: 0rem 0;
            position: relative;
        }

        .product-details {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .product-details img {
            max-width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .product-details h1 {
            text-align: center;
            color: #444;
        }

        .product-details p {
            font-size: 1em;
            margin: 5px 0;
        }

        .product-details form {
            text-align: center;
            margin-top: 20px;
        }

        .product-details button {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        .product-details button:hover {
            background-color: #218838;
        }

        footer {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
        <img src="assets/images/logo.png" alt="Logo"> <!-- Ajoutez le chemin correct vers votre image ici -->
    </header>

    <section>
        <div class="product-details">
        <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                    <p><?php echo number_format($product['price'], 2); ?> EUR</p>
                    <p><?php echo htmlspecialchars($product['infoproduct']); ?></p>
                    <br>
                    <p>En stock: <?php echo $product['stock']; ?></p>
                    <p>Référencé le: <?php echo $product['date']; ?></p>
            <form action="panier.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id_product']; ?>">
                <button type="submit">Ajouter au panier</button>
            </form>
        </div>
    </section>
    <footer>
        <p>© 2024 Strapontissimo - Le confort instantané</p>
    </footer>
</body>
</html>
