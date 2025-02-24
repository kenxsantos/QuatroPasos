<?php
// Database connection variables
include('Connection/SQLIcon.php');

$booking_id = $_GET['booking_id'];
$num_adults = $_GET['num_adults'];

// Check if form is submitted and required fields are present
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_type = $_POST['room'];   // New RoomType value

    // Fetch the selected room's price based on room type
    $sql_price = "SELECT price FROM room WHERE type = ?";
    $stmt_price = $conn->prepare($sql_price);
    $stmt_price->bind_param("s", $room_type);
    $stmt_price->execute();
    $result_price = $stmt_price->get_result();

    if ($result_price->num_rows > 0) {
        $price_row = $result_price->fetch_assoc();
        $price = $price_row['price'];  // Get the price of the selected room type

        // Prepare the SQL statement for updating RoomType and price
        $sql = "UPDATE bookings SET RoomType = ?, price = ? WHERE id = ?";

        // Use prepared statement to prevent SQL injection
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssi", $room_type, $price, $booking_id);  // "sdi" represents string, double, and integer

            // Execute the statement
            if ($stmt->execute()) {
                $last_id = $conn->insert_id;

                // Redirect to another page with the booking ID
                $url = "Reserve-Booked-info.php?booking_id=" . $booking_id;
                header("Location: " . $url);
            } else {
                echo "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: Room type not found!";
    }

    // Close the price statement
    $stmt_price->close();
}

// Parameters
$startDate = $_GET['start_date']; // replace with dynamic values as needed
$endDate = $_GET['end_date'];   // replace with dynamic values as needed

// First, select all RoomTypes from table2
$sqlRoomTypes = "SELECT type FROM room";
$resultRoomTypes = $conn->query($sqlRoomTypes);

// Fetch all rooms from the database
$sql_rooms = "SELECT * FROM room";
$result_rooms = $conn->query($sql_rooms);
?>



<!DOCTYPE html>
<html lang="en">

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

    <style>
    .booking-form {
        width: 100%;
        max-width: 1100px;
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



    .room-selection button {
        padding: 15px;
        font-size: 16px;
        border: 2px solid #007bff;
        background-color: white;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .room-selection button.selected {
        background-color: #f3a84a;
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

    /* room CSS */
    .room-card {
        display: flex;
        max-width: 800px;
        border: 1px solid #ddd;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .room-card img {
        width: 50%;
        height: auto;
        border-right: 1px solid #ddd;
    }

    .room-info {
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .room-info h2 {
        margin: 0;
        font-size: 1.5em;
    }

    .room-info p {
        color: #666;
        line-height: 1.5;
        margin: 10px 0;
    }

    .room-info button {
        background-color: white;
        color: Black;
        border: none;
        border: 2px solid #e69630;
        border-radius: 5px;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1em;
        align-self: flex-start;
    }

    .room-info button:hover {
        background-color: #e69630;
    }

    section.lines-deco:before {
        content: none !important;
    }

    section.lines-deco:after {
        content: none !important;
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



            <section class="relative lines-deco" style="padding: 40px 0 40px 0 !important;">
                <div class="container" style="display: flex;
                  flex-direction: column;
                  align-items: center;">
                    <div class="booking-form">
                        <h2>Choose a Room</h2>
                        <!-- Display success or error message -->


                        <form action="" method="POST">


                            <div class="container">
                                <div class="row room-selection">
                                    <?php
                                    if ($resultRoomTypes->num_rows > 0) {
                                        // Loop through each RoomType from table2
                                        while ($row = $resultRoomTypes->fetch_assoc()) {
                                            $roomType = $row['type'];
                                            $room = $result_rooms->fetch_assoc();

                                            // Prepare query to count RoomTypes within the specified date range
                                            $sqlCount = "SELECT COUNT(*) AS count FROM bookings 
                                              WHERE RoomType = ? AND start_date >= ? AND end_date <= ?";
                                            $stmtCount = $conn->prepare($sqlCount);
                                            $stmtCount->bind_param("sss", $roomType, $startDate, $endDate);
                                            $stmtCount->execute();
                                            $resultCount = $stmtCount->get_result();
                                            $countRow = $resultCount->fetch_assoc();



                                            // Check if the counted RoomType is less than 10
                                            if ($countRow['count'] < $room['AvRooms']) {

                                                echo '<div class="col-12 col-md-6 col-lg-6 mb-4">';
                                                echo '<div class="room-card">';
                                                echo '<img src="admin/main/template/' . $room['img'] . '" alt="' . $room['type'] . '">';
                                                echo '<div class="room-info">';
                                                echo '<h2>' . $room['type'] . '</h2>';
                                                echo '<p>' . $room['price'] . '</p>';
                                                echo '<button type="button" data-room="' . $room['type'] . '" style="width:100px"> Book </button>';
                                                echo '</div>';
                                                echo '</div>';
                                                echo '</div><br>';
                                            } else {
                                            }

                                            // Close the statement
                                            $stmtCount->close();
                                        }
                                    } else {
                                        echo "No RoomTypes found in table2.";
                                    }
                                    ?>

                                </div>
                            </div>
                            <!-- Hidden input to store the selected room -->
                            <input type="hidden" id="room" name="room" required>

                            <button type="submit" class="submit-btn">Book Now</button>
                        </form>
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

    <script>
    // JavaScript to handle room selection
    const roomButtons = document.querySelectorAll('.room-selection button');
    const roomInput = document.getElementById('room');

    roomButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove 'selected' class from all buttons
            roomButtons.forEach(btn => btn.classList.remove('selected'));

            // Add 'selected' class to the clicked button
            button.classList.add('selected');

            // Update the hidden room input with the selected room value
            roomInput.value = button.getAttribute('data-room');
        });
    });
    </script>

</body>

</html>

<?php
// Close connection
$conn->close();

?>