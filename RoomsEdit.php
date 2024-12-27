<?php
include('Connection/PDOcon.php');
$roomdb = $conn->query("SELECT *  FROM `room`");

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if Form is Submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = 1;         // Retrieve ID from the form input
        $subTxt = $_POST['subTxt'];     // Retrieve name from the form input
        $FBname = $_POST['FBname'];     // Retrieve info from the form input

        // Prepare the SQL Update Statement
        $sql = "UPDATE homepage SET subTxt = :subTxt, FBname = :FBname WHERE ID = :ID";

        // Prepare the Query Using Prepared Statements
        $stmt = $conn->prepare($sql);

        // Bind Parameters
        $stmt->bindParam(':ID', $id);
        $stmt->bindParam(':subTxt', $subTxt);
        $stmt->bindParam(':FBname', $FBname);

        // Execute the Statement
        if ($stmt->execute()) {
            echo "Record updated successfully!";
        } else {
            echo "Error updating record.";
        }
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the Connection
$conn = null;
?>


<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Almaris — Hotel Website Template</title>
    <link rel="icon" href="images/icon.png" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Almaris — Hotel Website Template" name="description">
    <meta content="" name="keywords">
    <meta content="" name="author">
    <!-- CSS Files
    ================================================== -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="css/plugins.css" rel="stylesheet" type="text/css">
    <link href="css/swiper.css" rel="stylesheet" type="text/css">
    <link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="css/coloring.css" rel="stylesheet" type="text/css">
    <!-- color scheme -->
    <link id="colors" href="css/colors/scheme-01.css" rel="stylesheet" type="text/css">

</head>

<body>
    <div id="wrapper">
        <a href="#" id="back-to-top"></a>

        <!-- page preloader begin -->
        <div id="de-loader"></div>
        <!-- page preloader close -->

        <!-- header begin -->
        <header class="transparent has-topbar">
            <div id="topbar">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="d-flex justify-content-between xs-hide">
                                <div class="header-widget d-flex">
                                    <div class="topbar-widget"><a href="#"><i class="icofont-location-pin"></i>Emilio
                                            Aguinaldo Highway, Dasmariñas, Philippines, 4114</a></div>
                                    <div class="topbar-widget"><a href="#"><i class="icofont-phone"></i>0917 808
                                            7127</a></div>
                                    <div class="topbar-widget"><a href="#"><i
                                                class="icofont-envelope"></i>quatropasoshotel@gmail.com</a></div>
                                </div>

                                <div class="social-icons">
                                    <a href="#"><i class="fa-brands fa-facebook fa-lg"></i></a>
                                    <a href="#"><i class="fa-brands fa-x-twitter fa-lg"></i></a>
                                    <a href="#"><i class="fa-brands fa-youtube fa-lg"></i></a>
                                    <a href="#"><i class="fa-brands fa-pinterest fa-lg"></i></a>
                                    <a href="#"><i class="fa-brands fa-instagram fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de-flex sm-pt10">
                            <div class="de-flex-col">
                                <!-- logo begin -->
                                <div id="logo">
                                    <a href="default.php">
                                        <img class="logo-main" src="images/logo-white.png" alt="">
                                        <img class="logo-mobile" src="images/logo-white.png" alt="">
                                    </a>
                                </div>
                                <!-- logo close -->
                            </div>
                            <div class="de-flex-col header-col-mid">
                                <ul id="mainmenu">
                                    <li><a class="menu-item" href="index.php">Home</a></li>
                                    <li><a class="menu-item" href="RoomsEdit.php">Accomodation</a></li>
                                    <li><a class="menu-item" href="FacilitiesEdit.php">Facilities</a></li>
                                </ul>
                            </div>
                            <div class="de-flex-col">
                                <div class="menu_side_area">
                                    <a href="AuthAndStatusPages/login.php" class="btn-main btn-line">Login</a>
                                    <span id="menu-btn"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">

            <div id="top"></div>

            <section id="subheader" class="relative jarallax text-light">
                <img src="images/background/3.webp" class="jarallax-img" alt="">
                <div class="container relative z-index-1000">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h1>Rooms - CMS</h1>
                            <p class="mt-3 lead">Ready to elevate your travel experience? Reserve your room now and step
                                into a world of comfort and luxury. Your perfect stay is just a click away.</p>
                        </div>
                    </div>
                </div>
                <div class="de-overlay"></div>
            </section>

            <section id="section_form" class="relative lines-deco">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div id="success_message" class="text-center">
                                <h2>Your reservation has been sent successfully.</h2>
                                <div class="col-lg-8 offset-lg-2">
                                    <p>We will contact you shortly. Refresh this page if you want to make another
                                        reservation.</p>

                                    <img src="images/misc/2.webp" class="w-100 rounded-up-100" alt="">
                                </div>
                            </div>

                            <div id="booking_form">
                                <div id="step-2" class="row">
                                    <?php while ($row = $roomdb->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <a href="RoomsEdit2.php?roomid=<?php echo $row["id"] ?>">
                                        <div class="col-md-12" style="text-align:center">
                                            <?php echo $row["type"] ?>
                                        </div>
                                    </a>
                                    <?php } ?>
                                </div>
                                <a href="RoomsAdd.php">
                                    <div style="border-style: solid; border-width: 1px; text-align:center">Add Room
                                    </div>
                                </a>
                                <div id='error_message' class='error'>Sorry, error occured this time sending your
                                    message.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- content close -->

        <!-- footer begin -->
        <footer class="text-light section-dark">
            <div class="container">
                <div class="row g-4 align-items-center">
                    <div class="col-md-12">
                        <div class="d-lg-flex align-items-center justify-content-between text-center">
                            <div>
                                <h3 class="fs-20">Address</h3>
                                Emilio Aguinaldo Highway,<br>
                                Dasmariñas, Philippines, 4114
                            </div>
                            <div>
                                <img src="images/logo-white.webp" class="w-200px" alt=""><br>
                                <div class="social-icons mb-sm-30 mt-4">
                                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                                    <a href="#"><i class="fa-brands fa-twitter"></i></a>
                                    <a href="#"><i class="fa-brands fa-youtube"></i></a>
                                </div>

                            </div>
                            <div>
                                <h3 class="fs-20">Contact Us</h3>
                                T. +929 333 9296<br>
                                M. contact@almaris.com
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="subfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            Copyright 2024 - Quatro Pasos Hotel
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer close -->
    </div>



    <!-- Javascript Files
    ================================================== -->
    <script src="js/plugins.js"></script>
    <script src="js/designesia.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <script src="form.js"></script>

</body>

</html>