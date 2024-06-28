<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit();
}

$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "strapontissimo";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_user = $_SESSION['id_user'];
$sql = "SELECT panier.id, products.nom, products.image, products.price, panier.qté
        FROM panier
        JOIN products ON panier.id_product = products.id_product
        WHERE panier.id_user = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Tableau de Bord</h1>
    <table>
        <tr>
            <th>Produit</th>
            <th>Image</th>
            <th>Prix</th>
            <th>Quantité</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
        <?php
        $total_general = 0;
        while ($row = $result->fetch_assoc()) {
            $total = $row['price'] * $row['qté'];
            $total_general += $total;
            echo "<tr>
                    <td>{$row['nom']}</td>
                    <td><img src='{$row['image']}' alt='{$row['nom']}' style='width: 50px; height: auto;'></td>
                    <td>{$row['price']} €</td>
                    <td>{$row['qté']}</td>
                    <td>{$total} €</td>
                    <td><a href='delete.php?id={$row['id']}'>Supprimer</a></td>
                  </tr>";
        }
        ?>
        <tr>
            <td colspan="4" style="text-align: right;">Total Général :</td>
            <td colspan="2"><?php echo $total_general; ?> €</td>
        </tr>
    </table>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
