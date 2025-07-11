<?php
require 'vendor/autoload.php';
include('Connection/SQLIcon.php');

use GuzzleHttp\Client;
use Paymongo\SourceError;

session_start(); // Start session
$client = new Client();
$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : null;
$sql = 'SELECT start_date, end_date, room_type, num_adults, num_children, Price, down_payment FROM bookings WHERE id = ?';

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param('i', $booking_id);
    if ($stmt->execute()) {
        $stmt->bind_result($start_date, $end_date, $room_type, $num_adults, $num_children, $Price, $down_payment);
        if ($stmt->fetch()) {
            $booking_data = [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'room_type' => $room_type,
                'num_adults' => $num_adults,
                'num_children' => $num_children,
                'Price' => $Price,
                'down_payment' => $down_payment,
            ];
        } else {
            echo "<p class='error'>No booking found with the provided Booking ID.</p>";
        }
    } else {
        echo "<p class='error'>Error: " . $stmt->error . '</p>';
    }
    $stmt->close();
} else {
    echo "<p class='error'>Error: " . $conn->error . '</p>';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
}

$conn->close();

try {
    $Price = $booking_data['Price'];
    $cleanedNumber = str_replace(',', '', $Price);

    $integerNumber = intval($cleanedNumber);
    $FinalPrice = $integerNumber * 100;

    $response = $client->request('POST', 'https://api.paymongo.com/v1/links', [
        'body' => json_encode([
            'data' => [
                'attributes' => [
                    'amount' => $FinalPrice, // Amount in centavos ( 10000 = PHP 100.00 )
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

    $responseBody = json_decode($response->getBody(), true);
    if (isset($responseBody['data']['attributes']['checkout_url'])) {
        $paymentLink = $responseBody['data']['attributes']['checkout_url'];
    } else {
        throw new Exception('Payment link not found in response.');
    }
} catch (\GuzzleHttp\Exception\RequestException $e) {
    // Handle any request exceptions
    echo 'Request Error: ' . $e->getMessage();
    exit;
} catch (SourceError $e) {
    // Handle SourceError specifically
    echo 'Source Error: Pointer - ' . $e->pointer . ', Attribute - ' . $e->attribute;
} catch (Exception $e) {
    // Handle any other errors
    echo 'Error: ' . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <title>Quatro Pasos Website</title>
    <link rel='icon' href='images/icon.png' type='image/gif' sizes='16x16'>
    <meta content='text/html;charset=utf-8' http-equiv='Content-Type'>
    <meta content='width=device-width, initial-scale=1.0' name='viewport'>
    <meta content='Quatro Pasos Website' name='description'>
    <meta content='' name='keywords'>
    <meta content='' name='author'>
    <!-- CSS Files
===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  == -->
    <link href='css/bootstrap.min.css' rel='stylesheet' type='text/css' id='bootstrap'>
    <link href='css/plugins.css' rel='stylesheet' type='text/css'>
    <link href='css/swiper.css' rel='stylesheet' type='text/css'>
    <link href='css/style.css' rel='stylesheet' type='text/css'>
    <link href='css/coloring.css' rel='stylesheet' type='text/css'>
    <!-- color scheme -->
    <link id='colors' href='css/colors/scheme-01.css' rel='stylesheet' type='text/css'>

    <style>
    button.book-btn {
        padding: 15px;
        font-size: 16px;
        border: 2px solid #007bff;
        background-color: white;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .book-btn.selected {
        background-color: #f3a84a;
        color: white;
    }

    .book-btn:hover {
        background-color: #e69630;
    }


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

    .booking-form input,
    .booking-form button {
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

    input,
    select {
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
    <div id='wrapper'>
        <a href='#' id='back-to-top'></a>

        <!-- page preloader begin -->
        <div id='de-loader'></div>
        <!-- page preloader close -->

        <!-- header begin -->
        <header class='transparent has-topbar'>
            <div id='topbar'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <div class='d-flex justify-content-between xs-hide'>
                                <div class='header-widget d-flex'>
                                    <div class='topbar-widget'><a href='#'><i class='icofont-location-pin'></i>Emilio
                                            Aguinaldo Highway, Dasmariñas, Philippines, 4114</a></div>
                                    <div class='topbar-widget'><a href='#'><i class='icofont-phone'></i>0917 808
                                            7127</a></div>
                                    <div class='topbar-widget'><a href='#'><i
                                                class='icofont-envelope'></i>quatropasoshotel@gmail.com</a></div>
                                </div>

                                <div class='social-icons'>
                                    <a href='#'><i class='fa-brands fa-facebook fa-lg'></i></a>
                                    <a href='#'><i class='fa-brands fa-instagram fa-lg'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='clearfix'></div>
                </div>
            </div>
            <div class='container'>
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='de-flex sm-pt10'>
                            <div class='de-flex-col'>
                                <!-- logo begin -->
                                <div id='logo'>
                                    <a href='index.php'>
                                        <img class='logo-main' src='images/logo-white.png' alt=''>
                                        <img class='logo-mobile' src='images/logo-white.png' alt=''>
                                    </a>
                                </div>
                                <!-- logo close -->
                            </div>
                            <div class='de-flex-col header-col-mid'>
                                <ul id='mainmenu'>
                                    <li><a class='menu-item' href='index.php'>Home</a></li>
                                    <li><a class='menu-item' href='rooms.php'>Accomodation</a></li>
                                    <li><a class='menu-item' href='facilities.php'>Facilities</a></li>
                                </ul>
                            </div>
                            <div class='de-flex-col'>
                                <div class="menu_side_area">
                                    <div class="menu_side_area">
                                        <?php if (isset($_SESSION['user_name'])): ?>
                                        <a href="./user/profile.php"
                                            class="btn-main btn-line"><?php echo htmlspecialchars($_SESSION['user_name']); ?></a>
                                        <!-- Show user name -->
                                        <?php else: ?>
                                        <a href="AuthAndStatusPages/login.php" class="btn-main btn-line">Login</a>
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
        <!-- content begin -->
        <div class='no-bottom no-top' id='content'>

            <div id='top'></div>

            <section id='subheader' class='relative jarallax text-light'>
                <img src='images/background/1.webp' class='jarallax-img' alt=''>
                <div class='container relative z-index-1000'>
                    <div class='row justify-content-center'>
                        <div class='col-lg-6 text-center'>
                            <h1>Reservation</h1>

                        </div>
                    </div>
                </div>
                <div class='de-overlay'></div>
            </section>

            <section class='relative lines-deco' style='padding: 40px 0;'>
                <div class='container' style='display: flex; flex-direction: column; align-items: center;'>
                    <div class='booking-form'>

                        <h2>Complete Your Payment</h2>
                        <p>Click the button below to proceed with your payment.</p>

                        <form method='POST' enctype='multipart/form-data'>
                            <label>Booking ID</label>
                            <label>Start Date</label>
                            <label>End Date</label>

                            <input type='text' placeholder="<?php echo htmlspecialchars($booking_id); ?>" readonly>
                            <input type='text'
                                placeholder="<?php echo htmlspecialchars($booking_data['start_date']); ?>" readonly>
                            <input type='text' placeholder="<?php echo htmlspecialchars($booking_data['end_date']); ?>"
                                readonly>

                            <label>Room Type</label>
                            <label>Number of Adults</label>
                            <label>Number of Children</label>

                            <input type='text' placeholder="<?php echo htmlspecialchars($booking_data['room_type']); ?>"
                                readonly>
                            <input type='text'
                                placeholder="<?php echo htmlspecialchars($booking_data['num_adults']); ?>" readonly>
                            <input type='text'
                                placeholder="<?php echo htmlspecialchars($booking_data['num_children']); ?>" readonly>

                            <label>Price</label>
                            <label></label>
                            <label></label>


                            <input type='text' placeholder="<?php echo htmlspecialchars($booking_data['Price']); ?>"
                                readonly>

                            <input type="hidden" id="room" name="room" required>
                        </form>

                        <!-- Payment Button -->

                        <button type='button' class="submit-btn" onclick='openPaymentLink()'>
                            Pay Down Payment PHP
                            <td><?= htmlspecialchars($booking_data['down_payment']) ?>
                        </button>

                    </div>
                </div>
            </section>
        </div>
        <!-- content close -->

        <!-- footer begin -->
        <footer class='text-light section-dark'>
            <div class='container'>
                <div class='row g-4 align-items-center'>
                    <div class='col-md-12'>
                        <div class='d-lg-flex align-items-center justify-content-between text-center'>
                            <div>
                                <h3 class='fs-20'>Address</h3>
                                Emilio Aguinaldo Highway, <br>
                                Dasmariñas, Philippines, 4114
                            </div>
                            <div>
                                <img src='images/logo-white.webp' class='w-200px' alt=''><br>
                                <div class='social-icons mb-sm-30 mt-4'>
                                    <a href='#'><i class='fa-brands fa-facebook-f'></i></a>
                                    <a href='#'><i class='fa-brands fa-instagram'></i></a>
                                </div>

                            </div>
                            <div>
                                <h3 class='fs-20'>Contact Us</h3>
                                T. +929 333 9296<br>
                                M. contact@almaris.com
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class='subfooter'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-md-12 text-center'>
                            Copyright 2024 - Almaris by Designesia
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer close -->
    </div>

    <!-- Javascript Files
===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  ===  == -->
    <script src='js/plugins.js'></script>
    <script src='js/designesia.js'></script>
    <script src='js/swiper.js'></script>
    <script src='js/custom-marquee.js'></script>
    <script src='js/custom-swiper-1.js'></script>
    <!-- Javascript for form validation and confirmation -->
    <script>
    const roomInput = document.getElementById('room');


    function openPaymentLink() {
        var paymentLink = '<?php echo htmlspecialchars($paymentLink); ?>';

        window.open(paymentLink, '_blank');
        var bookingId = '<?php echo trim($booking_id); ?>'; // Trim to remove spaces
        window.location.href = 'Reserve-Complete.php?booking_id=' + encodeURIComponent(bookingId);
    }


    function validateForm() {
        const imageInput = document.getElementById('image');
        if (!imageInput.files.length) {
            alert('Please upload a payment screenshot.');
            return false;
        }

        // Confirmation popup
        const confirmUpload = confirm('You have uploaded an image. Do you want to proceed with the submission?');
        return confirmUpload;
        // Proceed if user confirms
    }
    </script>

</body>

</html>