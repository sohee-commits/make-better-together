<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
  header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Сделаем лучше вместе! — Городской портал</title>
    <link rel="shortcut icon" href="assets/logo.png" type="image/x-icon" />
    <link rel="stylesheet" href="css/user.css" />
    <link rel="stylesheet" href="css/main.css" />
    <script src="scripts/main.js" defer></script>
    <script src="scripts/user_user.js" defer></script>
  </head>

  <body>
    <?php require_once '_header.php'; ?>

    <main>
      <?php
      if ($_SESSION['user_id'] == 1) {
        require_once 'user_admin.php';
      } else {
        require_once 'user_user.php';
      }
      ?>
    </main>

    <footer>
      <div class="logo">
        <img src="assets/logo.png" alt="логотип Сделаем Лучше Вместе!" />
        <a href="index.php">Сделаем лучше вместе!</a>
      </div>
      <p>
        “Сделаем лучше вместе” — городской портал по приёму заявок на устранение
        проблем в городе
      </p>
      <p>2024</p>
    </footer>
  </body>

</html>