<?php
session_start();
include('../linkDB.php');

$data = $_GET['id'];

$id_user = $_SESSION['id'];

$sql = "DELETE FROM fakultas_jurusan WHERE id_fakultas_jurusan = " . $data;


include('response.php');
