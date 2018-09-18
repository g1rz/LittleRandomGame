<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once('db.php');

if (isset($_GET['err'])) {
  $err = $_GET['err'];
  switch ($err) {
    case 1:
        echo '<div class="error">Такого пользователя не существует!</div>';
      break;
    case 2:
        echo '<div class="error">Пользователь скрыл свою страницу</div>';
      break;
  }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>TinyGame</title>
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <div class="top">LittleGame</div>
    <div class="name">Главная</div>
    <div class="content">LittleGame - это экономическая игра. Стань лучшим из лучших</div>
    <div class="name"></div>

    <?php if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) { ?>
      <a href="./game.php" ><span class="line">Игра</span></a>
      <a href="./signout.php" ><span class="line">Выход</span></a>

    <?php } else {?>
      <a href="./signin.php" ><span class="line">Вход</span></a>
      <a href="./reg.php" ><span class="line">Регистрация</span></a>
    <?php } ?>

    <?php include('top.php'); ?>

    <div class="copyright">g1rz ©</div>
  </body>
</html>
