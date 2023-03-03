<?php
session_start();
include('../linkDB.php');

$data = $_GET['id'];

$id_user = $_SESSION['id'];

$sql = "DELETE FROM ref_baris WHERE id_baris = " . $data;


include('response.php');
