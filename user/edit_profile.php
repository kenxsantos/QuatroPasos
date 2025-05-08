<?php
include('../Connection/PDOcon.php');
session_start();

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database: " . $e->getMessage());
}

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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];
    if (isset($_POST['first_name'])) {
        $first_name = trim($_POST['first_name']);
        if (!empty($first_name)) {
            $stmt = $pdo->prepare("UPDATE users  SET firstname = :firstname WHERE id = :id");
            $stmt->execute(['firstname' => $first_name, 'id' => $user_id]);
        } else {
            $errors[] = "First Name cannot be empty.";
        }
    }

    if (isset($_POST['last_name'])) {
        $last_name = trim($_POST['last_name']);
        if (!empty($last_name)) {
            $stmt = $pdo->prepare("UPDATE users  SET lastname = :lastname WHERE id = :id");
            $stmt->execute(['lastname' => $last_name, 'id' => $user_id]);
        } else {
            $errors[] = "Last Name cannot be empty.";
        }
    }

    if (isset($_POST['email'])) {
        $email = trim($_POST['email']);
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $stmt = $pdo->prepare("UPDATE users SET email = :email WHERE id = :id");
            $stmt->execute(['email' => $email, 'id' => $user_id]);
        } else {
            $errors[] = "Invalid email address.";
        }
    }
    if (isset($_POST['phone'])) {
        $phone = trim($_POST['phone']);
        if (preg_match('/^[0-9]{10,15}$/', $phone)) {
            $stmt = $pdo->prepare("UPDATE users SET phone = :phone WHERE id = :id");
            $stmt->execute(['phone' => $phone, 'id' => $user_id]);
        } else {
            $errors[] = "Invalid phone number.";
        }
    }

    if (isset($_POST['address'])) {
        $address = trim($_POST['address']);
        if (!empty($address)) {
            $stmt = $pdo->prepare("UPDATE users SET address = :address WHERE id = :id");
            $stmt->execute(['address' => $address, 'id' => $user_id]);
        } else {
            $errors[] = "Address cannot be empty.";
        }
    }
    echo "<script>alert('Profile updated successfully';</script>";
    header("Location: profile.php");
    exit;
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
    <link href="./style.css" rel="stylesheet">

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
        ***********************************-->

        <!--**********************************
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
                    <div class="col-xl-12">
                        <div class="card forms-card">
                            <div class="card-body">
                                <h4 class="card-title mb-4">👤 Edit your Profile</h4>
                                <div class="basic-form">
                                    <form method="POST" enctype="multipart/form-data" id="editProfileForm">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">First Name</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="first_name"
                                                        id="first_name"
                                                        value="<?php echo htmlspecialchars($user['firstname']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Last Name</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="last_name"
                                                        id="last_name"
                                                        value="<?php echo htmlspecialchars($user['lastname']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Email</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="email" class="form-control" name="email" id="email"
                                                        value="<?php echo htmlspecialchars($user['email']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Phone</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="phone" id="phone"
                                                        value="<?php echo htmlspecialchars($user['phone']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Address</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="address" id="address"
                                                        value="<?php echo htmlspecialchars($user['address']); ?>"
                                                        required>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                <button id="confirmButton" type="submit" name="update"
                                    class="btn btn-primary btn-form mr-2">Confirm</button>
                                <button type="button" name="update" class="btn btn-danger btn-form mr-2">
                                    <a href="profile.php">Cancel</a>
                                </button>
                                </form>
                            </div>
                        </div>
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
</body>

</html>