<?php
session_start(); // Start the session
include('../../../Connection/PDOcon.php');
include('../authorize.php');
$stmt = $pdo->query("SELECT * FROM `bookings`");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Quatro Pasos Website</title>
    <!-- Favicon icon -->
    <link rel="icon" href="../../../images/icon.png" type="image/gif" sizes="16x16">
    <link href="../../assets/plugins/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <!-- Custom Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">

</head>

<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="loader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="3" stroke-miterlimit="10" />
            </svg>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <div class="brand-logo"><a href="index-ticket.php"><b><img src="../../assets/images/logo.png" alt="">
                    </b><span class="brand-title"><img src="../../assets/images/logo-text.png" alt=""></span></a>
            </div>
            <div class="nav-control">
                <div class="hamburger"><span class="line"></span> <span class="line"></span> <span class="line"></span>
                </div>
            </div>
        </div>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <div class="header">
            <div class="header-content">
                <div class="header-left">
                    <ul>
                        <li class="icons position-relative"><a href="javascript:void(0)"><i
                                    class="icon-magnifier f-s-16"></i></a>
                            <div class="drop-down animated bounceInDown">
                                <div class="dropdown-content-body">
                                    <div class="header-search" id="header-search">
                                        <form action="#">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Search">
                                                <div class="input-group-append"><span class="input-group-text"><i
                                                            class="icon-magnifier"></i></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="header-right">
                    <ul>
                        <li class="icons">
                            <a href="javascript:void(0)">
                                <i class="mdi mdi-comment"></i>
                                <div class="pulse-css"></div>
                            </a>
                            <div class="drop-down animated bounceInDown">
                                <div class="dropdown-content-heading">
                                    <span class="pull-left">Messages</span>
                                    <a href="javascript:void()" class="pull-right text-white">View All</a>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="pull-left mr-3 avatar-img"
                                                    src="../../assets/images/avatar/1.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Druid Wensleydale</div>
                                                    <div class="notification-text">A wonderful serenit has take
                                                        possession</div><small class="notification-timestamp">08 Hours
                                                        ago</small>
                                                </div>
                                            </a><span class="notify-close"><i class="ti-close"></i></span>
                                        </li>
                                        <li class="notification-unread">
                                            <a href="javascript:void()">
                                                <img class="pull-left mr-3 avatar-img"
                                                    src="../../assets/images/avatar/2.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Fig Nelson</div>
                                                    <div class="notification-text">A wonderful serenit has take
                                                        possession</div><small class="notification-timestamp">08 Hours
                                                        ago</small>
                                                </div>
                                            </a><span class="notify-close"><i class="ti-close"></i></span>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="pull-left mr-3 avatar-img"
                                                    src="../../assets/images/avatar/3.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Bailey Wonger</div>
                                                    <div class="notification-text">A wonderful serenit has take
                                                        possession</div><small class="notification-timestamp">08 Hours
                                                        ago</small>
                                                </div>
                                            </a><span class="notify-close"><i class="ti-close"></i></span>
                                        </li>
                                        <li>
                                            <a href="javascript:void()">
                                                <img class="pull-left mr-3 avatar-img"
                                                    src="../../assets/images/avatar/4.jpg" alt="">
                                                <div class="notification-content">
                                                    <div class="notification-heading">Bodrum Salvador</div>
                                                    <div class="notification-text">A wonderful serenit has take
                                                        possession</div><small class="notification-timestamp">08 Hours
                                                        ago</small>
                                                </div>
                                            </a><span class="notify-close"><i class="ti-close"></i></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="icons">
                            <a href="javascript:void(0)">
                                <i class="mdi mdi-bell"></i>
                                <div class="pulse-css"></div>
                            </a>
                            <div class="drop-down animated bounceInDown dropdown-notfication">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li>
                                            <a href="javascript:void()">
                                                <span class="mr-3 avatar-icon bg-success-lighten-2"><i
                                                        class="fa fa-check"></i></span>
                                                <div class="notification-content">
                                                    <div class="notification-heading">Druid Wensleydale</div>
                                                    <span class="notification-text">A wonderful serenit of my entire
                                                        soul.</span>
                                                    <small class="notification-timestamp">20 May 2018, 15:32</small>
                                                </div>
                                            </a>
                                            <span class="notify-close"><i class="ti-close"></i>
                                            </span>
                                        </li>
                                        <li><a href="javascript:void()"><span
                                                    class="mr-3 avatar-icon bg-danger-lighten-2"><i
                                                        class="fa fa-close"></i></span>
                                                <div class="notification-content">
                                                    <div class="notification-heading">Inverness McKenzie</div><span
                                                        class="notification-text">A wonderful serenit of my entire
                                                        soul.</span> <small class="notification-timestamp">20 May 2018,
                                                        15:32</small>
                                                </div>
                                            </a>
                                            <span class="notify-close"><i class="ti-close"></i>
                                            </span>
                                        </li>
                                        <li><a href="javascript:void()"><span
                                                    class="mr-3 avatar-icon bg-success-lighten-2"><i
                                                        class="fa fa-check"></i></span>
                                                <div class="notification-content">
                                                    <div class="notification-heading">McKenzie Inverness</div><span
                                                        class="notification-text">A wonderful serenit of my entire
                                                        soul.</span> <small class="notification-timestamp">20 May 2018,
                                                        15:32</small>
                                                </div>
                                            </a>
                                            <span class="notify-close"><i class="ti-close"></i>
                                            </span>
                                        </li>
                                        <li><a href="javascript:void()"><span
                                                    class="mr-3 avatar-icon bg-danger-lighten-2"><i
                                                        class="fa fa-close"></i></span>
                                                <div class="notification-content">
                                                    <div class="notification-heading">Inverness McKenzie</div><span
                                                        class="notification-text">A wonderful serenit of my entire
                                                        soul.</span> <small class="notification-timestamp">20 May 2018,
                                                        15:32</small>
                                                </div>
                                            </a>
                                            <span class="notify-close"><i class="ti-close"></i>
                                            </span>
                                        </li>
                                        <li class="text-left"><a href="javascript:void()" class="more-link">Show All
                                                Notifications</a> <span class="pull-right"><i
                                                    class="fa fa-angle-right"></i></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="icons">
                            <a href="javascript:void(0)" class="log-user">
                                <span><?= $row2["firstname"] ?></span> <i class="fa fa-caret-down f-s-14"
                                    aria-hidden="true"></i>
                            </a>
                            <div class="drop-down dropdown-profile animated bounceInDown">
                                <div class="dropdown-content-body">
                                    <ul>
                                        <li><a href="javascript:void()"><i class="icon-user"></i> <span>My
                                                    Profile</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-wallet"></i> <span>My
                                                    Wallet</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-envelope"></i>
                                                <span>Inbox</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="fa fa-cog"></i>
                                                <span>Setting</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-lock"></i> <span>Lock
                                                    Screen</span></a>
                                        </li>
                                        <li><a href="javascript:void()"><i class="icon-power"></i>
                                                <span>Logout</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!--**********************************
            Header end
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php
        include('sidebar.php');
        ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col p-md-0">
                        <h4>Hello, <span>Welcome here</span></h4>
                    </div>
                    <div class="col p-md-0">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a>
                            </li>
                            <li class="breadcrumb-item active">Datatable</li>
                        </ol>
                    </div>
                </div>
                <!-- row -->

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h1>Payment</h1>
                                </div>
                                <div class="table-responsive">
                                    <table id="" class="table" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Reservation ID</th>
                                                <th>Guest Name</th>
                                                <th>Room Type</th>
                                                <th>Check-in</th>
                                                <th>Check-out</th>
                                                <th>Number of Guests</th>
                                                <th>Total Booking Amount</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td><?php echo $row["id"] ?></td>
                                                <td><?php echo $row["name"] ?></td>
                                                <td>
                                                    <span class="text-muted"><?php echo $row["room_type"] ?></span>
                                                </td>
                                                <td>
                                                    <span class="text-muted"><?php echo $row["start_date"] ?></span>
                                                </td>
                                                <td><?php echo $row["end_date"] ?></td>
                                                <td><?php echo $row["booking_time"] ?></td>
                                                <td><?php echo $row["Price"] ?></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <!-- #/ container -->
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <!-- <p>Copyright &copy; Developed by Allen</a> 2018</p> -->
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="../../assets/plugins/common/common.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/gleek.js"></script>
    <script src="../js/styleSwitcher.js"></script>

    <script src="../../assets/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../js/plugins-init/datatables.init.js"></script>
</body>

</html>