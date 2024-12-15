<?php 
$host = 'localhost'; 
$dbname = 'u979976746_QuatroPasos';
$username = 'u979976746_QuatroPasos'; 
$password = 'QuatroPasos123'; 
    
    //creating database connection here
    $conn = mysqli_connect($host, $username, $password, $database);

    //chek database connection naman
    if(!$conn)
    {
        die("Connection Failed". mysqli_connect_error());
    }
    else
    {
        echo "";
    }

?>