<?php
include_once('db.php');

$db = Db::getConnection();
$sqlGetUsers = "SELECT * FROM users ORDER BY count DESC LIMIT 10";
$users = $db->prepare($sqlGetUsers);
$users->execute();
$i = 0;
$userWin = '';
 ?>

<table>
  <thead>
    <tr class="name">
      <th colspan="3">Лучшие игроки</th>
    </tr>
    <tr>
      <th>Имя</th>
      <th>Баланс</th>
      <th>Открытые сундуки</th>
    </tr>
  </thead>
  <tbody>
    <?php while($user = $users->fetch()) : ?>
      <tr>
        <?php
          switch ($i) {
            case 0:
                $userWin = 'win-first';
              break;
            case 1:
                $userWin = 'win-second';
              break;
            case 2:
                $userWin = 'win-third';
              break;
          }
         ?>
        <td class="<?php echo $userWin; ?>">
          <a href="/info.php?id=<?php echo $user['id']; ?>">
            <?php echo $user['name']; ?>
          </a>
        </td>
        <td><?php echo $user['count']; ?></td>
        <td><?php echo $user['chest']; ?></td>
      </tr>
      <?php
        $userWin = '';
        $i++;
      ?>
    <?php endwhile; ?>
  </tbody>
</table>
