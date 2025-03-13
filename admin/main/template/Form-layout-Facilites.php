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
            // User has the correct role
            // Continue with the logic for users with role 1
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
$roomdb = mysqli_query($conn, "SELECT * FROM facilitiespage");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Gleek - Ultimate Bootstrap 4 Sidebar</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/images/favicon.png">
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
            <div class="brand-logo"><a href="index.html"><b><img src="../../assets/images/logo.png" alt=""> </b><span
                        class="brand-title"><img src="../../assets/images/logo-text.png" alt=""></span></a>
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
                <div class="row page-titles">
                    <div class="col p-0">
                        <h4>Hello, <span>Welcome here</span></h4>
                    </div>
                    <div class="col p-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Layout</a>
                            </li>
                            <li class="breadcrumb-item active">Boxed</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <?php while ($row = mysqli_fetch_assoc($roomdb)) { ?>
                        <div class="col-lg-4" style="cursor: pointer">
                            <div class="card">
                                <a href="Form-layout-Facilities-Edit.php?roomid=<?php echo $row['ID']; ?>">
                                    <div class="card-body">
                                        <h4 class="card-title"><?php echo $row['Event']; ?></h4>
                                        <div class="card-content">
                                            <p>This is card content paragraph text.</p>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>
                    <?php } ?>

                    <!-- <div class="col-lg-4" style="cursor: pointer">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Wellness Event</h4>
                                <div class="card-content">
                                    <p>This is card content paragraph text.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4" style="cursor: pointer">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Birthdays</h4>
                                <div class="card-content">
                                    <p>This is card content paragraph text.</p>
                                </div>
                            </div>
                        </div>
                    </div> -->

                </div>

            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <!-- <p>Copyright &copy; Developed by Allen</a> 2018</p> -->
            </div>
        </div>
        <!--**********************************
            Footer end
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