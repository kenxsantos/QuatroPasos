<?php
session_start();
include('../../../Connection/SQLIcon.php');
include('../../../Connection/PDOcon.php');
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
if ($conn->connect_error) die("Connection failed");

// Bookings per month
$monthly = $conn->query("SELECT DATE_FORMAT(created_at, '%Y-%m') AS month, COUNT(*) AS count FROM bookings GROUP BY month ORDER BY month ASC");
$months = [];
$monthlyCounts = [];
while ($row = $monthly->fetch_assoc()) {
    $months[] = $row['month'];
    $monthlyCounts[] = $row['count'];
}

//reservation mode
$status = $conn->query("SELECT reservation, COUNT(*) AS count FROM bookings GROUP BY reservation");
$reservationMode = [];
$reservationCounts = [];
while ($row = $status->fetch_assoc()) {
    $reservationMode[] = $row['reservation'];
    $reservationCounts[] = $row['count'];
}

// Bookings by status
$status = $conn->query("SELECT status, COUNT(*) AS count FROM bookings GROUP BY status");
$statuses = [];
$statusCounts = [];
while ($row = $status->fetch_assoc()) {
    $statuses[] = $row['status'];
    $statusCounts[] = $row['count'];
}

// Bookings by room type
$rooms = $conn->query("SELECT room_type, COUNT(*) AS count FROM bookings GROUP BY room_type");
$roomTypes = [];
$roomCounts = [];
while ($row = $rooms->fetch_assoc()) {
    $roomTypes[] = $row['room_type'];
    $roomCounts[] = $row['count'];
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
    <link rel="icon" href="../../../images/icon.png" type="image/gif" sizes="16x16">
    <!-- Custom Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
    .modal-content {
        border-radius: 1rem;
        border: none;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        background: #ffffff;
    }

    .modal-header {
        border-bottom: 1px solid #dee2e6;
        background-color: #f8f9fa;
        padding: 1.2rem 1.5rem;
        border-top-left-radius: 1rem;
        border-top-right-radius: 1rem;
    }

    .modal-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #343a40;
    }

    .modal-body {
        padding: 2rem;
        font-size: 1.5rem;
        color: #495057;
    }

    .modal-body ul {
        list-style: none;
        padding-left: 0;
    }

    .modal-body li {
        margin-bottom: 1rem;
        padding: 0.75rem 1rem;
        background-color: #f1f3f5;
        border-left: 4px solid #0d6efd;
        border-radius: 0.5rem;
    }

    .modal-body li strong {
        color: #212529;
    }

    .btn-close {
        filter: brightness(0.6);
    }

    @media (max-width: 576px) {
        .modal-body {
            padding: 1.2rem;
        }
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
                                        <li><a href="../../../logout.php"><i class="icon-power"></i>
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
        <!-- Modal -->

        <!-- MODAL -->
        <div class="modal fade" id="dataSummaryModal" tabindex="-1" aria-labelledby="dataSummaryModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="dataSummaryModalLabel">
                            📊 Data Summary
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="dataSummaryContent">
                        <!-- Summary content will be injected here -->
                    </div>
                </div>
            </div>
        </div>




        <div class="content-body">
            <div class="container-fluid">
                <!-- row 1: Monthly and Room Type Bookings -->
                <div class="row">
                    <div class="col-xl-6 col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mt-2">📅 Monthly Bookings</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="monthlyBookings"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mt-2">🛏️ Room Type Bookings</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="roomTypeBookings"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- row 2: Status Doughnut Chart -->
                <div class="row">
                    <div class="col-xl-6 col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mt-2">🛏️ Reservation</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="reservation"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title mt-2">📌 Booking Status</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="statusBookings"></canvas>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <!--**********************************
            Content body end
        ***********************************-->


    </div>
    <script>
    // Bookings per month
    const monthlyCtx = document.getElementById('monthlyBookings').getContext('2d');
    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($months) ?>,
            datasets: [{
                label: 'Bookings per Month',
                data: <?= json_encode($monthlyCounts) ?>,
                borderColor: 'blue',
                fill: false,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            if (Number.isInteger(value)) {
                                return value;
                            }
                        }
                    }
                }
            }
        }

    });

    // Bookings by status
    const statusCtx = document.getElementById('statusBookings').getContext('2d');
    new Chart(statusCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($statuses) ?>,
            datasets: [{
                data: <?= json_encode($statusCounts) ?>,
                backgroundColor: ['red', 'green', 'blue', 'orange', 'purple', 'gray']
            }]
        }
    });

    //reservation mode

    const reservationCtx = document.getElementById('reservation').getContext('2d');
    new Chart(reservationCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($reservationMode) ?>,
            datasets: [{
                data: <?= json_encode($reservationCounts) ?>,
                backgroundColor: ['blue', 'orange']
            }]
        }
    });


    // Bookings by room type
    const roomCtx = document.getElementById('roomTypeBookings').getContext('2d');
    new Chart(roomCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($roomTypes) ?>,
            datasets: [{
                label: 'Bookings by Room Type',
                data: <?= json_encode($roomCounts) ?>,
                backgroundColor: 'teal'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1,
                        callback: function(value) {
                            if (Number.isInteger(value)) {
                                return value;
                            }
                        }
                    }
                }
            }
        }

    });
    </script>
    <script>
    window.addEventListener('DOMContentLoaded', () => {
        // Data from PHP
        const months = <?= json_encode($months) ?>;
        const monthlyCounts = <?= json_encode($monthlyCounts) ?>.map(Number);
        const roomTypes = <?= json_encode($roomTypes) ?>;
        const roomCounts = <?= json_encode($roomCounts) ?>.map(Number);
        const statuses = <?= json_encode($statuses) ?>;
        const statusCounts = <?= json_encode($statusCounts) ?>;
        const reservationModes = <?= json_encode($reservationMode) ?>;
        const reservationCounts = <?= json_encode($reservationCounts) ?>;

        // Get most booked room type
        let maxRoom = Math.max(...roomCounts);
        let mostBookedRoom = roomTypes[roomCounts.indexOf(maxRoom)];

        // Get month with most bookings
        let maxMonth = Math.max(...monthlyCounts);
        let topMonth = months[monthlyCounts.indexOf(maxMonth)];
        console.log('monthlyCounts:', monthlyCounts);
        console.log('months:', months);

        // Create summary message
        const summaryHtml = `
      <ul>
        <li><strong>Most Booked Room Type:</strong> ${mostBookedRoom} (${maxRoom} bookings)</li>
        <li><strong>Peak Booking Month:</strong> ${topMonth} (${maxMonth} bookings)</li>
        <li><strong>Reservation Modes:</strong><br>
          ${reservationModes.map((mode, i) => `&nbsp;&nbsp;• ${mode}: ${reservationCounts[i]}`).join("<br>")}
        </li>
        <li><strong>Booking Status Breakdown:</strong><br>
          ${statuses.map((status, i) => `&nbsp;&nbsp;• ${status}: ${statusCounts[i]}`).join("<br>")}
        </li>
      </ul>
    `;

        document.getElementById('dataSummaryContent').innerHTML = summaryHtml;

        // Show modal (Bootstrap 5)
        const modal = new bootstrap.Modal(document.getElementById('dataSummaryModal'));
        modal.show();
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