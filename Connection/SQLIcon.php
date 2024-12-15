<?php 
    $host = 'localhost'; 
    $dbname = 'u979976746_QuatroPasos';
    $username = 'u979976746_QuatroPasos'; 
    $password = 'QuatroPasos123'; 
    
    // Create connection to the MySQL database
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>