<?php
session_start();
include('../authorize.php');
include('../authorize.php');
include '../config.php';

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$roomid = isset($_GET['roomid']) ? intval($_GET['roomid']) : null;

if ($roomid === null) {
    die("Room ID is missing.");
}
$roomdb = mysqli_query($conn, "SELECT * FROM facilitiespage WHERE ID = $roomid");
if (!$roomdb) {
    die("Query failed: " . mysqli_error($conn));
}
$row = mysqli_fetch_assoc($roomdb);
if (!$row) {
    die("Room not found.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Event = !empty($_POST['Event']) ? $_POST['Event'] : $row['Event'];
    $Info = !empty($_POST['Info']) ? $_POST['Info'] : $row['Info'];
    $imageFile = $_FILES['image'];

    if ($imageFile['error'] === UPLOAD_ERR_OK) {
        $imageTmpPath = $imageFile['tmp_name'];
        $imageName = basename($imageFile['name']);
        $imageSize = $imageFile['size'];
        $imageType = $imageFile['type'];
        $uploadDir = 'uploads/';
        $targetFilePath = $uploadDir . $imageName;

        $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($imageType, $allowedFileTypes) && $imageSize > 0) {
            if (move_uploaded_file($imageTmpPath, $targetFilePath)) {
                $sql = "UPDATE facilitiespage SET Event = ?, Info = ?, ImagePath = ? WHERE ID = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "sssi", $Event, $Info, $targetFilePath, $roomid);
            } else {
                echo "Error uploading the image.";
            }
        } else {
            echo "Invalid file type. Only JPG, PNG, and GIF files are allowed.";
        }
    } else {
        $sql = "UPDATE facilitiespage SET Event = ?, Info = ? WHERE ID = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ssi", $Event, $Info, $roomid);
    }

    if (isset($stmt) && mysqli_stmt_execute($stmt)) {
        header("Location: " . $_SERVER['PHP_SELF'] . "?roomid=" . $roomid);
        exit();
    } else {
        echo "Error updating record: " . mysqli_error($conn);
    }

    if (isset($stmt)) {
        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
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
                            <div class="photo-content">
                                <div class="cover-photo"
                                    style="background-image: url(<?php echo $row['ImagePath']; ?>)!important"></div>
                            </div>
                            <div class="card-body">
                                <h4 class="card-title mb-4">Facilities - Weddings</h4>
                                <div class="basic-form">
                                    <form method="POST" enctype="multipart/form-data">
                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Upload File:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="file" class="form-control" name="image" id="image"
                                                        aria-describedby="inputGroupPrepend2">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label class="col-sm-3 col-form-label text-label">Placeholder:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <input type="text" class="form-control" name="Event" id="Event"
                                                        placeholder="<?php echo htmlspecialchars($row['Event']); ?>"
                                                        aria-describedby="validationDefaultUsername2">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label text-label">Description:</label>
                                            <div class="col-sm-9">
                                                <div class="input-group">
                                                    <textarea class="form-control" id="Info" name="Info" rows="6"
                                                        placeholder="<?php echo htmlspecialchars($row['Info']); ?>"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-form mr-2">Submit</button>
                                        <button type="button" class="btn btn-light text-dark btn-form">Cancel</button>
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