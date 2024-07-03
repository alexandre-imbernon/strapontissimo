<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new DataBase();
    $searchTerm = isset($_POST['term']) ? $_POST['term'] : '';

    try {
        $conn = $db->getConnection();
        $sql = "SELECT * FROM products";
        if (!empty($searchTerm)) {
            $sql .= " WHERE nom LIKE :term";
        }
        $stmt = $conn->prepare($sql);
        if (!empty($searchTerm)) {
            $stmt->bindValue(':term', '%' . $searchTerm . '%', PDO::PARAM_STR);
        }
        $stmt->execute();
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
            font-family: Lora;
        }
        
        h2 {
            margin-top: 15px;
            font-style: italic;
            text-align: center;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            margin-bottom: 40px;
        }

        .product {
            background-color: white;
            border-radius: 5px;
            margin: 15px;
            padding: 20px;
            flex-basis: calc(25% - 30px);
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

        .navbar-logo {
            height: 80px;
        }
        
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 1000;
            background-color: #f8f8f8 !important; 
            border: 1px solid ;
            border-radius: 4px;
        }

        .ui-autocomplete .ui-menu-item {
            padding: 10px;
            cursor: pointer;
        }

        .ui-autocomplete .ui-menu-item:hover {
            background-color: white !important; /* Marron */
            color: white;
        }
        footer {
            margin-top: 10px;
            position: relative;
        }

        h2{
            text-shadow : 3px 3px 4px #d1c7be;
        }
    </style>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="assets/images/logoo.png" alt="Logo" class="navbar-logo">
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
                            <a class="dropdown-item" href="#">Connexion</a>
                            <a class="dropdown-item" href="#">Inscription</a>
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
                        <a class="nav-link" href="#">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><strong>Nos produits</strong></a>
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
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="button" id="searchButton">Rechercher</button>
                    </div>
                </div>
            </div>

            <div class="product-container" id="productContainer">
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
                        echo '<div class="product" data-href="details.php?id_product=' . $product['id_product'] . '">';
                        echo '<img src="' . htmlspecialchars($product['image']) . '" alt="' . htmlspecialchars($product['nom']) . '">';
                        echo '<h3>' . htmlspecialchars($product['nom']) . '</h3>';
                        echo '</div>';
                    }
                } catch (PDOException $e) {
                    echo "Erreur de connexion : " . $e->getMessage();
                }
                ?>
            </div>
        </section>
    </main>

    <footer>
        <p>© 2024 Strapontissimo - Le confort instantané</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
