<?php
session_start();

require('db.php');

if(!empty($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM phonecontacts WHERE `phonecontacts`.`id` = $id";
    mysqli_query($conn, $sql);


$_SESSION['message'] = 'Record has been deleted succesfully';

    header('Location: index.php');
    exit();
}

