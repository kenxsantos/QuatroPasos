<?php

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

include('Connection/SQLcon.php');
$booking_id = isset($_GET['bookingId']) ? intval($_GET['bookingId']) : 0;
$email = $_SESSION['email'];
if ($booking_id === 0) {
    die("Invalid booking ID.");
}
// Handle Cancellation Request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_cancel'])) {
    // Prepare the update query
    $stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ?");
    $stmt->bind_param("i", $booking_id);

    if ($stmt->execute()) {

        echo "<script>alert('Booking has been cancelled.'); window.location.href='bookings.php';</script>";

        // Send email notification
        try {

            $phpmailer = new PHPMailer();
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = 'e6aa93a60f1fed';
            $phpmailer->Password = 'd42fef387bfa29';

            $phpmailer->setFrom('quatropasos.admin@qpb.com', 'Quatro Pasos');
            $phpmailer->addAddress($email);
            $phpmailer->Subject = "Booking Cancelled";
            $phpmailer->isHTML(true);
            $phpmailer->Body = "Your booking has been successfully cancelled.";

            $phpmailer->send();
        } catch (Exception $e) {
            echo "Email could not be sent. Mailer Error: {$phpmailer->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Failed to cancel booking.'); window.location.href='bookings.php';</script>";
    }
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css"> <!-- External CSS file -->
</head>

<body>

    <div class="container mt-5">
        <div class="card cancel-card">
            <div class="card-header bg-danger text-white">
                <h4>Cancel Booking</h4>
            </div>
            <div class="card-body">
                <p class="lead">Are you sure you want to cancel your booking?</p>
                <p class="text-muted">Please read and confirm our cancellation policy before proceeding.</p>
                <p>
                    All cancellation should be done 72 hours prior to the day of arrival to be excempted from the
                    cancellation charge. Cancellation is equivalent to 1 night stay. Non arrival fee is also equivalent
                    to 1 night stay. Depending on the mode of payment, other charges may be applied.
                </p>
                <div class="policy-box">
                    <p><strong>Cancellation Policy:</strong> If you cancel, you may not be eligible for a refund. Make
                        sure you understand the terms before proceeding.</p>
                </div>

                <form action="cancellation_policy.php?bookingId=<?php echo $booking_id; ?>" method="POST">
                    <input type="hidden" id="cancellation_id" name="id">
                    <div class="form-check mt-3">
                        <input type="checkbox" class="form-check-input" id="confirmPolicy">
                        <label for="confirmPolicy" class="form-check-label">I agree to the cancellation policy</label>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="bookings.php" class="btn btn-secondary">Go Back</a>
                        <button type="submit" class="btn btn-danger" id="confirmCancel" name="confirm_cancel"
                            disabled>Confirm
                            Cancellation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("confirmPolicy").addEventListener("change", function () {
            document.getElementById("confirmCancel").disabled = !this.checked;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>