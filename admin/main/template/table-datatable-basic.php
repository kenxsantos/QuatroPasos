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
            exit();
        }
    } else {

        header("Location: ../../../AuthAndStatusPages/401.php");
        exit();
    }
} else {

    header("Location: ../../../AuthAndStatusPages/401.php");
    exit();
}


$stmtBookings = $pdo->query("SELECT * FROM `bookings`");


$stmtRooms = $pdo->query("SELECT * FROM `room`");

$sqlRoomTypes = "SELECT type FROM room";
$stmtRoomTypes = $pdo->query($sqlRoomTypes);
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
    <link href="../../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
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
                <div class="header-left">

                </div>
                <div class="header-right">
                    <ul>
                        <li class="icons">
                            <a href="javascript:void(0)">
                                <i class="mdi mdi-comment"></i>
                                <div class="pulse-css"></div>
                            </a>
                            <div class="drop-down animated bounceInDown">
                                <div class="dropdown-content-heading">
                                    <span class="pull-left">Messages</span>
                                    <a href="javascript:void()" class="pull-right text-white">View All</a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="pull-left mr-3 avatar-img"
                                                    src="../../assets/images/avatar/1.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Druid Wensleydale</div>
                                                    <div class="notification-text">A wonderful serenit has take
                                                        possession</div><small class="notification-timestamp">08 Hours
                                                        ago</small>
                                                </div>
                                            </a><span class="notify-close"><i class="ti-close"></i></span>
                                        </li>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="pull-left mr-3 avatar-img"
                                                    src="../../assets/images/avatar/2.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Fig Nelson</div>
                                                    <div class="notification-text">A wonderful serenit has take
                                                        possession</div><small class="notification-timestamp">08 Hours
                                                        ago</small>
                                                </div>
                                            </a><span class="notify-close"><i class="ti-close"></i></span>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="pull-left mr-3 avatar-img"
                                                    src="../../assets/images/avatar/3.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Bailey Wonger</div>
                                                    <div class="notification-text">A wonderful serenit has take
                                                        possession</div><small class="notification-timestamp">08 Hours
                                                        ago</small>
                                                </div>
                                            </a><span class="notify-close"><i class="ti-close"></i></span>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="pull-left mr-3 avatar-img"
                                                    src="../../assets/images/avatar/4.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Bodrum Salvador</div>
                                                    <div class="notification-text">A wonderful serenit has take
                                                        possession</div><small class="notification-timestamp">08 Hours
                                                        ago</small>
                                                </div>
                                            </a><span class="notify-close"><i class="ti-close"></i></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="icons">
                            <a href="javascript:void(0)">
                                <i class="mdi mdi-bell"></i>
                                <div class="pulse-css"></div>
                            </a>
                            <div class="drop-down animated bounceInDown dropdown-notfication">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i
                                                        class="fa fa-check"></i></span>
                                                <div class="notification-content">
                                                    <div class="notification-heading">Druid Wensleydale</div>
                                                    <span class="notification-text">A wonderful serenit of my entire
                                                        soul.</span>
                                                    <small class="notification-timestamp">20 May 2018, 15:32</small>
                                                </div>
                                            </a>
                                            <span class="notify-close"><i class="ti-close"></i>
                                            </span>
                                        </li>
                                        <li><a href="javascript:void()"><span
                                                    class="mr-3 avatar-icon bg-danger-lighten-2"><i
                                                        class="fa fa-close"></i></span>
                                                <div class="notification-content">
                                                    <div class="notification-heading">Inverness McKenzie</div><span
                                                        class="notification-text">A wonderful serenit of my entire
                                                        soul.</span> <small class="notification-timestamp">20 May 2018,
                                                        15:32</small>
                                                </div>
                                            </a>
                                            <span class="notify-close"><i class="ti-close"></i>
                                            </span>
                                        </li>
                                        <li><a href="javascript:void()"><span
                                                    class="mr-3 avatar-icon bg-success-lighten-2"><i
                                                        class="fa fa-check"></i></span>
                                                <div class="notification-content">
                                                    <div class="notification-heading">McKenzie Inverness</div><span
                                                        class="notification-text">A wonderful serenit of my entire
                                                        soul.</span> <small class="notification-timestamp">20 May 2018,
                                                        15:32</small>
                                                </div>
                                            </a>
                                            <span class="notify-close"><i class="ti-close"></i>
                                            </span>
                                        </li>
                                        <li><a href="javascript:void()"><span
                                                    class="mr-3 avatar-icon bg-danger-lighten-2"><i
                                                        class="fa fa-close"></i></span>
                                                <div class="notification-content">
                                                    <div class="notification-heading">Inverness McKenzie</div><span
                                                        class="notification-text">A wonderful serenit of my entire
                                                        soul.</span> <small class="notification-timestamp">20 May 2018,
                                                        15:32</small>
                                                </div>
                                            </a>
                                            <span class="notify-close"><i class="ti-close"></i>
                                            </span>
                                        </li>
                                        <li class="text-left"><a href="javascript:void()" class="more-link">Show All
                                                Notifications</a> <span class="pull-right"><i
                                                    class="fa fa-angle-right"></i></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
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
        <?php include('sidebar.php'); ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col p-md-0">
                        <h4>Hello, <span>Welcome here</span></h4>
                    </div>
                    <div class="col p-md-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a>
                            </li>
                            <li class="breadcrumb-item active">Datatable</li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <!-- Rooms Available -->
                <div class="card sale-widget">
                    <div class="card-body">


                        <h4 class="d-inline-block text-uppercase card-title mb-5">Rooms Available</h4>

                        <?php
                        // Check if room types exist
                        if ($stmtRoomTypes->rowCount() > 0) {
                            // Loop through each room type
                            while ($roomRow = $stmtRoomTypes->fetch(PDO::FETCH_ASSOC)) {
                                $room_type = $roomRow['type'];
                                $status = 'Confirmed';

                                // Prepare and execute a query to count bookings within the specified date range
                                $sqlCount = "SELECT COUNT(*) AS count FROM bookings 
                                            WHERE room_type = :room_type AND status = :status";
                                $stmtCount = $pdo->prepare($sqlCount);
                                $stmtCount->bindParam(':room_type', $room_type);
                                $stmtCount->bindParam(':status', $status);
                                $stmtCount->execute();

                                // Fetch the result
                                $countRow = $stmtCount->fetch(PDO::FETCH_ASSOC);
                                //Gettng the table name `room` data
                                $row2 = $stmtRooms->fetch(PDO::FETCH_ASSOC);

                                //converting into a percentage
                                if ($row2["AvRooms"] > 0) {
                                    $percentage = $row2["AvRooms"] * 10;
                                } else {
                                    echo "Total cannot be zero.";
                                }

                        ?>

                        <h5 class="text-muted"><?php echo htmlspecialchars($row2["type"]); ?>
                            <span class="pull-right"><?php echo $row2["AvRooms"] ?></span>
                        </h5>
                        <div class="progress">
                            <div class="progress-bar bg-lgreen wow animated progress-animated"
                                data-progress="<?php echo round($percentage, 2) ?>" style="height:8px;"
                                role="progressbar">
                            </div>
                        </div><br>

                        <?php
                            }
                        } else {
                            echo "No RoomTypes found in table2.";
                        }
                        ?>


                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h1>Room Booking</h1>
                                </div>
                                <div class="table-responsive">
                                    <table id="" class="table" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Reservation ID</th>
                                                <th>Guest Name</th>
                                                <th>Room Type</th>
                                                <th>Check-in</th>
                                                <th>Check-out</th>
                                                <th>Number of Guests</th>
                                                <th>Total Booking Amount</th>
                                                <th>Booking Status</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php while ($row = $stmtBookings->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row["id"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["name"]); ?></td>
                                                <td>
                                                    <span
                                                        class="text-muted"><?php echo htmlspecialchars($row["room_type"]); ?></span>
                                                </td>
                                                <td>
                                                    <span
                                                        class="text-muted"><?php echo htmlspecialchars($row["start_date"]); ?></span>
                                                </td>
                                                <td><?php echo htmlspecialchars($row["end_date"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["num_adults"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["Price"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["status"]); ?></td>
                                                <td><a
                                                        href="table-datatable-basic-view.php?Paymentid=<?php echo urlencode($row["id"]); ?>">View</a>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>

                                    </table>
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
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Select all progress bars
        const progressBars = document.querySelectorAll('.progress-bar');

        // Update each progress bar width based on the data-progress attribute
        progressBars.forEach(bar => {
            const progress = bar.getAttribute('data-progress');
            bar.style.width = `${progress}%`;
        });
    });
    </script>


    <script src="../../assets/plugins/common/common.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/gleek.js"></script>
    <script src="../js/styleSwitcher.js"></script>

    <script src="../../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../js/plugins-init/datatables.init.js"></script>
</body>

</html>