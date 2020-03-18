<!-- for connection with mysql database -->
<?php
    $user = 'root';
    $pass = '';
    $db = 'dbs';
    $link = new mysqli('localhost',$user, $pass, $db) or die('unable to conect dataBase');
?>