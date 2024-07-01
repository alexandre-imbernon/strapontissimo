<?php
session_start();

// Détruire toutes les variables de session
$_SESSION = [];

// Si vous souhaitez également détruire le cookie de session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou d'accueil avec un paramètre pour indiquer la déconnexion
header("Location: ../index.php?logout=1");
exit;
?>
