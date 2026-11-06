<?php
session_start();

if (!isset($_GET['id']) || ! array_key_exists($_GET['id'], $_SESSION['products'])) {
    header('location:products.php');
    exit();
}



$id = $_GET['id'];

unset($_SESSION['products'][$id]);
$_SESSION['success'][] = "product Delete successfully";
header('location:products.php');
exit();
