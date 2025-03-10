<?php
require 'vendor/autoload.php'; // Ensure this line is at the very top
include('Connection/SQLIcon.php');

use GuzzleHttp\Client; // Import the Guzzle Client
use Paymongo\SourceError; // Import the SourceError class

// Initialize Guzzle HTTP client
$client = new Client();
$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;

// Prepare the SQL statement to fetch booking info
$sql = "SELECT start_date, end_date, RoomType, num_adults, num_children, Price FROM bookings WHERE id = ?";

// Use prepared statement to prevent SQL injection
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $booking_id); // 'i' stands for integer

    // Execute the statement
    if ($stmt->execute()) {
        // Bind result variables
        $stmt->bind_result($start_date, $end_date, $RoomType, $num_adults, $num_children, $Price);

        // Fetch the data
        if ($stmt->fetch()) {
            // Store data in an associative array
            $booking_data = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'RoomType' => $RoomType,
                'num_adults' => $num_adults,
                'num_children' => $num_children,
                'Price' => $Price

            ];
        } else {
            echo "<p class='error'>No booking found with the provided Booking ID.</p>";
        }
    } else {
        echo "<p class='error'>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();  // Close the SELECT statement to avoid "commands out of sync" error
} else {
    echo "<p class='error'>Error: " . $conn->error . "</p>";
}

// Handle form submission for image upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image']) && $booking_id) {
    // Validate the uploaded file
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    $max_size = 2 * 1024 * 1024; // 2 MB

    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $image_type = mime_content_type($image_tmp_name);
        $image_size = $_FILES['image']['size'];

        // Check file type and size
        if (in_array($image_type, $allowed_types) && $image_size <= $max_size) {
            // Unique filename to prevent overwriting
            $unique_name = uniqid('img_') . '_' . $image_name;
            $image_path = 'uploads/' . $unique_name;

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                // Prepare SQL statement to update booking record with image path
                $update_sql = "UPDATE bookings SET payment_image = ? WHERE id = ?";
                if ($update_stmt = $conn->prepare($update_sql)) {
                    $update_stmt->bind_param("si", $image_path, $booking_id);
                    if ($update_stmt->execute()) {
                        // Redirect to another page with the booking ID
                        $url = "Reserve-Complete.php?booking_id=" . $booking_id;
                        header("Location: " . $url);
                    } else {
                        echo "<p class='error'>Error updating record: " . $update_stmt->error . "</p>";
                    }
                    $update_stmt->close();  // Close the UPDATE statement
                } else {
                    echo "<p class='error'>Error preparing statement: " . $conn->error . "</p>";
                }
            } else {
                echo "<p class='error'>Error moving uploaded file.</p>";
            }
        } else {
            echo "<p class='error'>Invalid file type or file is too large. Only JPEG, PNG, and GIF files under 2MB are allowed.</p>";
        }
    } else {
        echo "<p class='error'>Error uploading file.</p>";
    }
}

// Close the database connection
$conn->close();


// payment Code
try {
    $price = $booking_data['Price'];
    $cleanedNumber = str_replace(',', '', $price);

    // Step 2: Convert to integer
    $integerNumber = intval($cleanedNumber); // or you can use (int)$cleanedNumber;
    $FinalPrice = $integerNumber * 100;

    // Create a payment link
    $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
        'body' => json_encode([
            'data' => [
                'attributes' => [
                    'amount' => $FinalPrice, // Amount in centavos (10000 = PHP 100.00)
                    'description' => 'Payment For QuatroPasos',
                    'remarks' => 'Muyaww',
                ]
            ]
        ]),
        'headers' => [
            'accept' => 'application/json',
            'authorization' => 'Basic c2tfdGVzdF9WWUhROVpGS0g3eG9lVWpkcEVteHQ5U2I6', // Use your actual API key
            'content-type' => 'application/json',
        ],
    ]);

    // Get the response body
    $responseBody = json_decode($response->getBody(), true);

    // Check if the response contains a checkout URL
    if (isset($responseBody['data']['attributes']['checkout_url'])) {
        $paymentLink = $responseBody['data']['attributes']['checkout_url'];
    } else {
        throw new Exception("Payment link not found in response.");
    }
    
} catch (\GuzzleHttp\Exception\RequestException $e) {
    // Handle any request exceptions
    echo "Request Error: " . $e->getMessage();
    exit;
} catch (SourceError $e) {
    // Handle SourceError specifically
    echo "Source Error: Pointer - " . $e->pointer . ", Attribute - " . $e->attribute;
} catch (Exception $e) {
    // Handle any other errors
    echo "Error: " . $e->getMessage();
    exit;
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Almaris — Hotel Website Template</title>
    <link rel="icon" href="images/icon.png" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" >
    <meta content="Almaris — Hotel Website Template" name="description" >
    <meta content="" name="keywords" >
    <meta content="" name="author" >
    <!-- CSS Files
    ================================================== -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" id="bootstrap">
    <link href="css/plugins.css" rel="stylesheet" type="text/css" >
    <link href="css/swiper.css" rel="stylesheet" type="text/css" >
    <link href="css/style.css" rel="stylesheet" type="text/css" >
    <link href="css/coloring.css" rel="stylesheet" type="text/css" >
    <!-- color scheme -->
    <link id="colors" href="css/colors/scheme-01.css" rel="stylesheet" type="text/css" >

    <style>
        .booking-form {
        width: 100%;
        max-width: 900px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .booking-form h2 {
        margin-top: 0;
        }

        .booking-form label {
        font-weight: bold;
        }

        .booking-form input, .booking-form button {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #ddd;
        border-radius: 5px;
        }

        .room-selection {
        display: flex;
        gap: 10px;
        margin: 10px 0;
        }

        .room-selection button {
        padding: 15px;
        font-size: 16px;
        border: 2px solid #007bff;
        background-color: white;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        }

        .room-selection button.selected {
        background-color: #007bff;
        color: white;
        }

        .booking-form button.submit-btn {
        background-color: #007bff;
        color: white;
        font-size: 1.2rem;
        cursor: pointer;
        }

        .message {
        margin-bottom: 20px;
        color: green;
        }

        .error {
        color: red;
        }

        /* Forms */

        h1 {
            font-size: 1.5em;
        }

        form {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            max-width: 800px;
        }

        label {
            display: block;
            font-size: 1em;
            margin-bottom: 5px;
        }

        input, select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .full-width {
            grid-column: span 3;
        }

        .half-width {
            grid-column: span 1;
        }

        .message {
                margin-bottom: 20px;
                color: green;
            }

        .error {
            color: red;
        }
    
        section.lines-deco:after {
            content: none;
        }
        section.lines-deco:before {
            content: none;
        }

    </style>

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
                                    <div class="topbar-widget"><a href="#"><i class="icofont-location-pin"></i>Emilio Aguinaldo Highway, Dasmariñas, Philippines, 4114</a></div>
                                    <div class="topbar-widget"><a href="#"><i class="icofont-phone"></i>0917 808 7127</a></div>
                                    <div class="topbar-widget"><a href="#"><i class="icofont-envelope"></i>quatropasoshotel@gmail.com</a></div>
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
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de-flex sm-pt10">
                            <div class="de-flex-col">
                                <!-- logo begin -->
                                <div id="logo">
                                    <a href="default.php">
                                        <img class="logo-main" src="images/logo-white.png" alt="" >
                                        <img class="logo-mobile" src="images/logo-white.png" alt="" >
                                    </a>
                                </div>
                                <!-- logo close -->
                            </div>
                            <div class="de-flex-col header-col-mid">
                                <ul id="mainmenu">
                                    <li><a class="menu-item" href="index.php">Home</a></li>
                                    <li><a class="menu-item" href="rooms.php">Accomodation</a></li>
                                    <li><a class="menu-item" href="facilities.php">Facilities</a></li>
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
                <img src="images/background/1.webp" class="jarallax-img" alt="">
                <div class="container relative z-index-1000">
                    <div class="row justify-content-center">
                        <div class="col-lg-6 text-center">
                            <h1>Reservation</h1>
                            
                        </div>
                    </div>
                </div>
                <div class="de-overlay"></div>
            </section>



            <section class="relative lines-deco" style="padding: 40px 0;">
            <div class="container" style="display: flex; flex-direction: column; align-items: center;">
                <div class="booking-form">
                
                <h2>Complete Your Payment</h2>
                <p>Click the button below to proceed with your payment.</p>
                
                <form  method="POST" enctype="multipart/form-data">
                    <label>Booking ID</label>
                    <label>Start Date</label>
                    <label>End Date</label>

                    <input type="text" placeholder="<?php echo htmlspecialchars($booking_id); ?>" readonly>
                    <input type="text" placeholder="<?php echo htmlspecialchars($booking_data['start_date']); ?>" readonly>
                    <input type="text" placeholder="<?php echo htmlspecialchars($booking_data['end_date']); ?>" readonly>

                    <label>Room Type</label>
                    <label>Numeber of Adults</label>
                    <label>Numeber of Adults</label>

                    <input type="text" placeholder="<?php echo htmlspecialchars($booking_data['RoomType']); ?>" readonly>                        
                    <input type="text" placeholder="<?php echo htmlspecialchars($booking_data['num_adults']); ?>" readonly>
                    <input type="text" placeholder="<?php echo htmlspecialchars($booking_data['num_children']); ?>" readonly>

                    <label>Price</label>
                    <label></label>
                    <label></label>
            
                    <input type="text" placeholder="<?php echo htmlspecialchars($booking_data['Price']); ?>" readonly>

                
                </form>

                <!-- Payment Button -->
                
                <button type="button" onclick="openPaymentLink()">
                    Pay PHP <?php echo htmlspecialchars($booking_data['Price']); ?>.00
                </button>
                
                    
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
     <!-- Javascript for form validation and confirmation -->
     <script>
            function openPaymentLink() {
                // Define the payment link from PHP
                var paymentLink = '<?php echo htmlspecialchars($paymentLink); ?>';
                
                // Open the payment link in a new tab
                window.open(paymentLink, '_blank');
                
                // Change the current tab's URL (you can change this to your desired URL)
                var bookingId = '<?php echo $booking_id; ?>';
                window.location.href = 'Reserve-Complete.php?booking_id=' + bookingId;
            }

            function validateForm() {
                const imageInput = document.getElementById('image');
                if (!imageInput.files.length) {
                    alert('Please upload a payment screenshot.');
                    return false;
                }

                // Confirmation popup
                const confirmUpload = confirm('You have uploaded an image. Do you want to proceed with the submission?');
                return confirmUpload; // Proceed if user confirms
            }
        </script>


</body>

</html>