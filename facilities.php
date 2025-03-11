<?php
include('Connection/PDOcon.php');
session_start(); // Start the session

?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Quatro Pasos - Facilities</title>
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
                                    <li><a class="menu-item" href="default.php">Home</a></li>
                                    <li><a class="menu-item" href="rooms.php">Accomodation</a></li>
                                    <li><a class="menu-item" href="facilities.php">Facilities</a></li>
                                </ul>
                            </div>
                            <div class="de-flex-col">
                                <div class="menu_side_area">
                                    <?php if (isset($_SESSION['user_name'])): ?>
                                    <a href="profile.php"
                                        class="btn-main btn-line"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                                    <!-- Show user name -->

                                    <?php endif; ?>
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
                <img src="images/background/mixed-1.webp" class="jarallax-img" alt="">
                <div class="container relative z-index-1000">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h1>Facilities</h1>
                            <p class="lead mt-3">Take advantage of our exceptional facilities. From relaxation to
                                recreation, we have everything you need for an unforgettable stay.</p>

                        </div>
                    </div>
                </div>
                <div class="de-overlay"></div>
            </section>

            <section class="relative lines-deco">
                <div class="container">
                    <div class="row g-0 align-items-center justify-content-center">
                        <div class="col-lg-5">
                            <div class="relative wow fadeInUp" data-wow-delay=".3s">
                                <div class="shape-mask-1 jarallax">
                                    <img src="admin/main/template/uploads/1.jpg" class="jarallax-img" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="ms-lg-5 wow scaleIn">
                                <h2 class="wow fadeInUp">Weddings</h2>
                                <p>Our hotel offers a beautiful and elegant space perfect for your wedding. With
                                    stunning surroundings, cozy rooms, delicious food, and excellent amenities, we have
                                    everything you need for your special day. Celebrate your love with us!</p>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0 align-items-center justify-content-center">
                        <div class="col-lg-5">
                            <div class="me-lg-5 wow scaleIn">
                                <h2 class="wow fadeInUp">Wellness Event</h2>
                                <p>Our hotel has a peaceful space perfect for your wellness event. With calm
                                    surroundings, bright rooms, cozy accommodations, and healthy food, we have
                                    everything you need for a relaxing experience. Find peace with us.</p>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="relative wow fadeInUp" data-wow-delay=".3s">
                                <div class="shape-mask-2 jarallax">
                                    <img src="admin/main/template/uploads/3.jpg" class="jarallax-img" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row g-0 align-items-center justify-content-center">
                        <div class="col-lg-5">
                            <div class="relative wow fadeInUp" data-wow-delay=".3s">
                                <div class="shape-mask-1 jarallax">
                                    <img src="admin/main/template/uploads/bdays.jpg" class="jarallax-img" alt="">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-5">
                            <div class="ms-lg-5 wow scaleIn">
                                <h2 class="wow fadeInUp">Birthdays</h2>
                                <p>Our hotel has a fun and welcoming space perfect for your birthday celebration. With
                                    comfortable rooms, tasty food, and great amenities, we have everything you need for
                                    a memorable party. Celebrate with us!</p>
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
    <script src="js/swiper.js"></script>
    <script src="js/custom-marquee.js"></script>
    <script src="js/custom-swiper-1.js"></script>

</body>

</html>