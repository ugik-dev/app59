<?php
session_start();
include('../linkDB.php');

$data = $_GET['id'];

$id_user = $_SESSION['id'];




$query = "SELECT rj.*, j.status
 FROM reg_jadwal as rj 
 JOIN jadwal as j on rj.id_jadwal = j.id_jadwal 


WHERE rj.id_user  = $id_user 
AND id_reg_jadwal = $data
-- GROUP BY id_jadwal
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
        if ($row['status'] != 1) {
            echo json_encode(['error' => true, 'message' => "Hapus Gagal! Data sudah diproses admin"]);
            return;
        } else {
            $sql = "DELETE FROM reg_jadwal WHERE id_reg_jadwal = " . $row['id_reg_jadwal'];
        }
    }
} else {
    echo json_encode(['error' => true, 'message' => "Hapus Gagal! Data tidak ditemukan"]);
    return;
}

include('response.php');
