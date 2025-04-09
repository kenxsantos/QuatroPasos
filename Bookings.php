<?php
session_start();
require './Connection/Script.php';
include('Connection/SQLcon.php');

if (!isset($_SESSION['email'])) {
    header("Location: ./AuthandStatusPages/login.php"); // Redirect to login if not logged in
    exit();
}

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT * FROM bookings WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

// Handle Reschedule Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reschedule'])) {
    $booking_id = $_POST['id'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    $stmt = $conn->prepare("UPDATE bookings SET status = 'Reschedule Request', start_date = ?, end_date = ? WHERE id = ?");
    $stmt->bind_param("ssi", $start_date, $end_date, $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking Rescheduled is Under Review'); window.location.href='bookings.php';</script>";
        try {
            sendMail($email, "Your Booking Reschedule Request is Under Review", "
            <p>We have received your request to reschedule your booking, and our team is currently reviewing it.</p>

            <p><strong>What Happens Next:</strong></p>
            <ul>
                <li>We are verifying the availability of your requested dates.</li>
                <li>You will receive a follow-up email once the reschedule is confirmed or if any adjustments are needed.</li>
            </ul>

            <p>We appreciate your patience during this process. If you have any immediate questions or need further assistance, please don’t hesitate to contact us.</p>

            <p>Thank you for choosing <strong>Quatro Pasos</strong>. We’ll be in touch shortly!</p>

            <br>
            <p>Warm regards,</p>
            <p><strong>Quatro Pasos Team</strong></p>
            ");

            echo "A verification email has been sent!";
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Failed to reschedule booking.'); window.location.href='bookings.php';</script>";
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/coloring.css" rel="stylesheet">
    <link href="css/plugins.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        height: 100vh;
    }

    table {
        margin: 20px auto;
        width: 90%;
        border-collapse: collapse;
        background: white;
    }

    th,
    td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: left;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .btn-danger:hover {
        background-color: #c82333;
    }

    .btn-success:hover {
        background-color: #218838;
    }
    </style>
</head>

<body>
    <h1>Bookings</h1>
    <?php if ($result->num_rows == 0) { ?>
    <p>No bookings found.</p>
    <?php } else { ?>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>Room Type</th>
            <th>Type of Stay</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>No. of Adults</th>
            <th>No. of Children</th>
            <th>Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
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
            <td>
                <span
                    class="badge <?= ($row['status'] === 'Cancelled') ? 'bg-danger' : (($row['status'] === 'Pending') ? 'bg-warning text-dark' : (($row['status'] === 'Confirmed') ? 'bg-success' : 'bg-secondary')) ?>">
                    <?= htmlspecialchars(($row['status'])) ?>
                </span>
            </td>
            <td>
                <?php if ($row['status'] == 'Pending') { ?>
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                <button type="button">
                    <a href="cancellation_policy.php?bookingId=<?= urlencode($row['id']); ?>">Cancel</a>
                </button>
                <button type="button" class="btn btn-success btn-sm reschedule-btn" data-bs-toggle="modal"
                    data-bs-target="#rescheduleModal" data-id="<?= htmlspecialchars($row['id']) ?>">
                    Reschedule
                </button>
                <?php } elseif ($row['status'] == 'Confirmed') { ?>
                <button type="button">
                    <a href="cancellation_policy.php?bookingId=<?= urlencode($row['id']); ?>">Cancel</a>
                </button>
                <?php } elseif ($row['status']) { ?>
                <button class="btn btn-success btn-sm" disabled><?= htmlspecialchars(($row['status'])) ?></button>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>

    <!-- Reschedule Modal -->
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

                        <button type="submit-reschedule" class="btn btn-success btn-sm" name="reschedule">Save
                            Changes</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
    <?php } ?>

    <script src="js/plugins.js"></script>

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