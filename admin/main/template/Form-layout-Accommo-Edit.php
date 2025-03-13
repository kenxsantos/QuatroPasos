<?php
session_start(); // Start the session
include('../../../Connection/PDOcon.php');


// Check if the user is logged in and their role is equal to 1
$isLoggedIn = isset($_SESSION['user_id']);
if ($isLoggedIn) {
    $stmt2 = $pdo->prepare("SELECT * FROM `users` WHERE id = ?");
    $stmt2->execute([$_SESSION['user_id']]);
    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

    if ($row2) {
        $roleCheck = $row2["role_as"];

        if ($roleCheck == 1) {
            // User has the correct role
            // Continue with the logic for users with role 1
        } else {
            header("Location: ../../../AuthAndStatusPages/401.php");
            exit(); // Prevent further execution
        }
    } else {
        // Handle the case where no user was found
        header("Location: ../../../AuthAndStatusPages/401.php");
        exit();
    }
} else {
    // User is not logged in
    header("Location: ../../../AuthAndStatusPages/401.php");
    exit();
}

include '../config.php';

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Get roomid from URL and check if it's set and valid
$roomid = isset($_GET['roomid']) ? intval($_GET['roomid']) : null;

if ($roomid === null) {
    die("Room ID is missing.");
}

// Query the database
$roomdb = mysqli_query($conn, "SELECT * FROM room WHERE id = $roomid");

if (!$roomdb) {
    die("Query failed: " . mysqli_error($conn));
}

// Fetch the result as an associative array
$row = mysqli_fetch_assoc($roomdb);

if (!$row) {
    die("Room not found.");
}

// Check if the form is submitted for update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    // Get the form inputs, using current values from DB as fallback
    $type = !empty($_POST['type']) ? $_POST['type'] : $row['type'];
    $price = !empty($_POST['Price']) ? $_POST['Price'] : $row['Price'];
    $pax = !empty($_POST['Pax']) ? $_POST['Pax'] : $row['Pax'];
    $bedding = !empty($_POST['bedding']) ? $_POST['bedding'] : $row['bedding'];
    $AvRooms = !empty($_POST['AvRooms']) ? $_POST['AvRooms'] : $row['AvRooms'];
    $imageFile = $_FILES['image'];

    $imagePath = $row['img']; // Default to existing image path

    // Check if an image file was uploaded
    if ($imageFile['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $imageFile['tmp_name'];
        $imageName = basename($imageFile['name']);
        $imageSize = $imageFile['size'];
        $imageType = $imageFile['type'];
        $uploadDir = 'uploads/'; // Make sure this directory exists and is writable
        $targetFilePath = $uploadDir . $imageName;

        // Allowed file types
        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($imageType, $allowedFileTypes) && $imageSize > 0) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($imageTmpPath, $targetFilePath)) {
                // Set the image path for the database update
                $imagePath = $targetFilePath;
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
        }
    }

    // Prepare the SQL Update Statement including the image path (VARCHAR)
    $sql = "UPDATE room SET type = ?, Price = ?, Pax = ?, bedding = ?, AvRooms = ?, img = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssi", $type, $price, $pax, $bedding, $AvRooms, $imagePath, $roomid);

    // Execute the Statement
    if (isset($stmt) && mysqli_stmt_execute($stmt)) {
        // Redirect to the same page to avoid form resubmission
        header("Location: " . $_SERVER['PHP_SELF'] . "?roomid=" . $roomid);
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    // Close the prepared statement
    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
}

// Check if delete button was clicked
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $deleteSql = "DELETE FROM room WHERE id = ?";
    $deleteStmt = mysqli_prepare($conn, $deleteSql);
    mysqli_stmt_bind_param($deleteStmt, "i", $roomid);

    if (mysqli_stmt_execute($deleteStmt)) {
        // Redirect to a confirmation page or back to the listing page
        header("Location: Form-layout-Accommo.php"); // Change 'index.php' to the desired page
        exit();
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_stmt_close($deleteStmt);
}

// Close the database connection
mysqli_close($conn);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Gleek - Ultimate Bootstrap 4 Sidebar</title>
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
            <div class="brand-logo"><a href="index.html"><b><img src="../../assets/images/logo.png" alt=""> </b><span
                        class="brand-title"><img src="../../assets/images/logo-text.png" alt=""></span></a>
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
                            <div class="photo-content">
                                <div class="cover-photo"
                                    style="background-image: url(<?php echo $row['img']; ?>)!important"></div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title mb-4">Accommodation - <?php echo $row['type']; ?></h4>
                                <div class="basic-form">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Upload File</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="file" class="form-control" name="image" id="image"
                                                        aria-describedby="inputGroupPrepend2">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Room Type</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="type" id="type"
                                                        placeholder="<?php echo htmlspecialchars($row['type']); ?>"
                                                        aria-describedby="validationDefaultUsername2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Price</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="Price" id="Price"
                                                        placeholder="<?php echo htmlspecialchars($row['Price']); ?>"
                                                        aria-describedby="validationDefaultUsername2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Pax</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="Pax" id="Pax"
                                                        placeholder="<?php echo htmlspecialchars($row['Pax']); ?>"
                                                        aria-describedby="validationDefaultUsername2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Beddings</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="bedding" id="bedding"
                                                        placeholder="<?php echo htmlspecialchars($row['bedding']); ?>"
                                                        aria-describedby="validationDefaultUsername2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Room Provided</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="AvRooms" id="AvRooms"
                                                        placeholder="<?php echo htmlspecialchars($row['AvRooms']); ?>"
                                                        aria-describedby="validationDefaultUsername2">
                                                </div>
                                            </div>
                                        </div>


                                        <button type="submit" name="update"
                                            class="btn btn-primary btn-form mr-2">Submit</button>
                                        <button type="submit" name="delete" class="btn btn-danger">Delete</button>
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