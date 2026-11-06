<?php 
// session 

session_start();
require_once '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../shop.php');
    exit;
}


$id = $_POST['id'] ; 
$quantity = $_POST['quantity'] ?? 1 ; 


$sql = "select * from products where id = $id";

$result = mysqli_query($conn , $sql);
$product = mysqli_fetch_assoc($result);

if(!$product){
    $_SESSION['errors'] = ['product not exist'];
    header('location:../shop.php');
    exit();
}


// qty , id 


if(!isset($_SESSION['cart'])){
    $_SESSION['cart'] = [];
}

//store data 

if(isset($_SESSION['cart'][$id])){
    $_SESSION['cart'][$id]['cart_quantity'] += $quantity ; 
}else{
    $_SESSION['cart'][$id] = [
        'title' => $product['title'] , 
        'price' => $product['price'] , 
        'image' => $product['image'] , 
        'cart_quantity' => $quantity 
    ];
}


$_SESSION['success'] = ['product added to cart success']; 

header("location:../product.php?id=$id");
exit();