<?php
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