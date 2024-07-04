<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Utilisateur</title>
  <link rel="stylesheet" href="../assets/css/users_dashboard.css">
</head>
<body>

  <div class="container">

    <h1>Modifier vos informations</h1>

    <?php if (!empty($message)): ?>
      <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form id="userForm" method="POST">
      <div class="input-group">
        <div>
          <label for="nom">Nom:</label>
          <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user_info['nom'] ?? '') ?>" required>
        </div>
        <div>
          <label for="prenom">Prénom:</label>
          <input type="text" id="prenom" name="prenom" value="<?= htmlspecialchars($user_info['prenom'] ?? '') ?>" required>
        </div>
      </div>
      
      <label for="adresse">Adresse:</label>
      <input type="text" id="adresse" name="adresse" value="<?= htmlspecialchars($user_info['adresse'] ?? '') ?>" required>
      
      <label for="email">Email:</label>
      <input type="email" id="email" name="email" value="<?= htmlspecialchars($user_info['email'] ?? '') ?>" required>
      
      <label for="city">Ville:</label>
      <input type="text" id="city" name="city" value="<?= htmlspecialchars($user_info['city'] ?? '') ?>" required>
      
      <label for="postcode">Code Postal:</label>
      <input type="text" id="postcode" name="postcode" value="<?= htmlspecialchars($user_info['postcode'] ?? '') ?>" required>
      
      <label for="tel">Téléphone:</label>
      <input type="tel" id="tel" name="tel" value="<?= htmlspecialchars($user_info['tel'] ?? '') ?>" required>
      
      <button type="submit">Mettre à jour</button>
    </form>

    <h1>Historique des commandes</h1>
    <div class="order-history">
      <?php if (!empty($order_history)): ?>
        <?php foreach ($order_history as $order): ?>
          <div class="order-item">
            <div class="order-info">Commande #<?= $order['id_commande'] ?> - <?= $order['date_commande'] ?> - <?= htmlspecialchars($order['statut']) ?></div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <div>Aucune commande trouvée</div>
      <?php endif; ?>
    </div>

  </div>

</body>
</html>
