<?php
include 'db.php';

require '../Connection/Script.php';

session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $verification_code = md5(uniqid($email, true));

    $errors = [];

    // Strong password validation
    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/', $password)) {
        $errors[] = "Password must be at least 8 characters long, include an uppercase letter, a lowercase letter, a number, and a special character.";
    }

    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $errors[] = "Email already exists.";
    }
    $stmt->close();

    // If no errors, proceed with registration
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $role_as = 0;
        $created_at = date('Y-m-d H:i:s');

        $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, phone, pass, role_as, created_at, address,  verification_code, is_verified) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
        $stmt->bind_param("sssssisss", $first_name, $last_name, $email, $phone, $hashed_password, $role_as, $created_at, $address, $verification_code);


        sendMail($email, "Verify Your Email - Quatro Pasos", "
            <p>Dear User,</p>
            <p>Thank you for signing up with <strong>Quatro Pasos</strong>! To complete your registration and activate your account, please verify your email address by clicking the link below:</p>
            <p style='text-align: left;'>
                <a href='http://localhost/quatropasos.online/public_html/AuthAndStatusPages/verify.php?code=$verification_code' 
                style='display: inline-block; padding: 10px 20px; font-size: 16px; font-weight: bold; color: #ffffff; background-color: #007bff; text-decoration: none; border-radius: 5px;'>
                Verify My Email
                </a>
            </p>
            <p>If the button above does not work, you can also copy and paste the following link into your browser:</p>
            <p><a href='http://localhost/quatropasos.online/public_html/AuthAndStatusPages/verify.php?code=$verification_code'>
                http://localhost/quatropasos.online/public_html/AuthAndStatusPages/verify.php?code=$verification_code
            </a></p>
            <p>If you did not sign up for an account, please ignore this email.</p>
            <p>Best regards,</p>
            <p><strong>Quatro Pasos Team</strong></p>
        ");

        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Registration successful!";
            header("Location: login.php");
            exit();
        } else {
            $errors[] = "Error: " . $stmt->error;
        }
        $stmt->close();
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Ashishmaraviya">
    <link rel="icon" href="assets/images/icon.png" type="image/x-icon" />
    <title>Quatro Pasos | Sign Up Page</title>
    <!--Google font-->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300&display=swap"
        rel="stylesheet">
    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/css/fontawesome.css">
    <!-- Theme css -->
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
    <style>
    .error-container {
        background-color: red;
        color: white;
        padding: 10px 0px;
        margin: 8px 0;
        font-size: 12px;
    }
    </style>
</head>

<body>
    <!-- 01 Preloader -->
    <div class="loader-wrapper" id="loader-wrapper">
        <div class="loader"></div>
    </div>
    <!-- Preloader end -->
    <!-- 02 Main page -->
    <section class="page-section login-page">
        <div class="full-width-screen">
            <div class="container-fluid">
                <div class="content-detail">
                    <div class="main-info">
                        <div class="hero-container">
                            <!-- Signup form -->
                            <form class="signup-form" method="post" action="signup.php">
                                <!-- Ensure action points to signup.php -->
                                <div class="imgcontainer">
                                    <img src="assets/images/logo.png" alt="logo" class="avatar" width="70%">
                                </div>
                                <!-- Show errors if any -->
                                <?php if (!empty($errors)): ?>
                                <div class="error-container">
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                                <div class="input-control">
                                    <div class="row p-l-5 p-r-5">
                                        <div class="col-md-6 p-l-10 p-r-10">
                                            <input type="text" placeholder="First Name" name="first_name" required>
                                            <!-- Name field -->
                                        </div>
                                        <div class="col-md-6 p-l-10 p-r-10">
                                            <input type="text" placeholder="Last Name" name="last_name" required>
                                            <!-- Name field -->
                                        </div>
                                        <div class="col-md-12 p-l-10 p-r-10">
                                            <input type="email" placeholder="Email" name="email" required>
                                        </div>
                                        <div class="col-md-12 p-l-10 p-r-10">
                                            <input type="text" placeholder="Phone" name="phone" required>
                                            <!-- Phone field -->
                                        </div>
                                        <div class="col-md-6 p-l-10 p-r-10">
                                            <input class="password-field input-checkmark" type="password"
                                                placeholder="Password" name="password" required>
                                            <!-- Password field -->
                                        </div>
                                        <div class="col-md-6 p-l-10 p-r-10">
                                            <input class="password-field input-checkmark" type="password"
                                                placeholder="Re-enter Password" name="confirm_password" required>
                                            <!-- Confirm password -->
                                        </div>
                                        <div class="col-md-12 p-l-10 p-r-10">
                                            <input type="text" placeholder="Address" name="address" required>
                                            <!-- Address field -->
                                        </div>
                                    </div>
                                    <label class="label-container">I agree with <a href="#"> privacy policy</a>
                                        <input type="checkbox" id="privacy-policy" required>
                                        <!-- Make the checkbox required -->
                                        <span class="checkmark"></span>
                                    </label>
                                    <div class="login-btns">
                                        <button type="submit" id="register-btn">Sign up</button>
                                    </div>
                                    <div class="division-lines"></div>
                                    <div class="login-with-btns">
                                        <br>
                                        <span class="already-acc">Already have an account? <a href="login.php"
                                                class="login-btn">Login</a></span>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- latest jquery-->
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <!-- Theme js-->
    <script src="assets/js/script.js"></script>
</body>

</html>