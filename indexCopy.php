<?php
// MySQLi connection using mysqli_connect
include('Connection/SQLcon.php');

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Toggle the promo status
if (isset($_POST['toggle'])) {
    $query = "UPDATE `homepage` SET `showPromo` = NOT `showPromo` WHERE `ID` = 1";
    mysqli_query($conn, $query);
}

// Fetch current promo status
$result = mysqli_query($conn, "SELECT `showPromo` FROM `homepage` WHERE `ID` = 1");
$row = mysqli_fetch_assoc($result);

// Close the connection
mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Toggle Promo Popup</title>
</head>
<body>
    <h2>Promo Popup Control</h2>
    <p>Current status: <?php echo $row['showPromo'] ? 'On' : 'Off'; ?></p>
    <form method="post">
        <button type="submit" name="toggle">Toggle Promo Popup</button>
    </form>
</body>
</html>
