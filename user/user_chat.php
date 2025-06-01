<?php
include('../Connection/PDOcon.php'); // Make sure $host, $dbname, $db_user, $db_pass are defined here

session_start();


$user_id = $_SESSION['user_id'] ?? null;
$user_name = "";
// Check if user_name is available in session
if (isset($_SESSION['user_name'])) {
    $user_name = $_SESSION['user_name'];
    echo "Welcome, " . htmlspecialchars($user_name) . "!";
} else {
    echo "User name not found in session.";
}


try {
    // Use your actual DB credentials, not session values
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch user info using prepared statement
    $query = $pdo->prepare("SELECT * FROM users WHERE id = :id");
    $query->execute(['id' => $user_id]);
    $user = $query->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }

    // Now you can use $user safely
    // Example: echo $user['name'];

} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quatro Pasos Website</title>
    <!-- Favicon icon -->
    <link rel="icon" href="../images/icon.png" type="image/gif" sizes="16x16">
    <!-- Custom Stylesheet -->
    <link href="./style.css" rel="stylesheet">

    <style>
    .chat-container {
        width: 100%;
        height: 600px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
        display: flex;
        flex-direction: column;
        overflow: hidden;
    }

    #chat-box {
        flex: 1;
        padding: 10px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 8px;
        background: #f9f9f9;
    }

    .message {
        padding: 12px;
        border-radius: 20px;
        font-size: 14px;
        max-width: 75%;
        word-wrap: break-word;
    }

    .incoming {
        background-color: #e1f5fe;
        align-self: flex-start;
    }

    .outgoing {
        background-color: #c8e6c9;
        align-self: flex-end;
    }

    .input-container {
        display: flex;
        padding: 10px;
        gap: 10px;
        border-top: 1px solid #ccc;
    }

    textarea {
        flex: 1;
        resize: none;
        padding: 10px;
        border-radius: 8px;
        font-size: 14px;
        border: 1px solid #ccc;
    }

    button#send {
        background: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        cursor: pointer;
    }
    </style>

    <script type="module">
    const customerId = "<?php echo $user_name; ?>"; // Use PHP to pass username
    localStorage.setItem("customerId", customerId); // Store for JS use
    </script>
</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo"><a href="../index.php"><b><img src="../admin/assets/images/logo.png" alt="">
                    </b><span class="brand-title"><img src="../admin/assets/images/logo-text.png" alt=""></span></a>
            </div>
            <div class="nav-control">
                <div class="hamburger"><span class="line"></span> <span class="line"></span> <span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************--
            Sidebar start
        ***********************************-->
        <?php include('profile_sidebar.php'); ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->

        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>💬 Chat</h3>
                            </div>
                            <div class="card-body text-center">
                                <div class="chat-container">
                                    <div id="chat-box"></div>
                                    <div class="input-container">
                                        <textarea id="message" placeholder="Type your message..."></textarea>
                                        <button id="send">Send</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module" src="../js/chat.js"></script>
    <script src="../admin/assets/plugins/common/common.min.js"></script>
    <script src="../admin/main/js/custom.min.js"></script>
    <script src="../admin/main/js/settings.js"></script>
    <script src="../admin/main/js/gleek.js"></script>
    <script src="../admin/main/js/styleSwitcher.js"></script>
    <script src="../admin/assets/plugins/moment/moment.min.js"></script>
</body>

</html>