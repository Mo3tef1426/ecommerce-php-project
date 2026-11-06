<?php
session_start();
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    exit();
}
unset($_SESSION['logged_admin']);

header('loction:../view/login.php');
exit();