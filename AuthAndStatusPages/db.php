<?php
$servername = "localhost";
$dbname = 'u213582793_quatropasos';
$username = 'u213582793_quatropasos';
$password = 'Quatropasos@12345';
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
