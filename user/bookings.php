<?php
include('../Connection/PDOcon.php');
include('../Connection/SQLcon.php');
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ./AuthandStatusPages/login.php"); // Redirect to login if not logged in
    exit();
}

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT * FROM bookings WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

// Fetch user data (assuming user ID is stored in session)
$user_id = $_SESSION['user_id'] ?? null;

if (!$user_id) {
    die("User not logged in.");
}

$query = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$query->execute(['id' => $user_id]);
$user = $query->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("User not found.");
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
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
    .btn-cancel {
        display: inline-block;
        padding: 2px 10px;
        background-color: #ff4d4d;
        /* red */
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 2px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-cancel:hover {
        background-color: #e60000;
        /* darker red on hover */
    }

    .btn-resched {
        display: inline-block;
        padding: 2px 10px;
        background-color: rgb(158, 97, 97);
        /* red */
        color: white;
        text-decoration: none;
        border: none;
        border-radius: 2px;
        font-weight: bold;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .btn-resched:hover {
        background-color: #e60000;
        /* darker red on hover */
    }
    </style>
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
                                                <th>Booking ID</th>
                                                <th>Room Type</th>
                                                <th>Type of Stay</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>No. of Adults</th>
                                                <th>No. of Children</th>
                                                <th>Price</th>
                                                <th>Down Payment</th>
                                                <th>Balance</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php while ($row = $result->fetch_assoc()) { ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['id']) ?></td>
                                                <td><?= htmlspecialchars($row['room_type']) ?></td>
                                                <td><?= htmlspecialchars($row['type_of_stay']) ?></td>
                                                <td><?= htmlspecialchars($row['start_date']) ?></td>
                                                <td><?= htmlspecialchars($row['end_date']) ?></td>
                                                <td><?= htmlspecialchars($row['num_adults']) ?></td>
                                                <td><?= htmlspecialchars($row['num_children']) ?></td>
                                                <td><?= htmlspecialchars($row['Price']) ?></td>
                                                <td><?= htmlspecialchars($row['down_payment']) ?>
                                                </td>
                                                <td><?= htmlspecialchars($row['balance']) ?>
                                                </td>

                                                <td>
                                                    <span
                                                        class="badge <?= ($row['status'] === 'Cancelled') ? 'bg-danger' : (($row['status'] === 'Pending') ? 'bg-warning text-dark' : (($row['status'] === 'Confirmed') ? 'bg-success' : 'bg-secondary')) ?>">
                                                        <?= htmlspecialchars(($row['status'])) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <?php if ($row['status'] == 'Pending') { ?>
                                                    <input type="hidden" name="id"
                                                        value="<?= htmlspecialchars($row['id']) ?>">
                                                    <a href="cancellation_policy.php?bookingId=<?= urlencode($row['id']); ?>"
                                                        class="btn-cancel">Cancel</a>

                                                    <button type="button" class="btn-resched  reschedule-btn"
                                                        data-bs-toggle="modal" data-bs-target="#rescheduleModal"
                                                        data-id="<?= htmlspecialchars($row['id']) ?>">
                                                        Reschedule
                                                    </button>
                                                    <?php } elseif ($row['status'] == 'Confirmed') { ?>
                                                    <a href="cancellation_policy.php?bookingId=<?= urlencode($row['id']); ?>"
                                                        class="btn-cancel">Cancel</a>

                                                    <?php } elseif ($row['status']) { ?>
                                                    <button class="btn btn-success btn-sm"
                                                        disabled><?= htmlspecialchars(($row['status'])) ?></button>
                                                    <?php } ?>
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
        </div>
    </div>
    <div class="modal fade" id="rescheduleModal" tabindex="-1" aria-labelledby="rescheduleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reschedule Appointment</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <input type="hidden" id="appointment_id" name="id">

                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="text" id="start-date" class="form-control date-picker" name="start_date"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="text" id="end-date" class="form-control date-picker" name="end_date" required>
                        </div>

                        <button type="submit-reschedule" class="btn-resched " name="reschedule">Save
                            Changes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <script src="../admin/assets/plugins/common/common.min.js"></script>
    <script src="../admin/main/js/custom.min.js"></script>
    <script src="../admin/main/js/settings.js"></script>
    <script src="../admin/main/js/gleek.js"></script>
    <script src="../admin/main/js/styleSwitcher.js"></script>
    <script src="../admin/assets/plugins/moment/moment.min.js"></script>

    <script src="../js/plugins.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

    <script>
    $(document).ready(function() {
        $(".date-picker").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: 0,
            changeMonth: true,
            changeYear: true,
            showAnim: "slideDown"
        });

        $(".reschedule-btn").click(function() {
            var id = $(this).data("id");
            console.log("Selected Booking ID:", id);
            $("#appointment_id").val(id);
        });

    });
    </script>
</body>

</html>