<?php
session_start();
require_once '../../config/db.php';
//check request 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../view/addProduct.php');
    exit();
}

// get data (clean) sanitization 
$cat_id = $_POST['cat'] ?? '';
$title = $_POST['title'] ?? '';
$desc = $_POST['desc'] ?? '';
$price = $_POST['price'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$image = $_FILES['img'] ?? '';

//validate data (error) 
$errors = [];

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
if (empty($quantity)) {
    $errors[] = "Quantity is required";
}

//escap (htmlspecialchars)

// image validation 
$allowedTypes = [
    'image/png' => 'png',
    'image/jpg' => 'jpg',
    'image/jpeg' => 'jpeg',
    'image/webp' => 'webp'
];

if ($image['error'] !== UPLOAD_ERR_OK) {
    $errors[] = "Image Upload is required";
} elseif ($image['size'] > 2 * 1024 * 1024) {
    $errors[] = "Image must be less than 2MB";
} else {
    $imageType = mime_content_type($image['tmp_name']);
    if (!isset($allowedTypes[$imageType])) {
        $errors[] = 'Extension not allowed';
    }
}

if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
    header('location:../view/addProduct.php');
    exit();
}

// insert with upload file and rename

$extension = $allowedTypes[$imageType];
$imageName = time() . uniqid() . '.' . $extension;
$imagePath =  '../upload/products/' . $imageName;

print_r($extension);
if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
    $_SESSION['errors'] = ['failed to upload'];
    header('location:../view/addProduct.php');
    exit();
}

//insert into DB

try {
    $sql = "insert into products(category_id,title,description,price,quantity,image) values(? , ? , ? , ? , ? , ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issdis", $cat_id, $title, $desc, $price, $quantity, $imageName);
    mysqli_stmt_execute($stmt);
    $_SESSION['success'] = ["Product added successfully"];
} catch (mysqli_sql_exception $e) {
    // remove image 
    unlink($imagePath);
    $_SESSION['errors'] = ["databse error"];
}



header('location:../view/addProduct.php');
exit();
