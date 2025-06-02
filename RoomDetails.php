<?php
// Fetch data from URL
include('./Connection/PDOcon.php');
$type = isset($_GET['type']) ? $_GET['type'] : 'Unknown';
$price = isset($_GET['price']) ? $_GET['price'] : 'N/A';
$pax = isset($_GET['pax']) ? $_GET['pax'] : 'N/A';
$img = isset($_GET['img']) ? $_GET['img'] : '';



$stmt = $pdo->prepare("SELECT virtual_tour FROM room WHERE type = ?");
$stmt->execute([$type]);
$images = $stmt->fetchAll(PDO::FETCH_COLUMN);

?>


<!DOCTYPE html>
<html>

<head>
    <title>Quatro Pasos Website</title>
    <link rel="icon" href="images/icon.webp" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Quatro Pasos Website" name="description">
    <meta content="" name="keywords">
    <meta content="" name="author">
    <!-- CSS Files
    ================================================== -->
    <link href='css/bootstrap.min.css' rel='stylesheet' type='text/css' id='bootstrap'>
    <link href='css/plugins.css' rel='stylesheet' type='text/css'>
    <link href='css/swiper.css' rel='stylesheet' type='text/css'>
    <link href='css/style.css' rel='stylesheet' type='text/css'>
    <link href='css/coloring.css' rel='stylesheet' type='text/css'>
    <!-- color scheme -->
    <link id='colors' href='css/colors/scheme-01.css' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/core/index.min.css" />

</head>

<body>
    <div id="wrapper">
        <a href="#" id="back-to-top"></a>

        <!-- page preloader begin -->
        <div id="de-loader"></div>
        <!-- page preloader close -->
        <!-- content begin -->
        <header>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='de-flex sm-pt10'>
                        <div class='de-flex-col'>
                            <ul id="mainmenu">
                                <li>
                                    <a class="menu-item" href="javascript:history.back()"
                                        style="display: flex; align-items: center; gap: 8px;">
                                        <img src="images/icons/back.png" alt="Back" width="20px">
                                        <span>Back</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </header>
        <div class="no-bottom no-top" id="content">
            <section class="pt70 sm-pt-40 no-bottom">
                <div>
                    <?php if (count($images) > 1): ?>
                    <div class="d-flex flex-wrap gap-2 justify-content-center mb-4">
                        <?php foreach ($images as $index => $path): ?>
                        <img src="<?php echo $path; ?>" class="rounded" onclick="loadPanorama(<?php echo $index; ?>)">
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>
                    <div id="viewer" style="width: 100%; height: 800px;"></div>
                </div>
            </section>


            <section>
                <div class="container">
                    <div class="row g-4 gx-5">
                        <div class="col-lg-7">
                            <h1><?php echo $type; ?></h1>
                            <h3>Php <?php echo $price; ?></h3>


                            <div class="d-flex">
                                <div class="relative me-4">
                                    <img src="images/icons/guests.png" class="w-20px abs mt-1" alt="">
                                    <p class="ml30 text-dark fw-500">2 Adult</p>
                                </div>
                                <div class="relative me-4">
                                    <img src="images/icons/guests.png" class="w-20px abs mt-1" alt="">
                                    <p class="ml30 text-dark fw-500">2 Child</p>
                                </div>

                                <div class="relative me-4">
                                    <img src="images/icons/size.png" class="w-20px abs mt-1" alt="">
                                    <p class="ml30 text-dark fw-500">35 Feets Size</p>
                                </div>

                                <div class="relative me-4">
                                    <img src="images/icons/bed.png" class="w-20px abs mt-1" alt="">
                                    <p class="ml30 text-dark fw-500">1 King Bed</p>
                                </div>
                            </div>

                            <p>Ea sunt tempor dolor id do nisi est sint culpa in eiusmod sed aliqua elit nisi nulla
                                mollit proident minim commodo aute elit ut mollit velit exercitation cillum quis sed
                                dolore quis laboris nostrud exercitation magna anim aliquip exercitation est
                                reprehenderit labore officia dolore eu non in do exercitation deserunt tempor aliqua
                                enim esse ex deserunt magna in esse nostrud deserunt.</p>

                            <div class="spacer-single"></div>
                            <h3 class="mb-2">Room Details Prices</h3>
                            <ul class="ul-style-2">
                                <li><strong>Day/Night Use</strong>: Php 1,200</li>
                                <li><strong>Night Use with Breakfast</strong>: Php 1,500</li>
                                <li><strong>Overnight Use</strong>: Php 1,880</li>
                                <li><strong>Overnight Use with Breakfast</strong>: Php 2,180</li>
                                <li><strong>Extra Person</strong>: Php 800</li>
                            </ul>

                            <div class="spacer-single"></div>

                            <h3 class="mb-2">Room Features</h3>
                            <ul class="ul-style-2">
                                <li><strong>Wi-Fi</strong>: Complimentary High-Speed Wi-Fi</li>
                                <li><strong>Entertainment</strong>: 50-inch Flat-Screen TV with Cable and Satellite</li>
                                <li><strong>Overnight Use</strong>: 2:00 PM - 11:00 AM (21 hours)</li>
                                <li><strong>Day Use</strong>: 8:00 AM - 6:00 PM (10 hours)</li>
                                <li><strong>Night Use</strong>: 8:00 PM - 6:00 AM (10 hours)</li>
                            </ul>
                        </div>


                        <div class="col-lg-5">
                            <div>
                                <h3 class="mb-2">Room Amenities</h3>
                                <div class="row g-2">
                                    <div class="col-lg-4 col-6 fadeInRight" data-wow-delay=".2s">
                                        <div class="p-3 relative">
                                            <img src="images/icons/tv.png" class="w-30px" alt="">
                                            <p class="absolute abs-middle ml50 text-dark fw-500">Cable TV</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-6 fadeInRight" data-wow-delay=".2s">
                                        <div class="p-3 relative">
                                            <img src="images/icons/shower.png" class="w-30px" alt="">
                                            <p class="absolute abs-middle ml50 text-dark fw-500">Shower</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-6 fadeInRight" data-wow-delay=".2s">
                                        <div class="p-3 relative">
                                            <img src="images/icons/safebox.png" class="w-30px" alt="">
                                            <p class="absolute abs-middle ml50 text-dark fw-500">Safebox</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-6 fadeInRight" data-wow-delay=".2s">
                                        <div class="p-3 relative">
                                            <img src="images/icons/wifi.png" class="w-30px" alt="">
                                            <p class="absolute abs-middle ml50 text-dark fw-500">Free WiFi</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-6 fadeInRight" data-wow-delay=".2s">
                                        <div class="p-3 relative">
                                            <img src="images/icons/desk.png" class="w-30px" alt="">
                                            <p class="absolute abs-middle ml50 text-dark fw-500">Work Desk</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-6 fadeInRight" data-wow-delay=".2s">
                                        <div class="p-3 relative">
                                            <img src="images/icons/refrigerator.png" class="w-30px" alt="">
                                            <p class="absolute abs-middle ml50 text-dark fw-500">Refrigerator</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-6 fadeInRight" data-wow-delay=".2s">
                                        <div class="p-3 relative">
                                            <img src="images/icons/balcony.png" class="w-30px" alt="">
                                            <p class="absolute abs-middle ml50 text-dark fw-500">Balcony</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-6 fadeInRight" data-wow-delay=".2s">
                                        <div class="p-3 relative">
                                            <img src="images/icons/bathub.png" class="w-30px" alt="">
                                            <p class="absolute abs-middle ml50 text-dark fw-500">Bathub</p>
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-6 fadeInRight" data-wow-delay=".2s">
                                        <div class="p-3 relative">
                                            <img src="images/icons/city.png" class="w-30px" alt="">
                                            <p class="absolute abs-middle ml50 text-dark fw-500">City View</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                            742 Evergreen Terrace<br>
                            Brooklyn, NY 11201
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
                        Copyright 2024 - Almaris by Designesia
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

    <!-- Import Maps for Modules -->
    <script type="importmap">
        {
  "imports": {
    "three": "https://cdn.jsdelivr.net/npm/three/build/three.module.js",
    "@photo-sphere-viewer/core": "https://cdn.jsdelivr.net/npm/@photo-sphere-viewer/core/index.module.js"
  }
}
</script>

    <!-- Initialize Viewer -->
    <script type="module">
    import {
        Viewer
    } from '@photo-sphere-viewer/core';

    const imagePaths = <?php echo json_encode($images); ?>;
    let currentIndex = 0;

    const viewer = new Viewer({
        container: document.querySelector('#viewer'),
        panorama: imagePaths[currentIndex],
        navbar: ['zoom', 'fullscreen']
    });

    window.loadPanorama = function(index) {
        currentIndex = index;
        viewer.setPanorama(imagePaths[currentIndex]);
    };
    </script>





</body>

</html>