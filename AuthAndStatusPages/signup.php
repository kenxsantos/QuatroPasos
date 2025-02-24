<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

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
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ?");
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

        $stmt = $conn->prepare("INSERT INTO user (name, email, phone, pass, role_as, created_at, address) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssiss", $name, $email, $phone, $hashed_password, $role_as, $created_at, $address);

        if ($stmt->execute()) {
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
    <meta name="description"
        content="Erratum – Multi purpose error page template for Service, corporate, agency, Consulting, startup.">
    <meta name="keywords" content="Error page 404, page not found design, wrong url, coming soon, login">
    <meta name="author" content="Ashishmaraviya">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon" />
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon" />
    <title>404 - Error page pack all in one</title>
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
                                <?php if (!empty($errors)) : ?>
                                <div class="error-container">
                                    <ul>
                                        <?php foreach ($errors as $error) : ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php endif; ?>
                                <div class="input-control">
                                    <div class="row p-l-5 p-r-5">
                                        <div class="col-md-6 p-l-10 p-r-10">
                                            <input type="text" placeholder="Enter Name" name="name" required>
                                            <!-- Name field -->
                                        </div>
                                        <div class="col-md-6 p-l-10 p-r-10">
                                            <input type="email" placeholder="Enter Email" name="email" required>
                                        </div>
                                        <div class="col-md-12 p-l-10 p-r-10">
                                            <input type="text" placeholder="Enter Phone" name="phone" required>
                                            <!-- Phone field -->
                                        </div>
                                        <div class="col-md-6 p-l-10 p-r-10">
                                            <input class="password-field input-checkmark" type="password"
                                                placeholder="Enter Password" name="password" required>
                                            <!-- Password field -->
                                        </div>
                                        <div class="col-md-6 p-l-10 p-r-10">
                                            <input class="password-field input-checkmark" type="password"
                                                placeholder="Re-enter Password" name="confirm_password" required>
                                            <!-- Confirm password -->
                                        </div>
                                        <div class="col-md-12 p-l-10 p-r-10">
                                            <input type="text" placeholder="Enter Address" name="address" required>
                                            <!-- Address field -->
                                        </div>
                                    </div>
                                    <label class="label-container">I agree with <a href="#"> privacy policy</a>
                                        <input type="checkbox" id="privacy-policy" required>
                                        <!-- Make the checkbox required -->
                                        <span class="checkmark"></span>
                                    </label>
                                    <div class="login-btns">
                                        <button type="submit" id="register-btn" disabled>Sign up</button>
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