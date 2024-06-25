<?php
// Inclure la classe DataBase.php
require_once 'database.php';

// Créer une instance de la classe DataBase
$db = new DataBase();

// Utiliser la connexion pour exécuter une requête par exemple
try {
    // Obtenez la connexion
    $conn = $db->getConnection();

    // Exemple de requête SQL pour récupérer les produits
    $sql = "SELECT * FROM products";
    $stmt = $conn->query($sql);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC); // Récupérer tous les produits sous forme de tableau associatif
} catch (PDOException $e) {
    echo "Erreur de requête : " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        header, footer {
            background-color: #222;
            color: white;
            text-align: center;
            padding: 1rem 0;
        }

        h1 {
            text-align: center;
            color: #444;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
        }

        .product {
            background-color: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            flex-basis: calc(25% - 30px); /* 4 produits par ligne avec marge de 15px */
            box-sizing: border-box;
            text-align: center;
            transition: transform 0.2s;
            cursor: pointer;
        }

        .product:hover {
            transform: scale(1.05);
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-bottom: 1px solid #ddd;
            margin-bottom: 15px;
        }

        .product h3 {
            font-size: 1.2em;
            margin-bottom: 10px;
        }

        .product p {
            font-size: 1em;
            margin: 5px 0;
        }

        footer {
            margin-top: 20px;
        }

        .product a {
            display: block;
            text-decoration: none;
            color: inherit;
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }

        .product a:hover {
            text-decoration: none;
        }

        .product-link {
            position: relative;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var products = document.querySelectorAll('.product');
            products.forEach(function(product) {
                product.addEventListener('click', function() {
                    window.location.href = product.dataset.href;
                });
            });
        });
    </script>
</head>
<body>
    <header>
        <h1>Strapontissimo</h1>
    </header>

    <section>
        <h1>Nos Strapontins</h1>
        <div class="product-container">
            <?php foreach ($products as $product): ?>
                <div class="product" data-href="details.php?id_product=<?php echo $product['id_product']; ?>">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                    <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    <footer>
        <p>© 2024 Strapontissimo - Le confort instantané</p>
    </footer>
</body>
</html>
