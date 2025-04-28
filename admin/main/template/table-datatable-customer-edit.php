<?php
session_start();
include('../../../Connection/PDOcon.php');
include('../authorize.php');
include '../config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


$isCustomer = null;
$role_as = 0;

if (isset($_GET['customerId'])) {
    $isCustomer = true;
    $userId = intval($_GET['customerId']);
} elseif (isset($_GET['accountId'])) {
    $isCustomer = false;
    $userId = intval($_GET['accountId']);
} else {
    echo "<script>alert('Invalid request!'); window.location.href='table-datatable-user-account.php';</script>";
    exit();
}

$userQuery = mysqli_query($conn, "SELECT * FROM users WHERE id = $userId");
if (!$userQuery) {
    die("Query failed: " . mysqli_error($conn));
}

$row = mysqli_fetch_assoc($userQuery);
if (!$row) {
    die("User not found.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname  = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone']);
    $address   = mysqli_real_escape_string($conn, $_POST['address']);
    if ($_POST['role_as'] == 'Admin') {
        $role_as = 1;
    } elseif ($_POST['role_as'] == 'Receptionist') {
        $role_as = 2;
    }
    $checkEmailQuery = "SELECT id FROM users WHERE email = '$email' AND id != $userId LIMIT 1";
    $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

    if (mysqli_num_rows($checkEmailResult) > 0) {
        echo "<script>alert('Email already exists! Please use another email.'); window.history.back();</script>";
        exit();
    } else {

        $updateQuery = "UPDATE users
                        SET firstname = '$firstname',
                            lastname = '$lastname',
                            email = '$email',
                            phone = '$phone',
                            address = '$address',
                            role_as = '$role_as'
                        WHERE id = $userId";

        if (mysqli_query($conn, $updateQuery)) {
            echo "<script>alert('User updated successfully.'); window.location.href='";
            echo $isCustomer ? "table-datatable-customer.php" : "table-datatable-user-account.php";
            echo "';</script>";
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
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
                                <h4 class="card-title mb-4">Customer ID - <?php echo $row['id']; ?></h4>
                                <div class="basic-form">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">First Name</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="firstname"
                                                        id="firstname"
                                                        value="<?php echo htmlspecialchars($row['firstname']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Last Name</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="lastname"
                                                        id="lastname"
                                                        value="<?php echo htmlspecialchars($row['lastname']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Email</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        value="<?php echo htmlspecialchars($row['email']); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Phone</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="phone" id="phone"
                                                        value="<?php echo htmlspecialchars($row['phone']); ?>" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Address</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="address" id="address"
                                                        value="<?php echo htmlspecialchars($row['address']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center"
                                            <?php echo $isCustomer ? 'style="display:none;"' : ''; ?>>
                                            <label class="col-sm-3 col-form-label text-label">Role</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <select class="form-control" name="role_as" id="role_as" required>
                                                        <option value="Admin"
                                                            <?php echo ($row['role_as'] == 1) ? 'selected' : ''; ?>>
                                                            Admin</option>
                                                        <option value="Receptionist"
                                                            <?php echo ($row['role_as'] == 2) ? 'selected' : ''; ?>>
                                                            Receptionist</option>
                                                        <option value="User"
                                                            <?php echo ($row['role_as'] == 0) ? 'selected' : ''; ?>>
                                                            Normal User</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                </div>
                                <button type="submit" class="btn btn-primary btn-form mr-2">Save</button>
                                <button type="button" class="btn btn-danger btn-form mr-2" value="Cancel"
                                    onclick="window.location.href='table-datatable-customer.php'">Cancel</button>

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