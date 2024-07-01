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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
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

        .product-details {
            max-width: 600px;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin: 20px auto; /* Centrer l'élément horizontalement */
            margin-bottom: 70px;
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
            
        }

        .product-details button {
            background-color:  #8B4513;
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

        .navbar-logo {
        height: 80px; /* Ajustez cette valeur selon la taille de votre logo */
        }

        .product-details h3 {
            text-align: center;
            color: black ;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #f8f8f8;
            border-top: 1px solid #ddd;
            margin-top: 20px;
        }

    </style>
</head>
<body>
    
<header>
    <nav class="navbar navbar-expand-lg navbar-light ">
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
                        <a class="nav-link" href="#">Nos produits</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">S'enregistrer</a>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>
</header>

    <section>
        <div class="product-details">
        <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>">
                    <p><strong>Prix : </strong> <?php echo number_format($product['price'], 2); ?> €</p>
                    <p><strong>Description :</strong><?php echo htmlspecialchars($product['infoproduct']); ?></p>
                    <br>
                    <p><strong>En stock: </strong><?php echo $product['stock']; ?></p>
                    <p><strong>Référencé le:</strong> <?php echo $product['date']; ?></p>
            <form action="panier.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $product['id_product']; ?>">
                <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['nom']); ?>">
                <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['image']); ?>">
                <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                <button type="submit">Ajouter au panier</button>
            </form>
        </div>
    </section>
    <footer>
        <p>© 2024 Strapontissimo - Le confort instantané</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
