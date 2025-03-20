<?php
session_start();
include('Connection/SQLcon.php'); // Ensure this file contains your database connection

if (!isset($_SESSION['email'])) {
    header("Location: http://localhost/QuatroPasos/AuthandStatusPages/login.php"); // Redirect to login if not logged in
    exit();
}

$email = $_SESSION['email'];
$stmt = $conn->prepare("SELECT * FROM bookings WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if (isset($_POST['cancel'])) {
    $booking_id = $_POST['id'];
    $stmt = $conn->prepare("UPDATE bookings SET status = 'Cancelled' WHERE id = ?");
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    echo "<script>alert('Booking has been cancelled.'); window.location.href='bookings.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 20px;
            background-color: #f4f4f4;
        }

        table {
            width: 100%;
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

        button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        button:hover {
            background-color: #c82333;
        }

        a {
            display: inline-block;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        a:hover {
            background-color: #218838;
        }
    </style>
</head>

<body>
    <h1>Bookings</h1>


    <table border="1">
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
                <td><?= $row['id'] ?></td>
                <td><?= $row['room_type'] ?></td>
                <td><?= $row['type_of_stay'] ?></td>
                <td><?= $row['start_date'] ?></td>
                <td><?= $row['end_date'] ?></td>
                <td><?= $row['num_adults'] ?></td>
                <td><?= $row['num_children'] ?></td>
                <td><?= $row['Price'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <?php if ($row['status'] != 'Cancelled') { ?>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="email" value="<?= $email ?>">
                            <button type="submit" name="cancel">Cancel</button>
                        </form>
                        <a href="reschedule.php?id=<?= $row['id'] ?>">Reschedule</a>
                    <?php } else { ?>
                        Cancelled
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>