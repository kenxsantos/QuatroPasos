<?php
include 'db.php';

if (isset($_GET['code'])) {
    $verification_code = $_GET['code'];

    // Check if code exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE verification_code = ? AND is_verified = 0");
    $stmt->bind_param("s", $verification_code);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Update user status
        $stmt = $conn->prepare("UPDATE users SET is_verified = 1 WHERE verification_code = ?");
        $stmt->bind_param("s", $verification_code);
        $stmt->execute();

        echo "Email successfully verified! You can now log in.";
    } else {
        echo "Invalid or already verified email!";
    }
    $stmt->close();
}

$conn->close();
?>