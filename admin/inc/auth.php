<?php 

if(!isset($_SESSION['logged_admin']) && $_SESSION['logged_admin'] !== true){
  header('location:login.php');
  exit();

}