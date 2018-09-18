<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once('Db.php');


if (!isset($_COOKIE['login']) && !isset($_COOKIE['password'])) {
  header('Location: signin.php');
}

$login = $_COOKIE['login'];

$db = Db::getConnection();

$sql = "SELECT * FROM users WHERE name = :login";

$result = $db->prepare($sql);
$result->bindParam(':login', $login, PDO::PARAM_STR);
$result->execute();
$user = $result->fetch();

if (isset($_POST['submit'])) {
  $visibleNew = $_POST['visible'];
  $sqlVisible = "UPDATE users SET visible = $visibleNew WHERE id = " . $user['id'];

  $db->exec($sqlVisible);
  $result->execute();
  $user = $result->fetch();
}

$visible = $user['visible'];
$visYes = '';
$visNo = '';
if ($visible == 1) {
  $visYes = 'checked';
  $visNo = '';
} else {
  $visYes = '';
  $visNo = 'checked';
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
     <div class="name"><?php echo $user['name']; ?> > Настройки</div>
     <div class="content">

       <form action="settings.php" method="post">
         <p><b>Настройки приватности</b></p>
         <p>Показывать профиль другим пользователям?</p>
         <label><input type="radio" name="visible" value="1" <?php echo $visYes; ?>>Да</label>
         <label><input type="radio" name="visible" value="0" <?php echo $visNo; ?>>Нет</label>
         <input type="submit" name="submit" value="Сохранить" class="line">
       </form>

     </div>
     <div class="name">

     </div>
     <a href="./game.php" ><span class="line">Назад</span></a>

     <div class="copyright">g1rz ©</div>
   </body>
 </html>
