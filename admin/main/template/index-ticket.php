<?php
session_start();
include('../../../Connection/PDOcon.php');
include '../config.php';

// Get total number of room types
$result = mysqli_query($conn, "SELECT SUM(AvRooms) AS totalAvailable, COUNT(*) AS totalTypes FROM room");

$totalAvailable = 0;
$totalTypes = 0;
$totalRooms = 0;
$totalBooked = 0;
$availablePercentage = 0;
$bookedPercentage = 0;

if ($result && mysqli_num_rows($result) > 0) {
    $data = mysqli_fetch_assoc($result);
    $totalAvailable = (int)$data['totalAvailable'];
    $totalTypes = (int)$data['totalTypes'];
    $totalRooms = $totalTypes * 10;
    $totalBooked = $totalRooms - $totalAvailable;

    $availablePercentage = round(($totalAvailable / $totalRooms) * 100);
    $bookedPercentage = 100 - $availablePercentage;
}



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
        <?php include('sidebar.php'); ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">


                <div class="row">
                    <!-- Available Rooms -->
                    <div class="col-md-6 col-sm-12">
                        <div class="card widget-circle-progress">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-lg-5 col-7">
                                        <div class="circle text-center">
                                            <div id="ticket-circle-progress-1"></div>
                                            <span
                                                class="abs-text text-dpink"><?php echo $availablePercentage; ?>%</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-5 pl-2">
                                        <div>
                                            <h2 class="text-dpink"><span><?php echo $totalAvailable; ?></span></h2>
                                            <p class="text-pale-sky">Rooms available</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Booked Rooms -->
                    <div class="col-md-6 col-sm-12">
                        <div class="card widget-circle-progress">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-lg-5 col-7">
                                        <div class="circle text-center">
                                            <div id="ticket-circle-progress-2"></div>
                                            <span class="abs-text text-warning"><?php echo $bookedPercentage; ?>%</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7 col-5 pl-2">
                                        <div>
                                            <h2 class="text-warning"><span><?php echo $totalBooked; ?></span></h2>
                                            <p class="text-pale-sky">Booked Rooms</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rooms Available -->
                <a href="table-datatable-basic.php">
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

                                    $RoomsAvailable =  $row2["AvRooms"] - $countRow['count'];

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
                                    <span class="sr-only">25% Complete</span>
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
                </a>


                <!-- row -->
                <div class="row">
                    <div class="col-xl-8 col-xxl-7 col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title m-t-10">Booked Graph</h4>
                                <div class="table-action float-right">
                                    <form action="#">
                                        <div class="form-row">
                                            <div class="form-group m-b-0">
                                                <select class="selectpicker show-tick" data-width="auto">
                                                    <option selected="selected">Last 30 Days</option>
                                                    <option>Last 1 MOnth</option>
                                                    <option>Last 6 MOnth</option>
                                                    <option>Last Year</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="monthly-orders-chart" style="display: none;"></canvas>
                                <canvas id="sales-graph"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-xxl-5 col-lg-4">
                        <div class="card" style="padding-bottom: 200px;">
                            <div class="card-header">
                                <h4 class="card-title">Most Selling Items</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="most-selling-items"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <a style="cursor: pointer">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <br>
                                <div class="card-header pt-0 pb-4 d-flex justify-content-between align-items-center">
                                    <h4 class="card-title"> Booked Rooms</h4>

                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-padded table-responsive-fix-big">
                                            <thead>
                                                <tr>
                                                    <th>Reservation ID</th>
                                                    <th>Guest Name</th>
                                                    <th>Room Type</th>
                                                    <th>Check-in</th>
                                                    <th>Check-out</th>
                                                    <th>Number of Guests</th>
                                                    <th>Total Booking Amount</th>
                                                </tr>
                                            </thead>

                                            <!-- Book Rooms -->
                                            <?php while ($row = $stmtBookings->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tbody>
                                                <tr>
                                                    <td><?php echo $row["id"] ?></td>
                                                    <td><?php echo $row["name"] ?></td>
                                                    <td>
                                                        <span class="text-muted"><?php echo $row["room_type"] ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted"><?php echo $row["start_date"] ?></span>
                                                    </td>
                                                    <td><?php echo $row["end_date"] ?></td>
                                                    <td><?php echo $sum = $row["num_adults"] + $row["num_children"] ?>
                                                    </td>
                                                    <td><?php echo $row["created_at"] ?></td>
                                                </tr>

                                            </tbody>
                                            <?php } ?>
                                            <!-- Book Rooms End -->
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
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

    <script src="../../assets/plugins/moment/moment.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="../../assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script src="../js/plugins-init/bs-date-picker-init.js"></script>

    <script src="../../assets/plugins/chart.js/Chart.bundle.min.js"></script>
    <script src="../../assets/plugins/circle-progress/circle-progress.min.js"></script>
    <script src="../js/dashboard/dashboard-6.js"></script>

    <!-- Chartjs chart -->
    <script src="../../assets/plugins/chart.js/Chart.bundle.min.js"></script>
    <script src="../../assets/plugins/d3v3/index.js"></script>
    <script src="../../assets/plugins/topojson/topojson.min.js"></script>
    <script src="../../assets/plugins/datamaps/datamaps.world.min.js"></script>

    <script src="../js/plugins-init/datamap-world-init.js"></script>

    <script src="../../assets/plugins/datamaps/datamaps.usa.min.js"></script>

    <script src="../js/dashboard/dashboard-1.js"></script>

    <script src="../js/plugins-init/datamap-usa-init.js"></script>
</body>

</html>