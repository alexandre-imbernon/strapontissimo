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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }
        
        .modal {
            display: none;
            position: fixed;
            z-index: 1050;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            outline: 0;
            background-color: rgba(0, 0, 0, 0.5);
            border-radius: 10px;
        }

        .modal-modern .modal-content {
            border-radius: 10px;
            overflow: hidden;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .modal-modern .modal-header {
            background-color: #f1f1f1;
            color: white;
            border-bottom: none;
            padding: 10px;
        }

        .modal-modern .modal-title {
            font-weight: bold;
            font-size: 1.5em;
            color: #8B4513;
            position:center;
        }

        .modal-modern .modal-body {
            padding: 20px;
            font-size: 1.1em;
            color: #333;
        }

        .modal-modern .modal-footer {
            background-color: #f1f1f1;
            border-top: none;
            padding: 10px;
        }

        .modal-modern .btn-brown:hover {
            background-color: red;
        }

        .btn-brown {
            background-color: #8B4513;
            color: white;
        }


        .navbar-logo {
            height: 80px;
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
            text-align: center;
            transition: transform 0.2s;
            cursor: pointer;
            position: relative;
            overflow: hidden;
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


        .product a {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(0, 0, 0, 0.1);
            color: #fff;
            text-decoration: none;
            opacity: 0;
            transition: opacity 0.2s;
        }

        .product:hover {
            transform: scale(1.05);
        }

        .product-link {
            position: relative;
        }

        footer {
            margin-top: 10px;
            position: relative;
        }

        .main-content {
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
            background-image: url("./assets/images/fd.png");
            background-size: cover;
            color : white;
            text-shadow: 3px 3px 4px black;
        }

        .product:hover a {
            opacity: 1;
        }

        .section-title {
            text-align: center;
            margin-bottom: 40px;
            font-size: 2em;
            text-shadow: 3px 3px 6px #715439;
            color: #715439;
        }

        .section-content {
            padding: 40px 0;
        }
        
        h2{
            font-size:60px;
        }

        @media (max-width: 576px) {
            .product {
                flex: 0 0 100%;
            }
        }

        @media (min-width: 577px) and (max-width: 768px) {
            .product {
                flex: 0 0 48%;
            }
        }

        @media (min-width: 769px) and (max-width: 992px) {
            .product {
                flex: 0 0 30%;
            }
        }

        @media (min-width: 993px) {
            .product {
                flex: 0 0 22%;
            }
        }
        
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container">
                <a class="navbar-brand" href="#">
                    <img src="./assets/images/logoo.png" alt="Logo" class="navbar-logo">
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
                                <?php if (isset($_SESSION['user_first_name'])): ?>
                                    <div class="welcome-message">
                                        <a href="../src/include/logout.php">Déconnexion</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo isset($_SESSION['user_first_name']) ? 'panier.php' : 'include/login.php'; ?>">
                                <i class="fas fa-shopping-cart"></i>  
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Accueil</a>
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
        <div class="main-content">
            <?php if (isset($_SESSION['user_first_name'])): ?>
                <div class="welcome-message">
                    <h2>Bienvenue, <?php echo htmlspecialchars($_SESSION['user_first_name']); ?>!</h2>
                </div>
            <?php endif; ?>
        </div>

        <section class="section-content">
            <div class="container">
                <h2 class="section-title">Nos Produits Phares</h2>
                <hr>
                <div class="product-container">
                    <?php foreach ($featuredProducts as $product): ?>
                        <div class="product" data-href="details.php?id_product=<?php echo $product['id_product']; ?>">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                            <a href="details.php?id_product=<?php echo $product['id_product']; ?>">Voir détails</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <section class="section-content">
            <div class="container">
                <h2 class="section-title">Nos Derniers Produits</h2>
                <hr>
                <div class="product-container">
                    <?php foreach ($allProducts as $product): ?>
                        <div class="product" data-href="details.php?id_product=<?php echo $product['id_product']; ?>">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                            <a href="details.php?id_product=<?php echo $product['id_product']; ?>">Voir détails</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Modal -->
        <div class="modal fade modal-modern" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Déconnexion</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Vous avez été déconnecté avec succès.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-brown" data-dismiss="modal">OK</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scripts Bootstrap et jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

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
                // Vérifiez si l'utilisateur vient de se déconnecter
                <?php if (isset($_GET['logout']) && $_GET['logout'] == 1): ?>
                    $('#logoutModal').modal('show');
                <?php endif; ?>
            });
        </script>
    </main>
</body>
</html>
