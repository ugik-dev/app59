<?php
session_start();
include('../linkDB.php');

$data = $_POST;

$id_user = $_SESSION['id'];
// if($_SESSION['level'] != 1){

// }
$nama = strtoupper($data['nama_baris']);
if (empty($data['id_baris'])) {
    $sql = "INSERT INTO ref_baris (nama_baris, jml_kursi)
VALUES ('$nama',  {$data['jml_kursi']})";
} else {
    $sql = "UPDATE ref_baris SET jml_kursi = {$data['jml_kursi']} , nama_baris='$nama' WHERE  id_baris = {$data['id_baris']}";
}

include('response.php');
