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

        // Requête SQL pour récupérer les commentaires du produit
        $sql_comments = "SELECT * FROM comments WHERE id_product = :id_product ORDER BY created_at DESC";
        $stmt_comments = $conn->prepare($sql_comments);
        $stmt_comments->bindParam(':id_product', $productId, PDO::PARAM_INT);
        $stmt_comments->execute();
        $comments = $stmt_comments->fetchAll(PDO::FETCH_ASSOC);

        // Code pour insérer un nouveau commentaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment'])) {
            $username = $_POST['username']; // À sécuriser
            $comment = $_POST['comment']; // À sécuriser
            $rating = intval($_POST['rating']);

            $insert_sql = "INSERT INTO comments (id_product, username, comment, rating) VALUES (:id_product, :username, :comment, :rating)";
            $stmt_insert = $conn->prepare($insert_sql);
            $stmt_insert->bindParam(':id_product', $productId, PDO::PARAM_INT);
            $stmt_insert->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt_insert->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt_insert->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt_insert->execute();

            // Redirection après insertion pour éviter le renvoi du formulaire
            header("Location: details.php?id_product=$productId");
            exit();
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
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/css/details.css">
    <style>
        .star-rating {
            display: flex;
            direction: row-reverse;
            font-size: 2rem;
            justify-content: center;
            padding: 1rem;
        }
        .star-rating input {
            display: none;
        }
        .star-rating label {
            cursor: pointer;
            color: #ccc;
            transition: color 0.2s;
        }
        .star-rating input:checked ~ label,
        .star-rating input:checked ~ label ~ label {
            color: #f5b301;
        }
        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #f5b301;
        }
    </style>
</head>
<body>
    
<header>
    <nav class="navbar navbar-expand-lg navbar-light ">
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

<!-- Section détails du produit -->
<section>
    <div class="container">
        <div class="row">
            <!-- Colonne pour l'image -->
            <div class="col-lg-6">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['nom']); ?>" class="img-fluid">
            </div>
            
            <!-- Colonne pour les détails du produit -->
            <div class="col-lg-6">
                <div class="product-details">
                    <!-- Affichage des détails du produit -->
                    <h3><?php echo htmlspecialchars($product['nom']); ?></h3>
                    <p ><strong>Prix : </strong><?php echo number_format($product['price'], 2); ?> €</p>
                    <p><strong>Description :</strong> <?php echo htmlspecialchars($product['infoproduct']); ?></p>
                    <p><strong>En stock: </strong><?php echo $product['stock']; ?></p>
                    <p><strong>Référencé le:</strong> <?php echo $product['date']; ?></p>
                    
                    <!-- Formulaire d'ajout au panier -->
                    <form action="panier.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id_product']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product['nom']); ?>">
                        <input type="hidden" name="product_image" value="<?php echo htmlspecialchars($product['image']); ?>">
                        <input type="hidden" name="product_price" value="<?php echo $product['price']; ?>">
                        <button type="submit" class="btn btn-primary">Ajouter au panier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
<div class="commentaire">
<h4>Avis des utilisateurs</h4>
        <form action="details.php?id_product=<?php echo $productId; ?>" method="post">
            <label for="username">Nom d'utilisateur :</label><br>
            <input type="text" id="username" name="username" required><br><br>
            <label for="comment">Commentaire :</label><br>
            <textarea id="comment" name="comment" rows="4" required></textarea><br><br>
            <label for="rating">Note :</label>
            <div class="star-rating">
                <input type="radio" id="5-stars" name="rating" value="5" />
                <label for="5-stars" class="star">&#9733;</label>
                <input type="radio" id="4-stars" name="rating" value="4" />
                <label for="4-stars" class="star">&#9733;</label>
                <input type="radio" id="3-stars" name="rating" value="3" />
                <label for="3-stars" class="star">&#9733;</label>
                <input type="radio" id="2-stars" name="rating" value="2" />
                <label for="2-stars" class="star">&#9733;</label>
                <input type="radio" id="1-star" name="rating" value="1" />
                <label for="1-star" class="star">&#9733;</label>
            </div><br><br>
            <button type="submit" name="submit_comment">Soumettre</button>
        </form>

        <!-- Affichage des commentaires -->
        <div class="comments">
            <?php foreach ($comments as $comment) : ?>
                <div class="comment">
                    <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong> - <?php echo htmlspecialchars($comment['created_at']); ?></p>
                    <p><?php echo htmlspecialchars($comment['comment']); ?></p>
                    <p>Note : <?php echo str_repeat('&#9733;', $comment['rating']) . str_repeat('&#9734;', 5 - $comment['rating']); ?></p>
                </div>
            <?php endforeach; ?>
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