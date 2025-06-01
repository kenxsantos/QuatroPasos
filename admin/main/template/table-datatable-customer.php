<?php
session_start();
include '../config.php';
include '../authorize.php';


$stmtUsers = $pdo->query("SELECT * FROM `users` WHERE role_as = 0");

mysqli_close($conn);
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
    <!-- Custom Stylesheet -->
    <link href="../css/style.css" rel="stylesheet">
    <style>
    a.btn-add {
        display: inline-block;
        padding: 6px 14px;
        margin: 2px;
        font-size: 14px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    a.btn-add {
        background-color: green;
        color: white;
    }

    .btn-add:hover {
        background-color: rgb(33, 151, 59);
    }

    .btn-add:active {
        background-color: #1e7e34;
        transform: translateY(0);
    }

    td a.btn-edit,
    td a.btn-delete {
        display: inline-block;
        padding: 6px 14px;
        margin: 2px;
        font-size: 14px;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    /* Specific for Edit button */
    td a.btn-edit {
        background-color: #007bff;
        /* blue */
        color: white;
        border: 1px solid #007bff;
    }

    td a.btn-edit:hover {
        background-color: #0056b3;
        color: white;
    }

    /* Specific for Delete button */
    td a.btn-delete {
        background-color: #dc3545;
        /* red */
        color: white;
        border: 1px solid #dc3545;
    }

    td a.btn-delete:hover {
        background-color: #a71d2a;
        color: white;
    }

    .card-title {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    </style>

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
                <div class="header-right">
                    <ul>
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

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                    <h1>Customer Information Management</h1>
                                    <a href="table-datatable-customer-add.php" class="btn-add">
                                        Add
                                    </a>

                                    </button>
                                </div>
                                <div class=" table-responsive">
                                    <table id="" class="table" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Customer ID</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Phone</th>
                                                <th>Address</th>
                                                <th>Action</th>

                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php while ($row = $stmtUsers->fetch(PDO::FETCH_ASSOC)) { ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row["id"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["firstname"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["lastname"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["email"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["phone"]); ?></td>
                                                <td><?php echo htmlspecialchars($row["address"]); ?></td>
                                                <td>
                                                    <a href="table-datatable-customer-edit.php?customerId=<?php echo urlencode($row["id"]); ?>"
                                                        class="btn-edit">
                                                        Edit
                                                    </a>
                                                    <a href="table-datatable-customer-delete.php?customerId=<?php echo urlencode($row["id"]); ?>"
                                                        class="btn-delete">
                                                        Delete
                                                    </a>
                                                </td>

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
</body>

</html>