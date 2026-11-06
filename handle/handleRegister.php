<?php
session_start();
require_once '../config/db.php';

// check method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../signup.php');
    exit;
}


// fetch data 
$username = trim($_POST['username']) ?? '';
$email =  trim($_POST['email']) ?? '';
$password = $_POST['password'] ?? '';
$phone =  trim($_POST['phone']) ?? '';
$address =  trim($_POST['address']) ?? '';


// validation 
$errors = [];

if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
    $errors[] = "Invalid UserName";
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid Email";
}
if (strlen($password) < 6) {
    $errors[] = 'Password must be at least 6 chars';
}

if (empty($phone)) {
    $errors[] = "phone is required";
}
if (empty($address)) {
    $errors[] = "address is required";
}


// insert data 
if (empty($errors)) {
    try {
        // check duplication 
        // $sql = "select id from users where email=? limit 1";
        // $result = mysqli_query($conn , $sql);
        // if(mysqli_num_rows($result) > 0){
        //     $errors[] = "email already exist";
        // }

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "insert into users(username , email,password ,phone, address) VALUES(? , ?  , ? , ?  , ? )";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $username, $email, $hashed_password, $phone, $address);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['success'] = ['Registration Success'];
        header('location:../login.php');
        exit;
    } catch (Exception $e) {
        if ($e->getCode() === 1062) {
            $errors[] = "Email Already Exits";
        } else {
            $errors[] = "registration failed";
        }
    }
}

// save errors
$_SESSION['errors'] = $errors;

$_SESSION['username'] = $username;
$_SESSION['email'] = $email;
$_SESSION['phone'] = $phone;
$_SESSION['address'] = $address;

header('location:../signup.php');
exit();
