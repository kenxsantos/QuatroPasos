<?php
include 'db.php';
session_start(); // Start the session to use session variables

// Initialize error message
$error_message = "";
$successMessage = "";

if (isset($_SESSION['success_message'])) {
    $successMessage = $_SESSION['success_message'];
    unset($_SESSION['success_message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Use a prepared statement to prevent SQL injection
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['pass'])) { // Check if the password matches
            // Set session variables
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['firstname'] . " " . $row['lastname'];
            $_SESSION['role_as'] = $row['role_as'];

            // Redirect based on role
            if ($row['role_as'] == 1) {
                header("Location: ../admin.php"); // Redirect to admin page
            } else {
                header("Location: ../default.php"); // Redirect to default page
            }
            exit();
        } else {
            $error_message = "Invalid password.";
        }
    } else {
        $error_message = "No user found with this email.";
    }

    $stmt->close(); // Close the statement
}

$conn->close(); // Close the database connection
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
    <link rel="icon" href="assets/images/icon.png" type="image/x-icon" />
    <title>Quatro Pasos | Login Page</title>
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
    /* Modal Background */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        display: flex;
        justify-content: center;
        align-items: center;
        animation: fadeIn 0.3s ease-in-out;
    }

    /* Modal Content */
    .modal-content {
        background: #fff;
        width: 500px;
        padding: 30px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        transform: translateY(-20px);
        animation: slideIn 0.3s ease-in-out forwards;
    }

    .modal-content p {
        font-size: 16px;
        color: black;
        margin: 15px 0;
        font-weight: 700;
    }

    /* Header */
    .modal-header h2 {
        margin: 0;
        font-size: 20px;
        color: #333;
    }

    /* Body */
    .modal-body p {
        font-size: 16px;
        color: #555;
        margin: 15px 0;
    }

    /* Footer */
    .modal-footer {
        margin-top: 20px;
    }

    /* Button */
    .close-btn {
        background-color: #28a745;
        color: white;
        padding: 12px 20px;
        border: none;
        cursor: pointer;
        border-radius: 6px;
        font-size: 14px;
        transition: 0.2s;
    }

    .close-btn:hover {
        background-color: #218838;
    }

    /* Animations */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
        }

        to {
            transform: translateY(0);
        }
    }
    </style>
</head>

<body>
    <?php if (!empty($successMessage)): ?>
    <div id="successModal" class="modal">
        <div class="modal-content">
            <p><?php echo $successMessage; ?></p>
            <button class="close-btn" onclick="closeModal()">OK</button>
        </div>
    </div>
    <?php endif; ?>
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
                                        <input type="password" placeholder="Enter Password" name="password"
                                            class="password-field" value="" required>
                                        <span data-toggle=".password-field"
                                            class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                    </span>
                                    <div class="login-btns">
                                        <button type="submit">Login</button>
                                    </div>
                                    <!-- Display error message here -->
                                    <?php if (!empty($error_message)): ?>
                                    <div class="alert alert-danger mt-2"
                                        style="text-align: center; font-size: 12px; margin: 0 auto;">
                                        <?php echo $error_message; ?>
                                    </div>
                                    <?php endif; ?>

                                    <div class="login-with-btns">
                                        <br>
                                        <span class="already-acc">Not a member? <a href="signup.php"
                                                class="signup-btn">Sign up</a></span>
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        let modal = document.getElementById("successModal");

        if (modal) {
            modal.style.display = "flex"; // Show modal

            // Auto-close after 5 seconds
            setTimeout(() => {
                modal.style.display = "none";
                window.location.href = "login.php"; // Redirect after modal closes
            }, 5000);
        }
    });

    function closeModal() {
        let modal = document.getElementById("successModal");
        if (modal) {
            modal.style.display = "none";
            window.location.href = "login.php"; // Redirect after manual close
        }
    }
    </script>
</body>

</html>