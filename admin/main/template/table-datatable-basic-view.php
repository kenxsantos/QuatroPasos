<?php
session_start(); // Start the session
include ('../../../Connection/PDOcon.php');

// Check if the user is logged in and their role is equal to 1
$isLoggedIn = isset($_SESSION['user_id']);
if ($isLoggedIn) {
    $stmt2 = $pdo->prepare("SELECT * FROM `user` WHERE id = ?");
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

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get Paymentid from URL and check if it's set and valid
$Paymentid = isset($_GET['Paymentid']) ? intval($_GET['Paymentid']) : null;

if ($Paymentid === null) {
    die("Booking ID is missing.");
}

// Query the database for the booking with the specified ID
$bookingQuery = mysqli_query($conn, "SELECT * FROM bookings WHERE id = $Paymentid");

if (!$bookingQuery) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch the result as an associative array
$row = mysqli_fetch_assoc($bookingQuery);

if (!$row) {
    die("Booking not found.");
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Get the selected BookingStats value from the dropdown
    $BookingStats = $_POST['BookingStats'];

    // Prepare the SQL statement for updating the BookingStats column
    $updateQuery = "UPDATE bookings SET BookingStats = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $BookingStats, $Paymentid);

    // Execute the update query
    if ($stmt->execute()) {
        // Redirect back to the same page to refresh it
        header("Location: " . $_SERVER['PHP_SELF'] . "?Paymentid=" . $Paymentid);
        exit();
    } else {
        echo "<p>Error updating booking status: " . $stmt->error . "</p>";
    }

    // Close the prepared statement
    $stmt->close();
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
    <title>Gleek - Ultimate Bootstrap 4 Sidebar</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="">
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
            <div class="brand-logo"><a href="index.html"><b><img src="../../assets/images/logo.png" alt=""> </b><span class="brand-title"><img src="../../assets/images/logo-text.png" alt=""></span></a>
            </div>
            <div class="nav-control">
                <div class="hamburger"><span class="line"></span>  <span class="line"></span>  <span class="line"></span>
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
                                <span><?=$row2["name"]?></span> <i class="fa fa-caret-down f-s-14" aria-hidden="true"></i>
                            </a>
                            <div class="drop-down dropdown-profile animated bounceInDown">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="javascript:void()"><i class="icon-user"></i> <span>My Profile</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-wallet"></i> <span>My Wallet</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-envelope"></i> <span>Inbox</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="fa fa-cog"></i> <span>Setting</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-lock"></i> <span>Lock Screen</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-power"></i> <span>Logout</span></a>
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
        <div class="nk-sidebar">           
            <div class="nk-nav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="mega-menu mega-menu-sm">
                        <a href="index-ticket.html" aria-expanded="false">
                            <i class="mdi mdi-view-dashboard"></i><span class="nav-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                            <i class="mdi mdi-page-layout-body"></i><span class="nav-text">Layouts</span>
                        </a>
                        <ul aria-expanded="false">
                            <li><a href="./form-layout-home.php">Home</a>
                            </li>
                            <li class="active"><a href="./Form-layout-Accommo.php">Accommodation</a>
                            </li>
                            <li><a href="./Form-layout-Facilites.php">Facilities</a>
                            </li>
                            <li><a href="./form-layout-Promo.php">Promos</a>
                            </li>
                        </ul>
                    </li>
                    <li class="mega-menu mega-menu-sm active">
                        <a class="" href="./table-datatable-basic.php" aria-expanded="false">
                            <i class="mdi mdi-table"></i><span class="nav-text">Room Booking</span>
                        </a>
                    </li>
                    <li class="mega-menu mega-menu-sm">
                        <a class="" href="https://dashboard.paymongo.com/payments" target="_blank" aria-expanded="false">
                            <i class="mdi mdi-table"></i><span class="nav-text">Payment</span>
                        </a>
                    </li>

                </ul>
            </div>
        </div>
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
                    <div class="col-xl-12">
                        <div class="card forms-card">
                            <div class="card-body">
                            <p>Receipt:</p>
                            <?php
                            if (empty($row['payment_image'])) {
                                echo "<p>No receipt submitted</p>";
                            } else {
                                echo '<img src="../../../' . htmlspecialchars($row['payment_image']) . '" style="width:30%"><br><br>';
                            }
                            ?>
                                <h4 class="card-title mb-4">Booking ID - <?php echo $row['id']; ?></h4>
                                <div class="basic-form">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Price</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="Price" id="Price" value="₱<?php echo htmlspecialchars($row['Price']); ?>" aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Start Date</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="start_date" id="start_date" value="<?php echo htmlspecialchars($row['start_date']); ?>" aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">End Date</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="end_date" id="end_date" value="<?php echo htmlspecialchars($row['end_date']); ?>" aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Room Type</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="RoomType" id="RoomType" value="<?php echo htmlspecialchars($row['RoomType']); ?>" aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Pax</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="num_adults" id="num_adults" value="<?php echo htmlspecialchars($row['num_adults']); ?>" aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Booking Status</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select class="form-control" name="BookingStats" id="BookingStats">
                                                        <option value="Pending" <?php if($row['BookingStats'] == 'Pending') echo 'selected'; ?>>Pending</option>
                                                        <option value="Confirmed" <?php if($row['BookingStats'] == 'Confirmed') echo 'selected'; ?>>Confirmed</option>
                                                        <option value="Cancelled" <?php if($row['BookingStats'] == 'Cancelled') echo 'selected'; ?>>Cancelled</option>
                                                        <option value="Waitlisted" <?php if($row['BookingStats'] == 'Waitlisted') echo 'selected'; ?>>Waitlisted</option>
                                                        <option value="Checked-in" <?php if($row['BookingStats'] == 'Checked-in') echo 'selected'; ?>>Checked-in</option>
                                                        <option value="Checked-out" <?php if($row['BookingStats'] == 'Checked-out') echo 'selected'; ?>>Checked-out</option>
                                                        <option value="No-show" <?php if($row['BookingStats'] == 'No-show') echo 'selected'; ?>>No Show</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    
                                        
                                        <button type="submit" name="update" class="btn btn-primary btn-form mr-2">Confirm</button>
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