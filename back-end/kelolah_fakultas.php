<?php
session_start();
include('../linkDB.php');

$data = $_POST;

$id_user = $_SESSION['id'];

if (empty($data['id_fakultas'])) {
    $sql = "INSERT INTO fakultas (nama_fakultas)
VALUES ( '{$data['nama_fakultas']}')";
} else {
    $sql = "UPDATE fakultas SET nama_fakultas = '{$data['nama_fakultas']}' 
     WHERE  id_fakultas = {$data['id_fakultas']}";
}

include('response.php');
