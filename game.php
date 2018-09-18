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
// $result->closeCursor();

// $sql = "SELECT * FROM users WHERE name = " . $login ;
// $result = $db->query($sql);
// $user = $result->fetch();

if (isset($_POST['chest'])) {
  $chest = $_POST['chest'];
}

$randChest = rand(1, 3);

if (isset($_POST['chest'])) {
  if ($user['count'] >= 5) {
    if ($randChest == $chest) {
      $count =  $user['count'] + 5;
      $chest =  $user['chest'] + 1;
      $sqlCount = "UPDATE users SET count = $count WHERE id = " . $user['id'];
      $sqlChest = "UPDATE users SET chest = $chest WHERE id = " . $user['id'];

      $db->exec($sqlCount);
      $db->exec($sqlChest);
      header("Location: /game.php?err=2");
    } else {
      $count =  $user['count'] - 5;
      $chest =  $user['chest'] + 1;
      $sqlCount = "UPDATE users SET count = $count WHERE id = " . $user['id'];
      $sqlChest = "UPDATE users SET chest = $chest WHERE id = " . $user['id'];

      $db->exec($sqlCount);
      $db->exec($sqlChest);
      // $result2->bindParam(':login', $login, PDO::PARAM_STR);
      // $result2->execute();
      header("Location: /game.php?err=3");
    }
  } else {
      header("Location: /game.php?err=1");
  }
}
if (isset($_GET['err'])) {
  if ($_GET['err'] == 1) {
    echo '<div class="error">Недостаточно средств.</div>';
  } elseif ($_GET['err'] == 2) {
    echo '<div class="success">Вы выиграли!</div>';
  } elseif ($_GET['err'] == 3) {
    echo '<div class="error">Вы проиграли!</div>';
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
     <div class="name"><?php echo $user['name']; ?> > Игра</div>
     <div class="content">
       Баланс: <?php echo $user['count']; ?> руб. <br>
       Открытых сундуков: <?php echo $user['chest'] ?> <br>
       <div class="game">
         <form action="game.php" method="post">
           <input name="chest" value="1" type="image" src="img/chest.png">
           <input name="chest" value="2" type="image" src="img/chest.png">
           <input name="chest" value="3" type="image" src="img/chest.png">
         </form>
       </div>
       <p>Стоимость 5 руб.</p>

     </div>
     <div class="name">

     </div>
     <a href="./settings.php" ><span class="line">Настройки</span></a>
     <a href="./signout.php" ><span class="line">Выход</span></a>

     <div class="copyright">g1rz ©</div>
   </body>
 </html>
