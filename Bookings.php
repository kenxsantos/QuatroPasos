<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

include('Connection/SQLcon.php'); // Ensure this file contains your database connection

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

    $stmt = $conn->prepare("UPDATE bookings SET start_date = ?, end_date = ? WHERE id = ?");
    $stmt->bind_param("ssi", $start_date, $end_date, $booking_id);

    if ($stmt->execute()) {
        echo "<script>alert('Booking has been successfully rescheduled!'); window.location.href='bookings.php';</script>";
        try {
            // Mailtrap SMTP settings
            // Looking to send emails in production? Check out our Email API/SMTP product!
            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = 'e6aa93a60f1fed';
            $phpmailer->Password = 'd42fef387bfa29';

            // Email details
            $phpmailer->setFrom('quatropasos.admin@qpb.com', 'Quatro Pasos');
            $phpmailer->addAddress($email);
            $phpmailer->Subject = "Successfully Rescheduled Booking";
            $phpmailer->isHTML(true);
            $phpmailer->Body = "Booking has been rescheduled. Your new booking dates are from $start_date to $end_date.";

            $phpmailer->send();
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
                            class="badge <?= ($row['status'] == 'cancelled') ? 'bg-danger' : (($row['status'] == 'pending') ? 'bg-warning text-dark' : (($row['status'] == 'confirmed') ? 'bg-success' : 'bg-secondary')) ?>">
                            <?= htmlspecialchars($row['status']) ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($row['status'] !== 'cancelled') { ?>
                            <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                            <button type="button">
                                <a href="cancellation_policy.php?bookingId=<?= urlencode($row['id']); ?>">Cancel</a>
                            </button>
                            <button type="button" class="btn btn-success btn-sm reschedule-btn" data-bs-toggle="modal"
                                data-bs-target="#rescheduleModal" data-id="<?= htmlspecialchars($row['id']) ?>">
                                Reschedule
                            </button>
                        <?php } else { ?>
                            <button class="btn btn-secondary btn-sm" disabled>Cancelled</button>
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

                            <button type="submit" class="btn btn-success btn-sm" name="reschedule">Save Changes</button>
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
        $(document).ready(function () {
            $(".date-picker").datepicker({
                dateFormat: "yy-mm-dd",
                minDate: 0,
                changeMonth: true,
                changeYear: true,
                showAnim: "slideDown"
            });

            $(".reschedule-btn").click(function () {
                var id = $(this).data("id");
                console.log("Selected Booking ID:", id);
                $("#appointment_id").val(id);
            });

        });
    </script>
</body>

</html>