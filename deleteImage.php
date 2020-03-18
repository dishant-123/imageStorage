<?php
    include_once 'dbConnection.php';
    $id = $_GET['id'];
    $query = 'DELETE FROM usersimages WHERE id = '.$id.' ';
    mysqli_query($link,$query);
    header('Location: home.php');
?>