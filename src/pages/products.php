<?php
require_once '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new DataBase();
    $searchTerm = isset($_POST['term']) ? $_POST['term'] : '';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $subCategory = isset($_POST['subCategory']) ? $_POST['subCategory'] : '';

    try {
        $conn = $db->getConnection();
        $sql = "SELECT p.id_product, p.nom, p.image 
                FROM products p 
                JOIN subcategory sc ON p.id_subcategory = sc.id_subcategory
                JOIN category c ON p.id_category = c.id_category
                WHERE p.nom LIKE :term";

        $params = array(':term' => '%' . $searchTerm . '%');

        // Ajouter la logique pour les filtres de catégorie et sous-catégorie si nécessaire
        if ($category) {
            $sql .= " AND c.nom = :category"; // Utilisation de c.nom si la colonne nom de category contient le nom de la categorie
            $params[':category'] = $category;
        }
        if ($subCategory) {
            $sql .= " AND sc.nom = :subCategory"; // Utilisation de sc.nom si la colonne nom de subcategory contient le nom de la sous-categorie
            $params[':subCategory'] = $subCategory;
        }

        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($products);
        exit;
    } catch (PDOException $e) {
        echo json_encode(['error' => "Erreur de requête : " . $e->getMessage()]);
        exit;
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Produits</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/products.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
        
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../assets/images/logoo.png" alt="Logo" class="navbar-logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="panier.php" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user"></i>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="adminDropdown">
                            <a class="dropdown-item" href="login.php">Connexion</a>
                            <a class="dropdown-item" href="register.php">Inscription</a>
                            <a class="dropdown-item" href="#">Administration</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="#">Déconnexion</a>
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
                        <a class="nav-link" href="products.php"><strong>Nos produits</strong></a>
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
    <section>
        <h2>Tous Nos Strapontins...</h2>

        <!-- Barre de recherche -->
        <div class="container mb-3">
            <div class="input-group">
                <input type="text" id="searchInput" class="form-control" placeholder="Rechercher par nom de produit">
                <select id="categorySelect" class="form-control">
                    <option value="">Toutes les catégories</option>
                    <option value="interieur">Intérieur</option>
                    <option value="exterieur">Extérieur</option>
                </select>
                <select id="subCategorySelect" class="form-control">
                    <option value="">Toutes les sous-catégories</option>
                    <option value="bois">Bois</option>
                    <option value="plastique">Plastique</option>
                    <option value="metal">Métal</option>
                </select>
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="button" id="searchButton">Rechercher</button>
                </div>
            </div>
        </div>

        <div class="container product-container" id="productContainer">
            <div class="row">
                <?php
                // Initialisation de la connexion
                $db = new DataBase();

                try {
                    $conn = $db->getConnection();
                    $sql = "SELECT * FROM products";
                    $stmt = $conn->prepare($sql);
                    $stmt->execute();
                    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Afficher les produits initialement
                    foreach ($products as $product) {
                        echo '<div class="col-12 col-sm-6 col-md-4 col-lg-3">';
                        echo '<div class="product" data-href="details.php?id_product=' . $product['id_product'] . '">';
                        echo '<img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['nom']) . '">';
                        echo '<h3>' . htmlspecialchars($product['nom']) . '</h3>';
                        echo '<div class="overlay">Voir détails</div>';
                        echo '</div>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo "Erreur de connexion : " . $e->getMessage();
                }
                ?>
            </div>
        </div>
    </section>
    
</main>

<footer>
    <p>© 2024 Strapontissimo - Le confort instantané</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../assets/js/bar.js"></script></body>
</html>