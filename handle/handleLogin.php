<?php
session_start();
require_once '../config/db.php';
// check method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('location:../login.php');
    exit;
}

$email =  trim($_POST['email']) ?? '';
$password = $_POST['password'] ?? '';

$errors = [];
if ($email === '' || $password === '') {
    $errors[] = "email and password are required";
}


if(empty($errors)){
    try{
        $sql = "select id , username , email ,password , role from users where email = ? limit 1";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s",  $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if($user && password_verify($password , $user['password'])){
            $_SESSION['logged_user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'email' => $user['email'],
                'role' => $user['role'],
            ];

            header('location:../index.php');
            exit();
        }
        $errors[]  = "invalid email or password";
    }catch(Exception $e){
        $errors[] = 'login error';
    }
}

$_SESSION['errors']  = $errors ; 
$_SESSION['email'] = $email ;

header('location:../login.php');
exit();


