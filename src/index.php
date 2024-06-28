<?php
session_start();
require_once 'config/database.php';

$db = new DataBase();
$conn = $db->getConnection();

try {
    // Récupérer les produits phares (exemple : 4 produits aléatoires)
    $sql_featured = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
    $stmt_featured = $conn->query($sql_featured);
    $featuredProducts = $stmt_featured->fetchAll(PDO::FETCH_ASSOC);

    // Récupérer 4 autres produits aléatoires pour éviter les doublons avec les produits phares
    $sql_all = "SELECT * FROM products ORDER BY RAND() LIMIT 4";
    $stmt_all = $conn->query($sql_all);
    $allProducts = $stmt_all->fetchAll(PDO::FETCH_ASSOC);
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
    <title>Strapontissimo</title>
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
            color: white;
            text-align: center;
            padding: 4rem 0;
            position: relative;
        }

        header img {
            max-height: 100px;
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
        }

        h1 {
            margin: 0;
        }

        .welcome-message {
            text-align: center;
            margin: 20px 0;
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
            flex-basis: calc(25% - 30px);
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
</head>
<body>
    <header>
        <img src="assets/images/logo.png" alt="Logo">
        <h1>Bienvenue à Strapontissimo</h1>
    </header>

    <?php if (isset($_SESSION['user_first_name'])): ?>
        <div class="welcome-message">
            <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_first_name']); ?>!</h2>
        </div>
    <?php endif; ?>

    <section class="featured-products">
        <h2>Produits Phares</h2>
        <div class="product-container">
            <?php foreach ($featuredProducts as $product): ?>
                <div class="product" data-href="details.php?id_product=<?php echo $product['id_product']; ?>">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                    <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="latest-products">
        <h2>Derniers Produits</h2>
        <div class="product-container">
            <?php foreach ($allProducts as $product): ?>
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
</body>
</html>