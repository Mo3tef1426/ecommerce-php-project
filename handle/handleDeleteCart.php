<?php 
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../cart.php');
    exit;
}



$id = $_POST['id'] ?? ''; 


if(isset($_SESSION['cart'][$id])){
    
    unset($_SESSION['cart'][$id]);

    $_SESSION['success'] = ['Delete from cart successfully'];
}else{
    $_SESSION['errors'] = ['Product not found in cart'];
}



header('location:../cart.php');
exit();