<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "strapontissimo";

// Créer une connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Supprimer un produit
if (isset($_GET['delete'])) {
    $id_product = $_GET['delete'];
    $sql = "DELETE FROM products WHERE id_product = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_product);
    $stmt->execute();
    $stmt->close();
    header("Location: dashboard.php");
    exit();
}

// Récupérer les catégories
$sql = "SELECT * FROM category";
$result = $conn->query($sql);
$categories = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}

// Récupérer les sous-catégories
$sql = "SELECT * FROM subcategory";
$result = $conn->query($sql);
$subcategories = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $subcategories[] = $row;
    }
}

// Récupérer les produits par sous-catégorie
$products_by_subcategory = [];
foreach ($subcategories as $subcategory) {
    $sql = "SELECT products.*, category.nom as category_name
            FROM products
            LEFT JOIN category ON products.id_category = category.id_category
            WHERE id_subcategory = " . $subcategory['id_subcategory'];
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $products_by_subcategory[$subcategory['id_subcategory']] = [];
        while($row = $result->fetch_assoc()) {
            $products_by_subcategory[$subcategory['id_subcategory']][] = $row;
        }
    }
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $infoproduct = $_POST['infoproduct'];
    $price = $_POST['price'];
    $image = $_POST['image'];
    $stock = $_POST['stock'];
    $id_category = $_POST['id_category'];
    $id_subcategory = $_POST['id_subcategory'];

    $sql = "INSERT INTO products (nom, infoproduct, price, image, stock, id_category, id_subcategory, date)
            VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdssii", $nom, $infoproduct, $price, $image, $stock, $id_category, $id_subcategory);

    if ($stmt->execute()) {
        header("Location: dashboard.php"); // Rediriger pour éviter la soumission multiple
        exit();
    } else {
        echo "Erreur: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Ajouter un Article</title>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Bienvenue: <?= $_SESSION['admin_name'] ?></h2>
            <h3>DASHBOARD</h3>
            <p>STRAPONTISSIMO</p>
            <h4>NAVIGATION</h4>
            <nav class="nav">
                <ul>
                    <li><a href="#">Accueil</a></li>
                    <li><a href="#">Produits</a></li>
                    <li><a href="#">Intérieur Bois</a></li>
                    <li><a href="#">Intérieur Plastique</a></li>
                    <li><a href="#">Intérieur Métal</a></li>
                    <li><a href="#">Extérieur Bois</a></li>
                    <li><a href="#">Extérieur Plastique</a></li>
                    <li><a href="#">Extérieur Métal</a></li>
                    <li><a href="#" class="logout">Déconnexion</a></li>
                </ul>
            </nav>
        </div>
        <div class="main-content">
            <h1>Ajouter un Article</h1>
            <form action="dashboard.php" method="post">
                <label for="nom">Nom du produit:</label>
                <input type="text" id="nom" name="nom" required><br>
                
                <label for="infoproduct">Description du produit:</label>
                <textarea id="infoproduct" name="infoproduct" required></textarea><br>
                
                <label for="price">Prix:</label>
                <input type="number" id="price" name="price" step="0.01" required><br>
                
                <label for="image">URL de l'image:</label>
                <input type="text" id="image" name="image" required><br>
                
                <label for="stock">Stock:</label>
                <input type="number" id="stock" name="stock" required><br>
                
                <label for="id_category">Catégorie:</label>
                <select id="id_category" name="id_category" required>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= $category['id_category'] ?>"><?= $category['nom'] ?></option>
                    <?php endforeach; ?>
                </select><br>
                
                <label for="id_subcategory">Sous-catégorie:</label>
                <select id="id_subcategory" name="id_subcategory" required>
                    <?php foreach ($subcategories as $subcategory): ?>
                        <option value="<?= $subcategory['id_subcategory'] ?>"><?= $subcategory['nom'] ?></option>
                    <?php endforeach; ?>
                </select><br>
                
                <input type="submit" value="Ajouter">
            </form>
            
            <?php foreach ($subcategories as $subcategory): ?>
                <?php if (isset($products_by_subcategory[$subcategory['id_subcategory']])): ?>
                    <h2 style="margin-top: 40px;">Produits pour <?= $subcategory['nom'] ?> (<?= $products_by_subcategory[$subcategory['id_subcategory']][0]['category_name'] ?>)</h2>
                    <table>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Stock</th>
                            <th>Image</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                        <?php foreach ($products_by_subcategory[$subcategory['id_subcategory']] as $product): ?>
                            <tr>
                                <td><?= $product['nom'] ?></td>
                                <td><?= $product['infoproduct'] ?></td>
                                <td><?= $product['price'] ?> €</td>
                                <td><?= $product['stock'] ?></td>
                                <td><img src="<?= $product['image'] ?>" alt="<?= $product['nom'] ?>" width="50"></td>
                                <td><?= $product['date'] ?></td>
                                <td><a href="dashboard.php?delete=<?= $product['id_product'] ?>" class="delete">❌</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
