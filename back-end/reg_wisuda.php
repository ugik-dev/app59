<?php
session_start();
include('../linkDB.php');

$data = $_POST;

$id_user = $_SESSION['id'];
// echo json_encode($data);


$cek = "SELECT * FROM jadwal WHERE id_jadwal = {$data['id_jadwal']}";
// echo $cek;
$resultcek = mysqli_query($linkDB, $cek);

if ($resultcek->num_rows > 0) {
    while ($rowresultcek = $resultcek->fetch_assoc()) {
        // echo json_encode($rowresultcek);
        if ($rowresultcek['w_reg_end'] < date('Y-m-d')) {
            echo json_encode(['error' => true, 'message' => "Gagal! Periode waktu daftar sudah berakhir"]);
            return;
        } else
        if ($rowresultcek['status'] == 2) {
            echo json_encode(['error' => true, 'message' => "Gagal! Kursi sudah ditempatkan / diganerate"]);
            return;
        }
    }
} else {
    echo json_encode(['error' => true, 'message' => "Gagal! Data tidak ditemukan"]);
    return;
}
// die();

// Cek Predikat
$sql = "SELECT * FROM ref_predikat WHERE ";
$sql .= " min_ipk <= {$data['ipk']} AND max_ipk >= {$data['ipk']} ";
$sql .= " AND max_studi >= {$data['masa_studi']} ";
if ($data['retake'] == 'Y') {
    $sql .= " AND retake = 'Y' ";
}

$sql .= " AND min_score >= '{$data['min_score']} ' ORDER BY rank_posisi ASC LIMIT 1";

$result = mysqli_query($linkDB, $sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // echo json_encode($row);
        $data['predikat'] = $row['id_ref_predikat'];
    }
} else {
    $data['predikat'] = NULL;
}


$wktu = date('Y-m-d H:i:s');
$sql = "INSERT INTO reg_jadwal (id_jadwal, id_user, waktu_reg, ipk, masa_studi, retake, min_score , predikat)
VALUES ('{$data['id_jadwal']}', '$id_user', '$wktu', '{$data['ipk']}', '{$data['masa_studi']}', '{$data['retake']}', '{$data['min_score']}', '{$data['predikat']}')";

include('response.php');
