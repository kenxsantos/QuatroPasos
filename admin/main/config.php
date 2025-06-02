<?php
$host = 'localhost';
$dbname = 'u213582793_quatropasos';
$username = 'root';
$password = '';

//creating database connection here
$conn = mysqli_connect($host, $username, $password, $dbname);

//chek database connection naman
if (!$conn) {
    die("Connection Failed" . mysqli_connect_error());
} else {
    echo "";
}
