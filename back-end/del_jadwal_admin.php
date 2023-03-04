<?php
session_start();
include('../linkDB.php');

$data = $_GET['id'];

$id_user = $_SESSION['id'];




$query = "SELECT *
 FROM jadwal  WHERE  id_jadwal = $data
";

// echo $query;
// die();
$result = mysqli_query($linkDB, $query);
// $row = mysqli_fetch_array($result);
// $row = $result->fetch_array(MYSQLI_NUM);
// $data_id = 'NULL'
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // echo json_encode($row);
        // if ($row['status'] != 1) {
        //     echo json_encode(['error' => true, 'message' => "Hapus Gagal! Data sudah diproses admin"]);
        //     return;
        // } else {
        $sql = "DELETE FROM jadwal WHERE id_jadwal = " . $row['id_jadwal'];
        // }
    }
} else {
    echo json_encode(['error' => true, 'message' => "Hapus Gagal! Data tidak ditemukan"]);
    return;
}

include('response.php');
