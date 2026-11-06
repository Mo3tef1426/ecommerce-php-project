<?php
session_start();

require_once '../../config/db.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../view/products.php');
    exit();
}

$id = $_POST['id'] ?? 0;

$sql = "Select image from products where id = $id";
$result = mysqli_query($conn, $sql);

$product = mysqli_fetch_assoc($result);


if (!$product) {
    $_SESSION['errors'] = ['Product not found'];
    header('location:../view/products.php');
    exit();
}


try {
    $sql = "delete from products where id = $id";
    mysqli_query($conn, $sql);

    if ($product['image']) {
        $imagePath = __DIR__ . '../upload/products/' . $product['image'];
        unlink($imagePath);
    }

    $_SESSION['success'] = ['product deleted successfully'];
} catch (mysqli_sql_exception) {
    $_SESSION['errors'] = ['failed to delete'];
}


header('location:../view/products.php');
exit();