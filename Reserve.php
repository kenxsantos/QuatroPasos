<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = isset($_POST['start_date']) ? trim($_POST['start_date']) : '';
    $end_date = isset($_POST['end_date']) ? trim($_POST['end_date']) : '';
    $num_adults = isset($_POST['num_adults']) ? (int) $_POST['num_adults'] : 0;
    $num_children = isset($_POST['num_children']) ? (int) $_POST['num_children'] : 0;
    $type_of_stay = isset($_POST['type_of_stay']) ? trim($_POST['type_of_stay']) : 'none';


    if ($start_date !== $end_date) {
        $type_of_stay = "long";
    }

    if (!empty($start_date) && !empty($end_date) && $num_adults >= 1 && $type_of_stay !== "none") {
        $query = "SELECT MAX(id) as last_id FROM bookings";
        $result = $conn->query($query);

        if ($result && $row = $result->fetch_assoc()) {
            header("Location: Reserve-ChooseRoom.php?start_date={$start_date}&end_date={$end_date}&num_adults={$num_adults}&num_children={$num_children}&type_of_stay={$type_of_stay}");
            exit();
        } else {
            $message = "Error fetching booking details.";
        }
    } else {
        $message = "All fields are required, and the number of adults must be at least 1! ";
    }
}

// Close the connection if it exists
if (isset($conn)) {
    $conn->close();
}
?>

<!DOCTYPE html>
<html>

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
        .year-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 700px;
            margin-bottom: 20px;
        }

        .year-header button {
            background-color: #FEB46B;
            color: white;
            font-size: 1.2rem;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .calendar-container {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
        }

        .calendar {
            width: 350px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .calendar-header {
            background-color: #261C15;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .calendar-days {
            display: flex;
            justify-content: space-around;
            background-color: #f1f1f1;
            padding: 10px;
        }

        .calendar-days div {
            font-weight: bold;
            color: #333;
        }

        .calendar-dates {
            display: flex;
            flex-wrap: wrap;
            padding: 10px;
        }

        .calendar-dates div {
            width: 14.28%;
            text-align: center;
            padding: 5px;
            box-sizing: border-box;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            border: 1px solid white;
        }

        .calendar-dates div:hover {
            background-color: #261C15;
            color: white;
        }

        .calendar-dates .today {
            background-color: #261C15;
            color: white;
            font-weight: bold;
        }

        .calendar-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form div {
            display: flex;
            gap: 20px;
        }

        form button {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #FEB46B;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .year-header {
            display: flex;
            justify-content: center;
            /* Centers the buttons and year display horizontally */
            align-items: center;
            width: 100%;
            /* Ensure full width to center the content */
            margin-bottom: 20px;
        }

        .year-header button {
            background-color: #FEB46B;
            color: white;
            font-size: 1.2rem;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 10px;
            /* Add some space between the buttons */
        }

        /* selected date */
        .selected-date {
            background-color: #4caf50;
            color: white;
            border-radius: 50%;
        }

        .range-date {
            background-color: #4caf50;
            border: 1px solid white;
            color: black;
        }

        .past-date {
            color: #ccc !important;
            /* Gray color for past dates */
            cursor: not-allowed;
            /* Indicate that the date is not clickable */
            opacity: 0.6;
            /* Make it look faded */
        }

        select {
            padding: 2px 30px;
            border-radius: 2px;
        }

        select:focus {
            outline: none;
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
                    <div class="row g-4">
                        <div class="year-header">
                            <button id="prevBtn">&#8249;</button>
                            <h1 id="yearDisplay"></h1>
                            <button id="nextBtn"> &#8250;</button>
                        </div>

                        <div class="calendar-container">
                            <div class="calendar">
                                <div class="calendar-header">
                                    <h2 id="month1" Style="color:white;"></h2>
                                </div>
                                <div class="calendar-days">
                                    <div>Sun</div>
                                    <div>Mon</div>
                                    <div>Tue</div>
                                    <div>Wed</div>
                                    <div>Thu</div>
                                    <div>Fri</div>
                                    <div>Sat</div>
                                </div>
                                <div class="calendar-dates" id="dates1"></div>
                            </div>

                            <div class="calendar">
                                <div class="calendar-header">
                                    <h2 id="month2" style="color: white;"></h2>
                                </div>
                                <div class="calendar-days">
                                    <div>Sun</div>
                                    <div>Mon</div>
                                    <div>Tue</div>
                                    <div>Wed</div>
                                    <div>Thu</div>
                                    <div>Fri</div>
                                    <div>Sat</div>
                                </div>
                                <div class="calendar-dates" id="dates2"></div>
                            </div>
                        </div>
                        <h2 style="text-align: center;">Book an Appointment</h2>
                        <h5 style="text-align: center;">Need a short stay? Double click the date to book!</h5>
                        <br>
                        <form action="" method="POST">
                            <div style=" display: flex;">
                                <div>
                                    <label for="start_date">Choose a Start Date:</label>
                                    <input type="text" id="start_date" name="start_date" placeholder="Click on calendar"
                                        readonly required><br>
                                </div>
                                <div>
                                    <label for="end_date">Choose an End Date:</label>
                                    <input type="text" id="end_date" name="end_date" placeholder="Click on calendar"
                                        readonly required><br>
                                </div>
                            </div><br>

                            <div id="nightDayButtons" style="display: none; text-align: center;">
                                <h5 style="text-align: center;">Choose your stay!</h5>

                                <div>
                                    <label for="type_of_stay">Choose Length of stay:</label>
                                    <select id="type_of_stay" name="type_of_stay" required>
                                        <option value="none">--Select Stay--</option>
                                        <option value="day">Day (10 hours)</option>
                                        <option value="night">Night (10 hours)</option>
                                    </select><br>
                                </div>
                            </div>
                            <br>
                            <div style="display: flex; gap: 20px;">
                                <div>
                                    <label for="num_adults">Number of Adults:</label>
                                    <select id="num_adults" name="num_adults" required>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                    </select><br>
                                </div>
                                <div>
                                    <label for="num_children">Number of Children:</label>
                                    <select id="num_children" name="num_children" required>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select><br>
                                </div>

                            </div><br>
                            <button type="submit">Book Now</button>
                        </form>

                        <p><?php echo $message; ?></p>
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
        const monthNames = [
            "January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"
        ];

        let currentYear = new Date().getFullYear(); // Start with the current year
        let currentMonthIndex = new Date().getMonth(); // Start with the current month
        let startDate = null; // Store the selected start date
        let endDate = null; // Store the selected end date

        // Function to clear date highlights
        function clearHighlights() {
            const allDays = document.querySelectorAll('.calendar-dates div');
            allDays.forEach(day => {
                day.classList.remove('selected-date');
                day.classList.remove('range-date');
            });
        }

        // Function to highlight the range of dates between start and end date
        function highlightRange() {
            if (startDate && endDate) {
                const allDays = document.querySelectorAll('.calendar-dates div');
                const startDateObj = new Date(startDate);
                const endDateObj = new Date(endDate);

                allDays.forEach(day => {
                    const dayYear = day.getAttribute('data-year');
                    const dayMonth = String(day.getAttribute('data-month')).padStart(2, '0');
                    const dayDate = String(day.getAttribute('data-day')).padStart(2, '0');
                    const fullDate = `${dayYear}-${dayMonth}-${dayDate}`;
                    const currentDate = new Date(fullDate);

                    // Highlight the range including the start and end date
                    if (currentDate >= startDateObj && currentDate <= endDateObj) {
                        day.classList.add('range-date');
                    }
                });
            }
        }

        async function fetchBookings() {
            try {
                const response = await fetch("fetch_bookings.php"); // Call PHP file

                // Check if response is actually JSON
                const text = await response.text();
                console.log("Raw response:", text); // Debugging

                const bookings = JSON.parse(text); // Convert text to JSON

                if (bookings.error) {
                    console.error("Server error:", bookings.error);
                    return {};
                }

                // Format data for calendar
                const formattedBookings = {};
                bookings.forEach(booking => {
                    let startDate = new Date(booking.start_date);
                    let endDate = new Date(booking.end_date);

                    while (startDate <= endDate) {
                        let formattedDate = startDate.toISOString().split('T')[0];
                        formattedBookings[formattedDate] = booking.type_of_stay;
                        startDate.setDate(startDate.getDate() + 1);
                    }
                });

                return formattedBookings;
            } catch (error) {
                console.error("Error fetching bookings:", error);
                return {};
            }
        }



        // Function to render the dates in the calendar
        async function renderCalendar(month, year, elementId) {
            const date = new Date(year, month);
            const daysContainer = document.getElementById(elementId);
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const startDay = new Date(year, month, 1).getDay();

            daysContainer.innerHTML = "";

            // Fetch bookings
            const bookings = await fetchBookings();
            console.log("Booking Data:", bookings);

            // Define color mapping for different stay types
            const stayColors = {
                "day": "#ffa500",
                "long": "#E84B3D",
                "night": "#FF1DCE"
            };

            // Fill in blank days before the 1st of the month
            for (let i = 0; i < startDay; i++) {
                daysContainer.innerHTML += "<div></div>";
            }

            const today = new Date();
            today.setHours(0, 0, 0, 0); // Normalize time for comparison

            // Render days in the month
            for (let i = 1; i <= daysInMonth; i++) {
                const currentDay = new Date(year, month, i);
                const formattedDate = `${year}-${(month + 1).toString().padStart(2, '0')}-${i.toString().padStart(2, '0')}`;

                let dayHTML = `<div data-day="${i}" data-month="${month + 1}" data-year="${year}">${i}</div>`;

                if (currentDay < today) {
                    // Past dates (gray and non-clickable)
                    dayHTML = `<div class="past-date" data-day="${i}" data-month="${month + 1}" data-year="${year}">${i}</div>`;
                } else if (i === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear()) {
                    // Highlight today's date
                    dayHTML = `<div class="today" data-day="${i}" data-month="${month + 1}" data-year="${year}">${i}</div>`;
                } else if (bookings[formattedDate]) {
                    // Apply booking colors if the date is booked
                    const typeOfStay = bookings[formattedDate];
                    const color = stayColors[typeOfStay] || "gray"; // Default to gray if unknown type

                    dayHTML = `<div class="booked-date" data-day="${i}" data-month="${month + 1}" data-year="${year}" style="background-color: ${color};">${i}</div>`;
                } else {
                    // Mark available dates in green
                    dayHTML = `<div class="available-date" data-day="${i}" data-month="${month + 1}" data-year="${year}" style="background-color: lightgreen; color: white;">${i}</div>`;
                }

                daysContainer.innerHTML += dayHTML;
            }

            // Add click event listeners for selecting dates
            const allDays = daysContainer.querySelectorAll("div[data-day]");

            allDays.forEach(day => {
                if (!day.classList.contains('past-date') && !day.classList.contains('booked-date')) {
                    day.addEventListener("click", function () {
                        const selectedDay = this.getAttribute("data-day").padStart(2, '0');
                        const selectedMonth = this.getAttribute("data-month").padStart(2, '0');
                        const selectedYear = this.getAttribute("data-year");
                        const selectedDate = `${selectedYear}-${selectedMonth}-${selectedDay}`;

                        if (!startDate) {
                            clearHighlights();
                            startDate = selectedDate;
                            document.getElementById('start_date').value = selectedDate;
                            this.classList.add('selected-date');
                        } else if (!endDate) {
                            endDate = selectedDate;
                            document.getElementById('end_date').value = selectedDate;
                            this.classList.add('selected-date');
                            highlightRange();
                            if (startDate === endDate) {
                                showNightDayButtons();
                            }
                        } else {
                            clearHighlights();
                            startDate = selectedDate;
                            endDate = null;
                            document.getElementById('start_date').value = selectedDate;
                            document.getElementById('end_date').value = '';
                            this.classList.add('selected-date');
                            hideNightDayButtons();
                        }
                    });
                }
            });
        }


        function showNightDayButtons() {
            const nightDayButtons = document.getElementById("nightDayButtons");
            nightDayButtons.style.display = "block"; // Show buttons

            // Ensure event listeners are only added once
            if (!document.getElementById("nightButton").dataset.listenerAdded) {
                document.getElementById("nightButton").addEventListener("click", function () {
                    alert("Night selected!");
                });
                document.getElementById("nightButton").dataset.listenerAdded = "true";
            }

            if (!document.getElementById("dayButton").dataset.listenerAdded) {
                document.getElementById("dayButton").addEventListener("click", function () {
                    alert("Day selected!");
                });
                document.getElementById("dayButton").dataset.listenerAdded = "true";
            }
        }

        function hideNightDayButtons() {
            document.getElementById("nightDayButtons").style.display = "none";
        }

        // Listen for input changes to show/hide buttons dynamically
        document.getElementById("start_date").addEventListener("input", function () {
            if (startDate === endDate) {
                showNightDayButtons();
            } else {
                hideNightDayButtons();
            }
        });

        document.getElementById("end_date").addEventListener("input", function () {
            if (startDate === endDate) {
                showNightDayButtons();
            } else {
                hideNightDayButtons();
            }
        });

        // Update the calendar
        function updateCalendar() {
            document.getElementById("yearDisplay").innerText = currentYear; // Show the current year
            document.getElementById("month1").innerText = monthNames[currentMonthIndex]; // Display the first month
            document.getElementById("month2").innerText = monthNames[(currentMonthIndex + 1) %
                12]; // Display the second month

            // If the current month is January and we're rendering December (currentMonthIndex is 11)
            let secondMonthYear = currentYear;
            if (currentMonthIndex === 11) {
                secondMonthYear++;
            }

            // Render the two calendars
            renderCalendar(currentMonthIndex, currentYear, "dates1");
            renderCalendar((currentMonthIndex + 1) % 12, secondMonthYear, "dates2");
        }

        // Handle the next button
        document.getElementById("nextBtn").addEventListener("click", function () {
            currentMonthIndex += 2;
            if (currentMonthIndex >= 12) {
                currentMonthIndex -= 12;
                currentYear++; // If we wrap around to January, increment the year
            }
            updateCalendar();
        });

        // Handle the previous button
        document.getElementById("prevBtn").addEventListener("click", function () {
            currentMonthIndex -= 2;
            if (currentMonthIndex < 0) {
                currentMonthIndex += 12;
                currentYear--; // If we wrap around to December, decrement the year
            }
            updateCalendar();
        });

        // Initial render
        updateCalendar();
    </script>



</body>

</html>