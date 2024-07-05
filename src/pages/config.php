<?php
$servername = "localhost";
$username = "root";
$password ="";
$dbname = "strapontissimo";

// Créer une connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Échec de la connexion: " . $conn->connect_error);
}

// Définir le jeu de caractères à UTF-8
if (!$conn->set_charset("utf8")) {
    die("Erreur lors de la définition du jeu de caractères: " . $conn->error);
}

define('ACCESS_PASSWORD', 'asmalafraude'); // Définir le mot de passe d'accès
?>