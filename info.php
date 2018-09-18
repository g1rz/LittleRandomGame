<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include_once('Db.php');

if (!isset($_GET['id'])) {
  header("Location: /?err=1");
}
$id = $_GET['id'];

$db = Db::getConnection();

$sql = "SELECT * FROM users WHERE id = :id";

$result = $db->prepare($sql);
$result->bindParam(':id', $id, PDO::PARAM_STR);
$result->execute();
$user = $result->fetch();

if ($user['visible'] != 1) {
  header("Location: /?err=2");
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
     <div class="name"><?php echo $user['name']; ?> > Информация</div>
     <div class="content">
       <img class="avatar" src="<?php echo $user['avatar']; ?>" alt=""> 
       Баланс: <?php echo $user['count']; ?> руб. <br>
       Открытых сундуков: <?php echo $user['chest'] ?> <br>
     </div>
     <div class="name">

     </div>
     <a href="./" ><span class="line">На главную</span></a>

     <div class="copyright">g1rz ©</div>
   </body>
 </html>
