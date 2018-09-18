<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

  include_once('Db.php');

  if (isset($_POST['submit'])) {

    $login = $_POST['login'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];


    if ($login != null) {
      if ($password1 == $password2) {
        if (!checkLoginExists($login)) {
          $hashPassword = password_hash($password1, PASSWORD_DEFAULT);
          register($login, $hashPassword);
        }else {
          echo '<div class="error">Такой пользователь существует</div>';
        }
      } else {
        echo '<div class="error">Пароли не совпадают</div>';
      }
    } else {
      echo '<div class="error">Укажите имя</div>';
    }
  }

function register($login, $hashPassword) {
  $db = Db::getConnection();
  $sql = "INSERT INTO users (name, password, count, chest ) VALUES ( :name, :password , '100', '0')";
  $result = $db->prepare($sql);
  $result->bindParam(':name', $login, PDO::PARAM_STR);
  $result->bindParam(':password', $hashPassword, PDO::PARAM_STR);

  return $result->execute();
}

function checkLoginExists($login) {
  $db = Db::getConnection();
  $sql = "SELECT COUNT(*) FROM users WHERE name = :login";

  $result = $db->prepare($sql);
  $result->bindParam(':login', $login, PDO::PARAM_STR);
  $result->execute();
  if ($result->fetchColumn()) {
    return true;
  }
  return false;
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
    <div class="name">Регистрация</div>
    <div class="content">
      LittleGame - это экономическая игра. Стань лучшим из лучших <br>
      <form action="reg.php" method="post">
        <input type="text" name="login" placeholder="Логин" autocomplete="off" required><br>
        <input type="password" name="password1" placeholder="Пароль" autocomplete="off" required><br>
        <input type="password" name="password2" placeholder="Подтвердите пароль" autocomplete="off" required><br>
        <input type="submit" name="submit" class="line" value="Регистрация">
      </form>
    </div>
    <div class="name"></div>
    <div class="copyright">g1rz ©</div>
  </body>
</html>
