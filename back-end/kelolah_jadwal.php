<?php
session_start();
include('../linkDB.php');

$data = $_POST;

$id_user = $_SESSION['id'];
// if($_SESSION['level'] != 1){

// }
if (empty($data['id_jadwal'])) {
    $sql = "INSERT INTO jadwal (tanggal_wisuda, w_reg_start, w_reg_end)
VALUES ( '{$data['tanggal_wisuda']}', '{$data['w_reg_start']}', '{$data['w_reg_end']}' )";
    // echo $sql;
    // die();
} else {
    $sql = "UPDATE jadwal SET tanggal_wisuda = '{$data['tanggal_wisuda']}' , w_reg_start = '{$data['w_reg_start']}', w_reg_end = '{$data['w_reg_end']}' WHERE  id_jadwal = {$data['id_jadwal']}";
}

include('response.php');
