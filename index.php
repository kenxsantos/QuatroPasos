<?php
include('Connection/PDOcon.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// getting DB of Basic Homepage Info
$stmt = $pdo->query("SELECT * FROM `homepage` WHERE `ID` = 1 ");
$row = $stmt->fetch(PDO::FETCH_ASSOC);

// getting DB of Contacts Info
// $stmt2 = $pdo->query("SELECT *  FROM `contacts` WHERE `ID` = 1 ");
// $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);

// getting DB of Contacts Info


// getting DB of Contacts Info
$stmt4 = $pdo->query("SELECT *  FROM `room` ");

$stmt = $pdo->query("SELECT * FROM `homepage` WHERE `ID` = 1 ");
$promo = $stmt->fetch(PDO::FETCH_ASSOC);


session_start(); // Start the session

?>

<!DOCTYPE html>

<head>
    <title>Quatro Pasos Website</title>
    <link rel="icon" href="images/icon.png" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Quatro Pasos Website" name="description">
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
    <!-- custom css -->
    <link id="colors" href="css/custom-bold.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
    </script>
    <style>
        /* Modal Background */

        .popup {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            /* Semi-transparent background */
            z-index: 1000;
            /* Ensure it appears above other elements */
        }

        /* Modal Content */
        .popup-content {
            position: relative;
            margin: 15% auto;
            /* Centered vertically */
            padding: 20px;
            width: 80%;
            max-width: 400px;
            /* Limit maximum width */
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        /* Close Button */
        #close-popup {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }

        /* Button Style */
        .btn-main {
            display: inline-block;
            padding: 10px 20px;
            margin-top: 15px;
            text-decoration: none;
            border-radius: 5px;
            background-color: #FEB46B;
        }

        .navpromo {
            background-color: #FEB46B;
            padding-left: 20px;
        }

        .floating-button {
            position: fixed;
            bottom: 80px;
            right: 20px;
            background-color: #FEB46B;
            color: white;
            border: none;
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            font-size: 20px;
            cursor: pointer;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
            z-index: 9999;
        }

        .floating-button:hover {
            background-color: #0056b3;
            transform: scale(1.1);
        }
    </style>
</head>

<body>
    <div id="wrapper">
        <a href="#" id="back-to-top"></a>

        <!-- page preloader begin -->
        <div id="de-loader"></div>
        <!-- page preloader close -->
        <div>
            <a href="./user/user_chat.php" class="floating-button" title="Help or Action">
                <i class="fa-solid fa-comment-dots"></i>
            </a>
        </div>

        <!-- header begin -->
        <header class="transparent has-topbar logo-center">
            <div id="topbar">
                <div class="container-fluid px-lg-5 px-3">
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
                                    <a href="#"><i class="fa-brands fa-instagram fa-lg"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>

            <div class="container-fluid px-lg-5 px-3">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="de-flex">
                            <div class="col-start">
                                <ul id="mainmenu">
                                    <li><a class="menu-item" href="#section-intro">HOME</a></li>
                                    <li><a class="menu-item" href="rooms.php">ACCOMODATION</a></li>
                                    <li><a class="menu-item" href="facilities.php">FACILITIES</a></li>
                                    <li><a class="menu-item" href="promo.php">PROMO</a></li>
                                </ul>
                            </div>
                            <div class="col-center">
                                <a href="index.php"><img src="images/logo-white.png" alt=""></a>
                            </div>
                            <div class="col-end">
                                <div class="menu_side_area">
                                    <div class="menu_side_area">
                                        <?php if (isset($_SESSION['user_name'])): ?>
                                            <a href="./user/profile.php"
                                                class="btn-main btn-line"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                                            <!-- Show user name -->
                                        <?php else: ?>
                                            <a href="AuthAndStatusPages/login.php">
                                                <button type="button"
                                                    style="border: 2px solid #FEB46B; color: #FEB46B; background-color: transparent; border-radius: 5px; padding: 10px 20px; font-size: 14px; cursor: pointer; font-weight: bold;">
                                                    BOOK NOW
                                                </button>
                                            </a>

                                            <!-- Show login if not logged in -->
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header close -->

        <!-- Promo Popup -->
        <?php if ($promo['showPromo'] == 1): ?>
            <div id="promo-popup" class="popup">
                <div class="popup-content">
                    <span id="close-popup">&times;</span>
                    <h2>Special Offer!</h2>
                    <p>Don't miss our limited-time promotion. Book now and enjoy exclusive discounts!</p>
                    <a href="Reserve.php" class="btn-main">Book Now</a>
                </div>
            </div>
            <script>
                document.getElementById("close-popup").onclick = function() {
                    document.getElementById("promo-popup").style.display = "none";
                };
            </script>
        <?php endif; ?>
        <!-- Promo Popup close-->

        <!-- content begin -->
        <div class="no-bottom no-top" id="content">

            <div id="top"></div>

            <section id="section-intro"
                class="section-dark text-light no-top no-bottom position-relative overflow-hidden z-1000">
                <div class="v-center relative">

                    <div class="abs abs-centered z-1000 w-100">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-lg-12 text-center">
                                    <img src="images/logo-white.png">
                                    <p class="lead wow fadeInUp" data-wow-delay=".6s"><?php echo $row["subTitle"]; ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="abs bottom-0 z-1000 w-100 xs-hide d-flex justify-content-center align-items-center">
                        <div class="container-fluid p-lg-5 p-3">
                            <div class="row justify-content-center">
                                <div class="col-lg-12">
                                    <div class="bg-blur padding40 py-4 wow fadeInDown text-center" data-wow-delay=".9s">
                                        <div class="row g-4 align-items-center justify-content-center">
                                            <div class="col-lg-3">
                                                <?php if (isset($_SESSION['user_name'])): ?>
                                                    <a class="btn-main" href="Reserve.php">Check Availability</a>
                                                <?php else: ?>
                                                    <a class="btn-main" href="AuthAndStatusPages/login.php">Check
                                                        Availability</a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="swiper">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                            <!-- Slides -->
                            <div class="swiper-slide">
                                <div class="swiper-inner" data-bgimage="url(images/slider/QuatroSlides/1.jpg)">
                                    <div class="sw-overlay op-2"></div>
                                </div>
                            </div>
                            <!-- Slides -->

                            <!-- Slides -->
                            <div class="swiper-slide">
                                <div class="swiper-inner" data-bgimage="url(images/slider/QuatroSlides/2.jpg)">
                                    <div class="sw-overlay op-2"></div>
                                </div>
                            </div>
                            <!-- Slides -->

                            <!-- Slides -->
                            <div class="swiper-slide">
                                <div class="swiper-inner" data-bgimage="url(images/slider/QuatroSlides/3.jpg)">
                                    <div class="sw-overlay op-2"></div>
                                </div>
                            </div>
                            <!-- Slides -->

                        </div>

                    </div>
                </div>
            </section>

            <section id="section-rooms" class="px-2 no-bottom pt30">
                <div class="container-fluid relative z-2">
                    <div class="row g-4">
                        <div class="col-lg-8 offset-lg-2 text-center"><br><br><br><br><br>
                            <div class="subtitle id-color wow fadeInUp">Our Rooms</div>
                            <h2 class="wow fadeInUp mb-4">Accomodation</h2>
                        </div>
                    </div>

                    <div class="row g-2">
                        <!-- room begin -->
                        <?php $count = 0; // Initialize counter
                        while ($count < 3 && ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC))) { // Check if counter is less than 3
                            $count++; ?>

                            <div class="col-lg-4"><a href="rooms.php">
                                    <div class="hover relative text-light text-center wow fadeInUp" data-wow-delay=".3s">
                                        <img src="admin/main/template/<?php echo htmlspecialchars($row4["img"]); ?>"
                                            class="w-100" alt="">
                                        <div class="abs hover-op-1 z-4 hover-mt-40 abs-centered text-dark">
                                            <div class="fs-14">Starts at</div>
                                            <h3 class="fs-40 lh-1 mb-4 text-dark">
                                                <?php echo htmlspecialchars($row4["Price"]); ?></h3>
                                        </div>
                                        <div class="abs bg-light z-2 top-0 w-100 h-100 hover-op-1"></div>
                                        <div class="abs py-3 z-2 bottom-0 w-100 text-center hover-op-0">
                                            <h3 class="mb-0"><?php echo htmlspecialchars($row4["type"]); ?></h3>
                                            <div class="text-center fs-14">
                                                <span class="mx-2">
                                                    <?php echo htmlspecialchars($row4["Pax"]);  ?> Guests
                                                </span>
                                            </div>
                                        </div>
                                        <div class="gradient-trans-color-bottom abs w-100 h-40 bottom-0"></div>
                                    </div>
                                </a>
                            </div>

                        <?php } ?>
                        <!-- room end -->
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
                                Emilio Aguinaldo Highway<br>
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
    <script src="js/swiper.js"></script>
    <script src="js/custom-marquee.js"></script>
    <script src="js/custom-swiper-3.js"></script>
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>
    <script src="contact.js"></script>
    <script>
        // Display the popup
        function showPopup() {
            document.getElementById("promo-popup").style.display = "block";
        }

        // Close the popup when the "X" button is clicked
        document.getElementById("close-popup").onclick = function() {
            document.getElementById("promo-popup").style.display = "none";
        }

        // Optionally, close the modal if the user clicks outside of it
        window.onclick = function(event) {
            if (event.target == document.getElementById("promo-popup")) {
                document.getElementById("promo-popup").style.display = "none";
            }
        }

        // To show the popup automatically after a delay, you can use:
        window.onload = function() {
            setTimeout(showPopup, 2000); // Show after 2 seconds
        };
    </script>

</body>

</html>