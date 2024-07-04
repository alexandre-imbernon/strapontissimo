<?php
// Inclure la classe DataBase.php
require_once 'database.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['action']) && $_POST['action'] === 'add_comment') {
        $productId = $_POST['id_product'];
        $username = $_POST['username'];
        $comment = $_POST['comment'];
        $rating = $_POST['rating'];

        // Insérer ces valeurs dans la base de données (exemple)
        // Vous devrez utiliser des requêtes SQL préparées pour éviter les injections SQL

        // Exemple de connexion à la base de données et d'insertion (à adapter à votre structure)
        try {
            $db = new DataBase();
            $conn = $db->getConnection();
            
            // Exemple de requête préparée pour l'insertion
            $sql = "INSERT INTO comments (product_id, username, comment, rating) VALUES (:product_id, :username, :comment, :rating)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
            $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
            $stmt->execute();

            // Répondre avec succès (exemple)
            echo json_encode(array('success' => true));

        } catch (PDOException $e) {
            // Gérer les erreurs de base de données
            echo json_encode(array('error' => 'Erreur de base de données: ' . $e->getMessage()));
        }

    } else {
        echo json_encode(array('error' => 'Action non valide'));
    }
} else {
    echo json_encode(array('error' => 'Méthode HTTP non autorisée'));
}
?>

