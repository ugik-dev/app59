<?php
// if (array_key_exists('id', $_COOKIE)) {
//     $_SESSION['id'] = $_COOKIE['id']; //stay logged in for long time
//     // echo "<h1> Welcome ! </h1>";
// }
// array_key_exists('id', $_SESSION)
// echo json_encode($_SESSION);
// die();
if (array_key_exists('id', $_SESSION)) {
    include('linkDB.php');
    // echo "<h1>Congratulations,you are registered as user </h1>";
} else {
    header("location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Graduation Registration System</title>

    <!-- Custom fonts for this template-->
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Custom styles for this template-->

    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
    <!-- <link href="https://cdn.datatables.net/v/dt/dt-1.13.3/af-2.5.2/kt-2.8.1/sb-1.4.0/sp-2.1.1/datatables.min.css" /> -->

    <!-- <link href="https://cdn.datatables.net/v/dt/dt-1.13.3/datatables.min.css" /> -->
    <link href="assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <div id="wrapper">
        <?php include('navbar.php') ?>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['name'] ?></span>
                                <img class="img-profile rounded-circle" src="assets/img/undraw_profile.svg" />
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <!-- <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a> -->
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Ganti Password
                                </a>

                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div class="container-fluid">

                    <?php include($page) ?>

                </div>

            </div>
        </div>
    </div>
    <?php include('footer.php') ?>


</body>

</html>