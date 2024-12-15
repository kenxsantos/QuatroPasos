<?php
$host = 'localhost';
$dbname = 'quatropasoshotel';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_GET['id'])) {
        $roomId = $_GET['id'];
        $stmt = $conn->prepare("SELECT img FROM room WHERE ID = :id");
        $stmt->bindParam(':id', $roomId);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['img'])) {
            // Output the correct headers to show the image
            header("Content-Type: image/jpeg");
            echo $row['img'];
        } else {
            echo "Image not found.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$conn = null;
?>
