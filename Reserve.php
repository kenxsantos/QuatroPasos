<?php
include('Connection/SQLIcon.php');

// Initialize variables for success or error messages
$message = "";

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $num_adults = $_POST['num_adults'];
    $num_children = $_POST['num_children'];

    // Validate that all fields are filled and that the number of adults is at least 1
    if (!empty($start_date) && !empty($end_date) && !empty($num_adults) && $num_adults >= 1) {
        // Prepare the SQL statement
        $sql = "INSERT INTO bookings (start_date, end_date, num_adults, num_children) VALUES (?, ?, ?, ?)";

        // Use prepared statement to prevent SQL injection
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssii", $start_date, $end_date, $num_adults, $num_children);

            // Execute the query
            if ($stmt->execute()) {
                // Get the ID of the last inserted row
                $last_id = $conn->insert_id;

                // Redirect to another page with the booking ID
                $url = "Reserve-ChooseRoom.php?booking_id=" . $last_id . "&start_date=" . $start_date . "&end_date=" . $end_date;
                header("Location: " . $url);
                exit(); // Stop further script execution after redirection
            } else {
                $message = "Error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "All fields are required, and the number of adults must be at least 1!";
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html>

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
        justify-content: center; /* Centers the buttons and year display horizontally */
        align-items: center;
        width: 100%; /* Ensure full width to center the content */
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
        margin: 0 10px; /* Add some space between the buttons */
      }

      /* selected date */
      .selected-date {
          background-color: #4caf50;
          color: white;
          border-radius: 50%;
      }

      .range-date {
        background-color: black;
        color: black;
      }

      .past-date {
        color: #ccc; /* Gray color for past dates */
        cursor: not-allowed; /* Indicate that the date is not clickable */
        opacity: 0.6; /* Make it look faded */
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
                <div class="container"style = "display: flex;
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
                                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                                </div>
                                <div class="calendar-dates" id="dates1"></div>
                            </div>

                            <div class="calendar">
                                <div class="calendar-header">
                                <h2 id="month2" style="color: white;"></h2>
                                </div>
                                <div class="calendar-days">
                                <div>Sun</div><div>Mon</div><div>Tue</div><div>Wed</div><div>Thu</div><div>Fri</div><div>Sat</div>
                                </div>
                                <div class="calendar-dates" id="dates2"></div>
                            </div>
                    </div>    
                    <h2 style="text-align: center;">Book an Appointment</h2>
                        <form action="" method="POST">

                            <div style=" display: flex;">
                                <div>
                                    <label for="start_date">Choose a Start Date:</label>
                                    <input type="text" id="start_date" name="start_date" placeholder="Click on calendar" readonly required><br>
                                </div>
                                <div>
                                    <label for="end_date">Choose an End Date:</label>
                                    <input type="text" id="end_date" name="end_date" placeholder="Click on calendar" readonly required><br>
                                </div>  
                            </div><br>


                            <div style="display: flex; gap: 20px;">
                                <div>
                                    <label for="num_adults">Number of Adults:</label>
                                    <input type="number" id="num_adults" name="num_adults" min="1" value="0" required><br>
                                </div>
                                <div>
                                    <label for="num_children">Number of Children:</label>
                                    <input type="number" id="num_children" name="num_children" min="0" value="0" required><br>
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
      let endDate = null;   // Store the selected end date

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
            const dayMonth = day.getAttribute('data-month').padStart(2, '0');
            const dayDate = day.getAttribute('data-day').padStart(2, '0');
            const fullDate = `${dayYear}-${dayMonth}-${dayDate}`;
            const currentDate = new Date(fullDate);

            // Highlight the range including the start and end date
            if (currentDate >= startDateObj && currentDate <= endDateObj) {
              day.classList.add('range-date');
            }
          });
        }
      }

      // Function to render the dates in the calendar
      function renderCalendar(month, year, elementId) {
        const date = new Date(year, month);
        const daysContainer = document.getElementById(elementId);
        const daysInMonth = new Date(year, month + 1, 0).getDate(); // Get the number of days in the month
        const startDay = new Date(year, month, 1).getDay(); // Get the starting day of the week

        daysContainer.innerHTML = "";

        // Fill in blank days for the start of the month
        for (let i = 0; i < startDay; i++) {
          daysContainer.innerHTML += "<div></div>";
        }

        // Get today's date
        const today = new Date();
        today.setHours(0, 0, 0, 0); // Set time to midnight for accurate comparison

        // Fill in the actual days
        for (let i = 1; i <= daysInMonth; i++) {
          let dayHTML = `<div data-day="${i}" data-month="${month + 1}" data-year="${year}">${i}</div>`;
          
          // Create a date object for the current day being rendered
          const currentDay = new Date(year, month, i);

          if (currentDay < today) {
            // If the date is in the past, style it differently and make it non-clickable
            dayHTML = `<div class="past-date" data-day="${i}" data-month="${month + 1}" data-year="${year}">${i}</div>`;
          } else if (i === new Date().getDate() && month === new Date().getMonth() && year === new Date().getFullYear()) {
            // Highlight today's date
            dayHTML = `<div class="today" data-day="${i}" data-month="${month + 1}" data-year="${year}">${i}</div>`;
          }

          daysContainer.innerHTML += dayHTML;
        }

        // Add click event listeners for selecting dates
        const allDays = daysContainer.querySelectorAll("div[data-day]");
        allDays.forEach(day => {
          if (!day.classList.contains('past-date')) { // Only add click listeners for non-past dates
            day.addEventListener("click", function() {
              const selectedDay = this.getAttribute("data-day").padStart(2, '0');
              const selectedMonth = this.getAttribute("data-month").padStart(2, '0');
              const selectedYear = this.getAttribute("data-year");
              const selectedDate = `${selectedYear}-${selectedMonth}-${selectedDay}`;

              if (!startDate) {
                // Select start date and clear any previous selection
                clearHighlights();
                startDate = selectedDate;
                document.getElementById('start_date').value = selectedDate;
                this.classList.add('selected-date');
              } else if (!endDate) {
                // Select end date
                endDate = selectedDate;
                document.getElementById('end_date').value = selectedDate;
                this.classList.add('selected-date');

                // Highlight the range between start and end date
                highlightRange();
              } else {
                // Reset if both start and end date are already selected
                clearHighlights();
                startDate = selectedDate;
                endDate = null;
                document.getElementById('start_date').value = selectedDate;
                document.getElementById('end_date').value = '';
                this.classList.add('selected-date');
              }
            });
          }
        });
      }

      // Update the calendar
      function updateCalendar() {
        document.getElementById("yearDisplay").innerText = currentYear; // Show the current year
        document.getElementById("month1").innerText = monthNames[currentMonthIndex]; // Display the first month
        document.getElementById("month2").innerText = monthNames[(currentMonthIndex + 1) % 12]; // Display the second month

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
      document.getElementById("nextBtn").addEventListener("click", function() {
        currentMonthIndex += 2;
        if (currentMonthIndex >= 12) {
          currentMonthIndex -= 12;
          currentYear++; // If we wrap around to January, increment the year
        }
        updateCalendar();
      });

      // Handle the previous button
      document.getElementById("prevBtn").addEventListener("click", function() {
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