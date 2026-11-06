<?php

session_start();
require_once '../../config/db.php';

//check request method 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../view/products.php');
    exit();
}

//get data 
$id = $_POST['id'] ?? '';
$cat_id = $_POST['cat'] ?? '';
$title = $_POST['title'] ?? '';
$desc = $_POST['desc'] ?? '';
$price = $_POST['price'] ?? '';
$qty = $_POST['quantity'] ?? '';
$image = $_FILES['img'] ?? '';

$allowedTypes = [
    'image/png' => 'png',
    'image/jpg' => 'jpg',
    'image/jpeg' => 'jpeg',
    'image/webp' => 'webp'
];

//validate data 

$errors = [];
if (empty($id)) {
    $errors[] = "ID is required";
}
if (empty($cat_id)) {
    $errors[] = "Category is required";
}
if (empty($title)) {
    $errors[] = "Title is required";
}
if (empty($desc)) {
    $errors[] = "Description is required";
}
if (empty($price)) {
    $errors[] = "Price is required";
}
if (empty($qty)) {
    $errors[] = "Quantity is required";
}


// check if user upload a new image 
$hasNewImage = $image && $image['error'] !== UPLOAD_ERR_NO_FILE;

$allowedTypes = [
    'image/png' => 'png',
    'image/jpg' => 'jpg',
    'image/jpeg' => 'jpeg',
    'image/webp' => 'webp'
];

if ($hasNewImage) {
    if ($image['size'] > 2 * 1024 * 1024) {
        $errors[] = "Image must be less than 2MB";
    } else {
        $imageType = mime_content_type($image['tmp_name']);
        if (!isset($allowedTypes[$imageType])) {
            $errors[] = "Image type not allowed";
        }
    }
}


if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('location:../view/editProduct.php?id=' . $id);
    exit();
}

//get old image
$sql = "SELECT image FROM products WHERE id = $id";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);


if (!$product) {
    $_SESSION['errors'] = ["Product not found"];
    header('location:../view/products.php');
    exit();
}

$oldImage = $product['image'];

$imageNew = $oldImage;
// wrong uploaded folder 
// first issue (we store in upload/products) not upload only 
$uploadFolder = __DIR__ . '/../upload/products/';
$newImagePath = null;

if ($hasNewImage) {

    $extension = $allowedTypes[$imageType];
    // imageNew instead of imageName (second issue)
    $imageNew = uniqid() . '.' . $extension;
    $newImagePath = $uploadFolder . $imageNew;

    if (!move_uploaded_file($image['tmp_name'], $newImagePath)) {
        $_SESSION['errors'] = ['Image upload failed'];
        header("Location: ../view/editProduct.php?id=$id");
        exit;
    }
}


try {
    $sql = "update products set category_id = ?, title = ?, description = ?, price = ?, quantity = ? , image = ? where id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    // wrong here !! (third isssue) we forget the i in bind paramater about id ()
    mysqli_stmt_bind_param($stmt, "issdisi", $cat_id, $title, $desc, $price, $qty, $imageNew, $id);
    mysqli_stmt_execute($stmt);
    $_SESSION['success'] = ["Product updated successfully"];
} catch (mysqli_sql_exception $e) {
 
    // Delete new image if UPDATE fails 
    if ($newImagePath && is_file($newImagePath)) {
        unlink($newImagePath);
    }

    $_SESSION['errors'] = ["Database error"];

}

// fourth issue , delete old image 
// Delete old image after successful UPDATE
if ($hasNewImage && $oldImage) {

    $oldImagePath = $uploadFolder . basename($oldImage);

    if (is_file($oldImagePath)) {
        unlink($oldImagePath);
    }
}



header('location:../view/products.php');
exit();

