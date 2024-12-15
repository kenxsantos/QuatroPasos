<?php
include 'db.php';
session_start(); // Start the session to use session variables

// Initialize error message
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? ''; // Get the email, default to empty string if not set
    $password = $_POST['password'] ?? ''; // Get the password, default to empty string if not set

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT * FROM user WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['pass'])) { // Check if the password matches
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['role_as'] = $row['role_as'];
            header("Location: ../index.php"); // Redirect to the homepage
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with this email.";
    }
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
                            <form class="login-form" method="post" action="login.php">
                                <div class="imgcontainer">
                                    <img src="assets/images/logo.png" alt="Avatar" class="avatar" width="70%">
                                </div>
                                <div class="input-control">
                                    <input type="email" placeholder="Enter Email" name="email" required>
                                    <span class="password-field-show">
                                        <input type="password" placeholder="Enter Password" name="password" class="password-field" value="" required>
                                        <span data-toggle=".password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </span>
                                    <div class="login-btns">
                                        <button type="submit">Login</button>
                                    </div>
                                    <!-- Display error message here -->
                                    <?php if (!empty($error_message)): ?>
                                        <div class="alert alert-danger mt-2" style="text-align: center; font-size: 12px; margin: 0 auto;">
                                            <?php echo $error_message; ?>
                                        </div>
                                    <?php endif; ?>

                                    <div class="login-with-btns">
                                        <br>
                                        <span class="already-acc">Not a member? <a href="signup.php" class="signup-btn">Sign up</a></span>
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