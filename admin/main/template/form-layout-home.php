<?php
session_start(); // Start the session
include('../../../Connection/PDOcon.php');

// Check if the user is logged in and their role is equal to 1
$isLoggedIn = isset($_SESSION['user_id']);
if ($isLoggedIn) {
    $stmt2 = $pdo->prepare("SELECT * FROM `users` WHERE id = ?");
    $stmt2->execute([$_SESSION['user_id']]);
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($row2) {
        $roleCheck = $row2["role_as"];

        if ($roleCheck == 1) {
        } else {
            header("Location: ../../../AuthAndStatusPages/401.php");
            exit(); // Prevent further execution
        }
    } else {
        // Handle the case where no user was found
        header("Location: ../../../AuthAndStatusPages/401.php");
        exit();
    }
} else {
    // User is not logged in
    header("Location: ../../../AuthAndStatusPages/401.php");
    exit();
}

include '../config.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$id = 1;

// Query the database to get the current data for the selected ID
$query = mysqli_query($conn, "SELECT * FROM homepage WHERE ID = $id");
$row = mysqli_fetch_assoc($query);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form inputs
    $subTitle = !empty($_POST['subTitle']) ? $_POST['subTitle'] : $row['subTitle'];
    $MainTitle = !empty($_POST['MainTitle']) ? $_POST['MainTitle'] : $row['MainTitle'];
    $FooterTxt = !empty($_POST['FooterTxt']) ? $_POST['FooterTxt'] : $row['FooterTxt'];
    $LocationAddress = !empty($_POST['LocationAddress']) ? $_POST['LocationAddress'] : $row['LocationAddress'];
    $ContactNumber = !empty($_POST['ContactNumber']) ? $_POST['ContactNumber'] : $row['ContactNumber'];

    // Prepare the SQL Update Statement
    $sql = "UPDATE homepage SET subTitle = ?, MainTitle = ?, FooterTxt = ?, LocationAddress = ?, ContactNumber = ? WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssi", $subTitle, $MainTitle, $FooterTxt, $LocationAddress, $ContactNumber, $id);

    // Execute the Statement
    if (isset($stmt) && mysqli_stmt_execute($stmt)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?id=" . $id);
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Close the prepared statement
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
}

// Close the database connection
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quatro Pasos Website</title>
    <!-- Favicon icon -->
    <link rel="icon" href="../../../images/icon.png" type="image/gif" sizes="16x16">
    <!-- Custom Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

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
            <div class="brand-logo"><a href="index-ticket.php"><b><img src="../../assets/images/logo.png" alt="">
                    </b><span class="brand-title"><img src="../../assets/images/logo-text.png" alt=""></span></a>
            </div>
            <div class="nav-control">
                <div class="hamburger"><span class="line"></span> <span class="line"></span> <span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <div class="header-right">
                    <ul>
                        <li class="icons">
                            <a href="javascript:void(0)" class="log-user">
                                <span><?= $row2["firstname"] ?></span> <i class="fa fa-caret-down f-s-14"
                                    aria-hidden="true"></i>
                            </a>
                            <div class="drop-down dropdown-profile animated bounceInDown">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="javascript:void()"><i class="icon-user"></i> <span>My
                                                    Profile</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-wallet"></i> <span>My
                                                    Wallet</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-envelope"></i>
                                                <span>Inbox</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="fa fa-cog"></i>
                                                <span>Setting</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-lock"></i> <span>Lock
                                                    Screen</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-power"></i>
                                                <span>Logout</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php
        include('sidebar.php');
        ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card forms-card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">Home Page</h4>
                                <div class="basic-form">
                                    <form name="contactForm" id="contact_form" method="post">
                                        <div class="form-group">
                                            <label class="text-label">Sub Title</label>
                                            <input type="text" name="subTitle" id="subTitle" class="form-control"
                                                placeholder="<?php echo htmlspecialchars($row['subTitle']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Facebook Page</label>
                                            <input type="text" name="" class="form-control"
                                                placeholder="<?php echo htmlspecialchars($row['FBname']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Address</label>
                                            <input type="text" name="LocationAddress" id="LocationAddress"
                                                class="form-control"
                                                placeholder="<?php echo htmlspecialchars($row['LocationAddress']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Contact No.</label>
                                            <input type="number" name="ContactNumber" id="ContactNumber"
                                                class="form-control"
                                                placeholder="<?php echo htmlspecialchars($row['ContactNumber']); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="text-label">Email</label>
                                            <input type="email" name="" class="form-control"
                                                placeholder="<?php echo htmlspecialchars($row['Email']); ?>">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-form mr-2">Submit</button>
                                        <button type="button" class="btn btn-light text-dark btn-form">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>





                </div>

            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="../../assets/plugins/common/common.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/gleek.js"></script>
    <script src="../js/styleSwitcher.js"></script>
</body>

</html>