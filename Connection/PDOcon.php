<?php
$host = 'localhost';
$dbname = 'u213582793_quatropasos';
$username = 'u213582793_quatropasos';
$password = 'Quatropasos@12345';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}
