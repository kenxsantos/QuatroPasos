<?php
include('Connection/PDOcon.php');

session_start();


try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Fetch user data (assuming user ID is stored in session)
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("User not logged in.");
}

$query = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$query->execute(['id' => $user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // Edit Name
    if (isset($_POST['first_name'])) {
        $first_name = trim($_POST['first_name']);
        if (!empty($first_name)) {
            $stmt = $pdo->prepare("UPDATE users  SET firstname = :firstname WHERE id = :id");
            $stmt->execute(['firstname' => $first_name, 'id' => $user_id]);
        } else {
            $errors[] = "First Name cannot be empty.";
        }
    }

    if (isset($_POST['last_name'])) {
        $last_name = trim($_POST['last_name']);
        if (!empty($last_name)) {
            $stmt = $pdo->prepare("UPDATE users  SET lastname = :lastname WHERE id = :id");
            $stmt->execute(['lastname' => $last_name, 'id' => $user_id]);
        } else {
            $errors[] = "Last Name cannot be empty.";
        }
    }

    // Edit Password
    if (isset($_POST['password'])) {
        $password = trim($_POST['password']);
        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("UPDATE users SET pass = :password WHERE id = :id");
            $stmt->execute(['password' => $hashed_password, 'id' => $user_id]);
        } else {
            $errors[] = "Password cannot be empty.";
        }
    }

    // Edit Email
    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
            $stmt->execute(['email' => $email, 'id' => $user_id]);
        } else {
            $errors[] = "Invalid email address.";
        }
    }

    // Edit Phone
    if (isset($_POST['phone'])) {
        $phone = trim($_POST['phone']);
        if (preg_match('/^[0-9]{10,15}$/', $phone)) {
            $stmt = $pdo->prepare("UPDATE users SET phone = :phone WHERE id = :id");
            $stmt->execute(['phone' => $phone, 'id' => $user_id]);
        } else {
            $errors[] = "Invalid phone number.";
        }
    }

    // Edit Address
    if (isset($_POST['address'])) {
        $address = trim($_POST['address']);
        if (!empty($address)) {
            $stmt = $pdo->prepare("UPDATE users SET address = :address WHERE id = :id");
            $stmt->execute(['address' => $address, 'id' => $user_id]);
        } else {
            $errors[] = "Address cannot be empty.";
        }
    }

    // Reload the updated data
    header("Location: profile.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <style>
    body {
        color: #333;
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .container {
        width: 50%;
        background: #ffffff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .avatar img {
        width: 120px;
        border-radius: 50%;
        margin-bottom: 15px;
    }

    .user-info h3 {
        color: #007bff;
        margin-bottom: 5px;
    }

    .user-info p {
        color: #6c757d;
        font-size: 14px;
    }

    .button-container {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 20px;
    }

    button,
    .styled-button {
        padding: 12px 18px;
        font-size: 16px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: 0.3s;
        font-weight: bold;
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .btn-secondary {
        background-color: #28a745;
        color: white;
    }

    .btn-secondary:hover {
        background-color: #218838;
    }

    .styled-button a {
        text-decoration: none;
        color: white;
        display: block;
    }

    form {
        margin-top: 20px;
        text-align: left;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .btn-cancel {
        background-color: #dc3545;
        color: white;
    }

    .btn-cancel:hover {
        background-color: #c82333;
    }

    @media (max-width: 768px) {
        .container {
            width: 90%;
        }
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="avatar">
            <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="User Avatar">
        </div>
        <div class="user-info">
            <h3><?php echo htmlspecialchars($user['firstname'] . " " . $user['lastname']); ?></h3>
            <p><?php echo htmlspecialchars($user['address']); ?></p>
            <p><?php echo htmlspecialchars($user['email']); ?></p>
            <p><?php echo htmlspecialchars($user['phone']); ?></p>
        </div>

        <div class="button-container">
            <button class="btn-primary" id="editProfileBtn">Edit Profile</button>
            <button class="btn-primary" id="resetPasswordBtn">Reset Password</button>
            <button class="btn-secondary styled-button">
                <a href="bookings.php">Bookings</a>
            </button>
            <button class="btn-secondary styled-button">
                <a href="chat.php">Chat with Admin</a>
            </button>
            <?php if (isset($_SESSION['user_name'])): ?>
            <button class="btn-cancel styled-button">
                <a href="logout.php">Logout</a>
            </button>
            <?php endif; ?>
        </div>

        <form method="POST" id="editProfileForm" style="display: none;">
            <h3>Edit Profile</h3>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="first_name" class="form-control"
                    value="<?php echo htmlspecialchars($user['firstname']); ?>" required>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="last_name" class="form-control"
                    value="<?php echo htmlspecialchars($user['lastname']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control"
                    value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control"
                    value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control"
                    value="<?php echo htmlspecialchars($user['address']); ?>" required>
            </div>
            <div class="form-group">
                <button type="submit" class="btn-primary">Save Changes</button>
                <button type="button" class="btn-cancel" id="cancelEditProfile">Cancel</button>
            </div>
        </form>
        <form method="POST" id="resetPasswordForm" style="display: none;">
            <hr class="my-4" />
            <div class="form-group">
                <label for="newPassword">New Password</label>
                <input type="password" class="form-control" id="newPassword" name="password" required />
            </div>
            <div class="form-group">
                <button type="submit" class="btn-primary">Update Password</button>
                <button type="button" id="cancelResetPassword" class="btn-cancel">Cancel</button>
            </div>
        </form>
    </div>

    <script>
    document.getElementById('editProfileBtn').addEventListener('click', function() {
        document.getElementById('editProfileForm').style.display = 'block';
        document.querySelector('.button-container').style.display = 'none';
    });

    document.getElementById('cancelEditProfile').addEventListener('click', function() {
        document.getElementById('editProfileForm').style.display = 'none';
        document.querySelector('.button-container').style.display = 'flex';
    });

    document.getElementById("resetPasswordBtn").addEventListener("click", function() {
        document.getElementById("resetPasswordForm").style.display = "block";
        document.querySelector('.button-container').style.display = 'none';
    });

    document.getElementById("cancelResetPassword").addEventListener("click", function() {
        document.getElementById("resetPasswordForm").style.display = "none";
        document.querySelector('.button-container').style.display = 'flex';
    });
    </script>
</body>

</html>