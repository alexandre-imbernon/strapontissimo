<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thèmestrapontin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#">LOGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
            <ul class="navbar-nav">
            <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-user"></i>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="adminDropdown">
                        <a class="dropdown-item" href="./src/pages/connexion.php">Connexion</a>
                        <a class="dropdown-item" href="#">Inscription</a>
                        <a class="dropdown-item" href="#">Administration</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Déconnexion</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#cart">
                        <i class="fas fa-shopping-cart"></i>  
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#shop">Accueil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Nos produits</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">S'enregistrer</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
    <form action="index.php" method="GET" class="form-inline my-4">
        <input class="form-control mr-sm-2" type="search" placeholder="Rechercher des produits" aria-label="Search" name="query">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
        </form>
<main class="container mt-4">
    

    <h2 class="section-title">Nos strapontins à la une</h2>
    <div class="row">
        <!-- Les produits vont ici -->
        <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/strapontissimo/src/config/database.php';
    $conn = OpenCon();

    $search_query = "";
    if (isset($_GET['query'])) {
        $search_query = $_GET['query'];
        $sql = "SELECT * FROM products WHERE nom LIKE '%$search_query%' OR infoproduct LIKE '%$search_query%'";
    } else {
        $sql = "SELECT * FROM products";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="col-lg-4 mb-4">';
            echo '<div class="card h-100">';
            echo '<img src="'.$row["image"].'" class="card-img-top" alt="'.$row["nom"].'">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$row["nom"].'</h5>';
            echo '<p class="card-text">'.$row["infoproduct"].'</p>';
            echo '<a href="detail.php?id='.$row["id_product"].'" class="btn btn-primary btn-sm stretched-link">En savoir plus</a>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "0 résultats trouvés";
    }

    CloseCon($conn);
?>

    </div>
</main>

<footer>
    <p>&copy; 2024 Thèmestrapontin. Tous droits réservés.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
