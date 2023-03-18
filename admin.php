<?php
include('server.php');
if (empty($_SESSION['level']))
    header("Location: login.php");
else if ($_SESSION['level'] != 1)
    header("Location: index.php?page=dashboard");

if ($_GET['page'] == 'scanner') {
    include('template/header.php');
    include('pages_admin/scanner.php');

    $page = "pages_admin/{$_GET['page']}.php";
    include('template/footer.php');
} else {
    $page = "pages_admin/{$_GET['page']}.php";
    include('template/index.php');
}
