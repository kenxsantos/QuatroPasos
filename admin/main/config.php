<?php
$host = 'localhost';
$dbname = 'u979976746_QuatroPasos';
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
