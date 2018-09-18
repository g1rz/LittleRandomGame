<?php
SetCookie("login", $login, time()-3600);
SetCookie("password", $user['password'], time()-3600);

header('Location: /');

 ?>
