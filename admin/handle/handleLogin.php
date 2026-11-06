<?php 

session_start();
require_once '../../config/db.php';
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
$sql = "select id , username , email ,password , role from users where email = ? AND role = 'admin' limit 1";
  $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s",  $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $admin = mysqli_fetch_assoc($result);
        mysqli_stmt_close($stmt);


        if($admin && password_verify($password , $admin['password'])){
            $_SESSION['logged_admin'] = [
                'id' => $admin['id'] , 
                'username' => $admin['username']
            ];

            header('location:../view/layout.php');
            exit();
        }

        $errors []= "invalid email or password"; 

    }catch(Exception $e){
        $errors [] = "Login Failed";
    }

}


$_SESSION['errors'] = $errors; 
$_SESSION['email'] = $email ; 

header('location:../view/login.php');
exit();