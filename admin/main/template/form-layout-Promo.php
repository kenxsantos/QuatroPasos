<?php
session_start();
include('../authorize.php');
include '../config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['toggle'])) {
    $query = "UPDATE `homepage` SET `showPromo` = NOT `showPromo` WHERE `ID` = 1";
    mysqli_query($conn, $query);
}

$result = mysqli_query($conn, "SELECT `showPromo` FROM `homepage` WHERE `ID` = 1");
$row = mysqli_fetch_assoc($result);

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
    <link rel="icon" type="image/png" sizes="16x16" href="">
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
                                <h4 class="card-title mb-4">Promo Popup Control</h4>
                                <div class="basic-form">
                                    <form name="contactForm" id="contact_form" method="post">
                                        <p>Current status: <?php echo $row['showPromo'] ? 'On' : 'Off'; ?></p>
                                        <button type="submit" class="btn btn-primary btn-form mr-2"
                                            name="toggle">Submit</button>
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