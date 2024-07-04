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
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="assets/css/index.css">
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
                            <a class="nav-link dropdown-toggle" href="pages/panier.php" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-user"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="adminDropdown">
                                <a class="dropdown-item" href="pages/login.php">Connexion</a>
                                <a class="dropdown-item" href="pages/register.php">Inscription</a>
                                <a class="dropdown-item" href="#">Administration</a>
                                <div class="dropdown-divider"></div>
                                <?php if (isset($_SESSION['user_first_name'])): ?>
                                    <div class="welcome-message">
                                        <a href="pages/logout.php">Déconnexion</a>
                                    </div>
                                <?php endif; ?>

                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo isset($_SESSION['user_first_name']) ? 'pages/panier.php' : 'pages/login.php'; ?>">
                                <i class="fas fa-shopping-cart"></i>  
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><strong>Accueil</strong></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="pages/products.php">Nos produits</a>
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
                        <div class="product" data-href="pages/details.php?id_product=<?php echo $product['id_product']; ?>">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                            <a href="pages/details.php?id_product=<?php echo $product['id_product']; ?>">Voir détails</a>
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
                        <div class="product" data-href="pages/details.php?id_product=<?php echo $product['id_product']; ?>">
                            <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                            <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                            <a href="pages/details.php?id_product=<?php echo $product['id_product']; ?>">Voir détails</a>
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