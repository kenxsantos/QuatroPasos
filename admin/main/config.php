<?php

$server = "localhost";
$username = "root";
$password = "";
$database = "quatropasoshotel2";

$conn = mysqli_connect($server,$username,$password,$database);

if(!$conn){
    die("<script>alert('connection Failed.')</script>"); 
}
else{
    
 }
?>