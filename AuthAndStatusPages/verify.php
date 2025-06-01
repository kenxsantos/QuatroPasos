<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        text-align: center;
        width: 400px;
    }

    h2 {
        color: #333;
    }

    p {
        font-size: 16px;
        color: #555;
    }

    .success {
        color: #28a745;
        font-weight: bold;
    }

    .error {
        color: #dc3545;
        font-weight: bold;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        margin-top: 15px;
        font-size: 16px;
        color: white;
        background: #007bff;
        border: none;
        border-radius: 5px;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.3s;
    }

    .btn:hover {
        background: #0056b3;
    }
    </style>
</head>

<body>
    <div class="container">
        <h2>Email Verification</h2>
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

                echo "<p class='success'>Email successfully verified! You can now log in.</p>";
                echo "<a href='login.php' class='btn'>Go to Login</a>";
            } else {
                echo "<p class='error'>Invalid or already verified email!</p>";
            }
            $stmt->close();
        }

        $conn->close();
        ?>
    </div>
</body>

</html>