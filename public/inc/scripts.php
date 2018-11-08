<?php

echo '<script src="https://unpkg.com/vue/dist/vue.js"></script>';
echo '<script>';
$serverIp = $_SERVER['HTTP_HOST'];
echo 'const serverIP="'.$serverIp.'";';
echo 'const baseURL="/"'; 
echo '</script>';

?>

