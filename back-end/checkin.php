<?php
session_start();
include('../linkDB.php');

// $data = $_POST;

$qrcode = $_GET['qrcode'];
$qrcode_exs = explode('_', $qrcode);
if (!empty($qrcode_exs[1])) {
    $sql = "SELECT * FROM reg_jadwal WHERE qrcode_ortu = '$qrcode'";
    $wktu = date('Y-m-d H:i:s');

    $result = mysqli_query($linkDB, $sql);
    // echo $result->num_rows;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['status_ortu'] == 2)
                $sql = "UPDATE reg_jadwal SET status_ortu = '3'  WHERE  qrcode_ortu = '{$qrcode}'";
            else if ($row['status_ortu'] == 3) {
                echo json_encode(['error' => true, 'message' => "Gagal! QR-Code sudah Check-In"]);
                return;
            }
        }
    } else {
        echo json_encode(['error' => true, 'message' => "Gagal! Data tidak ditemukan.."]);
        return;
    }
} else {

    // echo json_encode($data);
    $sql = "SELECT * FROM reg_jadwal WHERE qrcode = '$qrcode'";
    $wktu = date('Y-m-d H:i:s');

    $result = mysqli_query($linkDB, $sql);
    // echo $result->num_rows;
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            if ($row['status_reg'] == 2)
                $sql = "UPDATE reg_jadwal SET status_reg = '3' , checkin_time = '{$wktu}' WHERE  qrcode = '{$qrcode}'";
            else if ($row['status_reg'] == 3) {
                echo json_encode(['error' => true, 'message' => "Gagal! QR-Code sudah Check-In"]);
                return;
            }
        }
    } else {
        echo json_encode(['error' => true, 'message' => "Gagal! Data tidak ditemukan.."]);
        return;
    }
}

include('response.php');
