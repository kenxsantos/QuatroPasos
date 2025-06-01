<?php

session_start();
include('../../../Connection/PDOcon.php');
include('../authorize.php');
include '../config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_GET['customerId'])) {
    $isCustomer = true;
    $userId = $_GET['customerId'];
} elseif (isset($_GET['accountId'])) {
    $isCustomer = false;
    $userId = $_GET['accountId'];
} else {
    echo "<script>alert('Invalid request!'); window.location.href='form-layout-home.php';</script>";
    exit();
}

if (isset($_POST['confirm_delete'])) {
    $idToDelete = intval($_POST['user_id']);

    $deleteQuery = "DELETE FROM users WHERE id = $idToDelete";

    if (mysqli_query($conn, $deleteQuery)) {
        echo "<script>alert('User deleted successfully.'); window.location.href='";
        echo $isCustomer ? "table-datatable-customer.php" : "table-datatable-user-account.php";
        echo "';</script>";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
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
                <h4>Delete Customer Information</h4>
            </div>
            <div class="card-body">
                <h3 class="text-danger">⚠️ Warning!</h3>
                <p>Are you sure you want to delete this customer information?</p>

                <form method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                    <button type="submit" name="confirm_delete" class="btn btn-danger">Confirm Delete</button>
                    <?php if ($isCustomer): ?>
                    <a href="table-datatable-customer.php" class="btn btn-secondary">Cancel</a>
                    <?php else: ?>
                    <a href="table-datatable-user-account.php" class="btn btn-secondary">Cancel</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>