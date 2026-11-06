<?php
session_start();
require_once '../../config/db.php';


// check request 
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../view/addCategory.php');
    exit();
}

// get data 
$name = trim($_POST['name'] ?? '');
$description = trim($_POST['description'] ?? ''); // nullable

//validate data (error)
$errors = [];
if (empty($name)) {
    $errors['name'] = "name is required";
} elseif (strlen($name) < 4) {
    $errors['name'] = "name must be at least 4 characters";
}


//save 
if (empty($errors)) {
    try {
        $sql = "INSERT INTO categories (name , description) Values (? , ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            'ss',
            $name,
            $description
        );
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        $_SESSION['success'] = ["category added successfully"];
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() === 1062) {
            $errors[] = "Category Already Exist";
        } else {
            $errors[] = "Unexpected database error";
        }
    }
}
if (!empty($errors)) {
    $_SESSION['errors'] = $errors;
}

header('location:../view/addCategory.php');
exit();
