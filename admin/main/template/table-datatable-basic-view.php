<?php
session_start();
include('../../../Connection/PDOcon.php');
include('../authorize.php');
include '../config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$Paymentid = isset($_GET['Paymentid']) ? intval($_GET['Paymentid']) : null;
if ($Paymentid === null) {
    die("Booking ID is missing.");
}

$bookingQuery = mysqli_query($conn, "SELECT * FROM bookings WHERE id = $Paymentid");
if (!$bookingQuery) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($bookingQuery);
if (!$row) {
    die("Booking not found.");
}

// Form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $status = $_POST['status'];

    // Update booking status
    $updateQuery = "UPDATE bookings SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("si", $status, $Paymentid);

    if ($stmt->execute()) {
        // Get room ID once
        $sqlRoom = "SELECT id FROM room WHERE type = ?";
        $stmtRoom = $conn->prepare($sqlRoom);
        $stmtRoom->bind_param("s", $row['room_type']);
        $stmtRoom->execute();
        $stmtRoom->bind_result($room_id);
        $stmtRoom->fetch();
        $stmtRoom->close();

        // Update room availability
        if ($status === 'Confirmed') {
            $sqlUpdateStatus = "UPDATE room SET AvRooms = AvRooms - 1 WHERE id = ?";
        } else {
            $sqlUpdateStatus = "UPDATE room SET AvRooms = AvRooms + 1 WHERE id = ?";
        }

        $stmtUpdateStatus = $conn->prepare($sqlUpdateStatus);
        $stmtUpdateStatus->bind_param("i", $room_id);
        $stmtUpdateStatus->execute();
        $stmtUpdateStatus->close();

        $stmt->close();
        mysqli_close($conn);

        header("Location: ./table-datatable-basic.php");
        exit();
    } else {
        echo "<p>Error updating booking status: " . $stmt->error . "</p>";
        $stmt->close();
    }
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
                                                    <input type="text" class="form-control" name="Price" id="Price"
                                                        value="₱<?php echo htmlspecialchars($row['Price']); ?>"
                                                        aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Start Date</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="start_date"
                                                        id="start_date"
                                                        value="<?php echo htmlspecialchars($row['start_date']); ?>"
                                                        aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">End Date</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="end_date"
                                                        id="end_date"
                                                        value="<?php echo htmlspecialchars($row['end_date']); ?>"
                                                        aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Room Type</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="room_type"
                                                        id="room_type"
                                                        value="<?php echo htmlspecialchars($row['room_type']); ?>"
                                                        aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Pax</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="num_adults"
                                                        id="num_adults"
                                                        value="<?php echo htmlspecialchars($row['num_adults']); ?>"
                                                        aria-describedby="validationDefaultUsername2" readonly>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <?php
                                            if ($row['status'] == 'Cancel Request' || $row['status'] == 'Reschedule Request') {
                                                // Display the status if it matches 'Cancel Request' or 'Reschedule Request'
                                            ?>
                                            <label
                                                class="col-sm-3 col-form-label text-label"><?php echo htmlspecialchars($row['status']); ?></label>
                                            <?php
                                            } else {
                                                // Display the "Booking Status" label if status is not 'Cancel Request' or 'Reschedule Request'
                                            ?>
                                            <label class="col-sm-3 col-form-label text-label">Booking Status</label>
                                            <?php
                                            }
                                            ?>

                                            <div class="col-sm-9">
                                                <?php
                                                if ($row['status'] == 'Cancel Request' || $row['status'] == 'Reschedule Request') {
                                                ?>
                                                <div class="input-group">
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="<?php
                                                                            if ($row['status'] == 'Cancel Request') {
                                                                                echo 'Cancel Confirmed';
                                                                            } else {
                                                                                echo 'Reschedule Confirmed';
                                                                            }
                                                                            ?>" <?php
                                                                                echo 'selected';
                                                                                ?>>
                                                            Accept
                                                        </option>
                                                        <option value="Rejected"
                                                            <?php if ($row['status'] == 'Rejected') echo 'selected'; ?>>
                                                            Reject
                                                        </option>
                                                    </select>
                                                </div>

                                                <?php
                                                } else {
                                                ?>
                                                <div class="input-group">
                                                    <select class="form-control" name="status" id="status">
                                                        <option value="Pending"
                                                            <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>
                                                            Pending
                                                        </option>
                                                        <option value="Confirmed"
                                                            <?php if ($row['status'] == 'Confirmed') echo 'selected'; ?>>
                                                            Confirmed
                                                        </option>
                                                        <option value="Cancelled"
                                                            <?php if ($row['status'] == 'Cancelled') echo 'selected'; ?>>
                                                            Cancelled
                                                        </option>
                                                        <option value="Waitlisted"
                                                            <?php if ($row['status'] == 'Waitlisted') echo 'selected'; ?>>
                                                            Waitlisted
                                                        </option>
                                                        <option value="Checked-in"
                                                            <?php if ($row['status'] == 'Checked-in') echo 'selected'; ?>>
                                                            Checked-in
                                                        </option>
                                                        <option value="Checked-out"
                                                            <?php if ($row['status'] == 'Checked-out') echo 'selected'; ?>>
                                                            Checked-out
                                                        </option>
                                                        <option value="No-show"
                                                            <?php if ($row['status'] == 'No-show') echo 'selected'; ?>>
                                                            No Show
                                                        </option>
                                                    </select>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                </div>
                                <button id="confirmButton" type="submit" name="update"
                                    class="btn btn-primary btn-form mr-2">Confirm</button>
                                <button type="button" name="update" class="btn btn-danger btn-form mr-2">
                                    <a href="table-datatable-basic.php">Cancel</a>
                                </button>

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