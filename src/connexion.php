<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thèmestrapontin</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
       
        .card {
            margin-top: 50px;
        }
        .container {
            max-width: 500px;
        }
    </style>
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
                        <a class="dropdown-item" href="#">Connexion</a>
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



<main>
    <div class="container">
        <div class="card">
            <div class="card-header text-center">
                <h2>Connexion</h2>
            </div>
            <div class="card-body">
                <form action="traitement_connexion.php" method="POST">
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Se connecter</button>
                </form>
            </div>
            <div class="card-footer text-center">
                <a href="enregistrer.php">S'inscrire</a>
            </div>
        </div>
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
