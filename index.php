<?php
include('server.php');

if (empty($_SESSION['level']))
    header("Location: login.php");
else if ($_SESSION['level'] == 1)
    header("Location: admin.php?page=dashboard");


else if (empty($_GET['page'])) $_GET['page'] = 'dashboard';


$page = "pages/{$_GET['page']}.php";
include('template/index.php');
