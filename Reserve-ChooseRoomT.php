<?php
// Database connection variables
include('Connection/SQLIcon.php');

$booking_id = $_GET['booking_id'];

// Check if form is submitted and required fields are present
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_type = $_POST['room'];   // New room_type value

    // Validate input
    if (!empty($room_type)) {
        // Prepare the SQL statement for updating room_type
        $sql = "UPDATE bookings SET room_type = ? WHERE id = $booking_id";

        // Use prepared statement to prevent SQL injection
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $room_type);

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
        echo "All fields are required!";
    }
}

// Fetch all rooms from the database
$sql_rooms = "SELECT * FROM room";
$result_rooms = $conn->query($sql_rooms);


$host = 'localhost';
$dbname = 'quatropasoshotel2';
$username = 'root';
$password = '';

$pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

// Fetch bookings data
$stmtBookings = $pdo->query("SELECT * FROM `bookings`");

// Fetch rooms data
$stmtRooms = $pdo->query("SELECT * FROM `room`");

// Query to select room types from the `room` table
$sqlRoomTypes = "SELECT type FROM room";
$stmtRoomTypes = $pdo->query($sqlRoomTypes);

?>
<!DOCTYPE html>
<html lang="en">

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

    <style>
        .booking-form {
            width: 100%;
            max-width: 600px;
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
                                    <a href="index.php">
                                        <img class="logo-main" src="images/logo-white.png" alt="">
                                        <img class="logo-mobile" src="images/logo-white.png" alt="">
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



            <section class="relative lines-deco" style="padding: 40px 0 40px 0 !important;">
                <div class="container" style="display: flex;
                  flex-direction: column;
                  align-items: center;">
                    <div class="booking-form">
                        <h2>Choose a Room</h2>
                        <!-- Display success or error message -->


                        <form action="" method="POST">



                            <div class="room-selection">
                                <?php
                                // Loop through all rooms and display each as a card
                                if ($result_rooms->num_rows > 0) {
                                    while ($room = $result_rooms->fetch_assoc()) {
                                        echo '<div class="room-card">';
                                        echo '<img src="' . $room['img'] . '" alt="' . $room['type'] . '">';
                                        echo '<div class="room-info">';
                                        echo '<h2>' . $room['type'] . '</h2>';
                                        echo '<p> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non aliquam ante. Fusce aliquam, nisl et malesuada convallis, lorem lorem aliquam lacus, in pellentesque massa tortor vitae est. Mauris aliquet porttitor augue ut molestie. </p>';
                                        echo '<button type="button" data-room="' . $room['type'] . '">' . $room['type'] . '</button>';
                                        echo '</div>';
                                        echo '</div><br>';
                                    }
                                } else {
                                    echo "No rooms available.";
                                }
                                ?>
                                <div class="room-card">
                                    <img src="your-image-url-here" alt="Junior Suite King Bedroom">
                                    <div class="room-info">
                                        <h2>Junior Suite King Bedroom</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non aliquam ante. Fusce aliquam, nisl et malesuada convallis, lorem lorem aliquam lacus, in pellentesque massa tortor vitae est. Mauris aliquet porttitor augue ut molestie.</p>
                                        <button type="button" data-room="Room 1">Room 1</button>
                                    </div>
                                </div><br>

                                <div class="room-card">
                                    <img src="your-image-url-here" alt="Junior Suite King Bedroom">
                                    <div class="room-info">
                                        <h2>Junior Suite King Bedroom</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non aliquam ante. Fusce aliquam, nisl et malesuada convallis, lorem lorem aliquam lacus, in pellentesque massa tortor vitae est. Mauris aliquet porttitor augue ut molestie.</p>
                                        <button type="button" data-room="Room 2">Room 2</button>

                                    </div>
                                </div><br>

                                <div class="room-card">
                                    <img src="your-image-url-here" alt="Junior Suite King Bedroom">
                                    <div class="room-info">
                                        <h2>Junior Suite King Bedroom</h2>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non aliquam ante. Fusce aliquam, nisl et malesuada convallis, lorem lorem aliquam lacus, in pellentesque massa tortor vitae est. Mauris aliquet porttitor augue ut molestie.</p>
                                        <button type="button" data-room="Room 3">Room 3</button>
                                    </div>
                                </div><br>


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