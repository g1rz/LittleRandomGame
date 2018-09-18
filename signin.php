<?php
  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  include_once('Db.php');
  session_start();
  if (isset($_COOKIE['login']) && isset($_COOKIE['password'])) {
    header('Location: game.php');
  }

  if (isset($_POST['submit'])) {

    $login = $_POST['login'];
    $password = $_POST['password1'];

    $db = Db::getConnection();

    $sql = "SELECT * FROM users WHERE name = :login";

    $result = $db->prepare($sql);
    $result->bindParam(':login', $login, PDO::PARAM_STR);
    $result->execute();
    $user = $result->fetch();
    if ($user) {
      if (password_verify($password, $user['password'])) {

        SetCookie("login", $login, time()+3600);
        SetCookie("password", $user['password'], time()+3600);

        header('Location: game.php');
      } else {
        echo '<div class="error">Наверный пароль</div>';
      }
    } else {
      echo '<div class="error">Такого пользователя не существует</div>';
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
    <div class="name">Вход</div>
    <div class="content">
      LittleGame - это экономическая игра. Стань лучшим из лучших <br>
      <form action="signin.php" method="post">
        <input type="text" name="login" placeholder="Логин" autocomplete="off" required><br>
        <input type="password" name="password1" placeholder="Пароль" autocomplete="off" required><br>
        <input type="submit" name="submit" class="line" value="Вход">
      </form>
    </div>
    <div class="name"></div>
    <div class="copyright">g1rz ©</div>
  </body>
</html>
