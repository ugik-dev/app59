<?php
session_start();
include('../linkDB.php');

$data = $_POST;
if (empty($data['fakultas'])) $data['fakultas'] = 0;

$id_user = $_SESSION['id'];
// if($_SESSION['level'] != 1){

// }
$nama = strtoupper($data['nama_baris']);


if (empty($data['id_baris'])) {
    $sql = "INSERT INTO ref_baris (nama_baris, jml_kursi, jenis, fakultas, khusus)
VALUES ('$nama',  {$data['jml_kursi']}, {$data['jenis']}, {$data['fakultas']}, '{$data['khusus']}')";
} else {
    $sql = "UPDATE ref_baris SET jml_kursi = {$data['jml_kursi']},jenis = {$data['jenis']} , nama_baris='$nama' , fakultas = '{$data['fakultas']}',  khusus = '{$data['khusus']}' WHERE  id_baris = {$data['id_baris']}";
}

include('response.php');
