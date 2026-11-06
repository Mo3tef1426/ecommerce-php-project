<?php 

$host = '127.0.0.1'; 
$username = 'root'; 
$password = ''; 
$database = 'ecommerce'; 
$port = 3306 ; 

try{
    $conn = mysqli_connect($host , $username , $password , $database ,$port);
    // echo "database connected successfully";
}catch(mysqli_sql_exception $e){
    echo $e->getMessage();
    exit('database conncection failed');
}