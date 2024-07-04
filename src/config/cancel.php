<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Strapontissimo</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400..700;1,400..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .navbar-logo {
            height: 80px;
        }

        .main-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: url("./assets/images/fd.png");
            background-size: cover;
            color: white;
            text-shadow: 3px 3px 4px black;
            text-align: center;
        }

        h2 {
            font-size: 60px;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #d1c7be;
            border-top: 1px solid #ddd;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <main class="main-content">
        <?php if (isset($_SESSION['user_first_name'])): ?>
            <div class="welcome-message">
                <h2>Paiement échoué <?php echo htmlspecialchars($_SESSION['user_first_name']); ?>, vous n'avez pas été prélevé, Redirection dans 3 secondes...</h2>
            </div>
        <?php else: ?>
            <div class="welcome-message">
                <h2>Paiement échoué, Redirection dans 3 secondes...</h2>
            </div>
        <?php endif; ?>
    </main>

    <footer>
        <p>© 2024 Strapontissimo - Le confort instantané</p>
    </footer>

    <script>
      setTimeout(function() {
    window.location.href = "../index.php";
}, 3000);
    </script>
</body>
</html>
