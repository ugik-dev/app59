<?php
session_start();
include('../linkDB.php');
include('../lib/phpqrcode/qrlib.php');
$tempDir = "../qrcode/";


$id = $_GET['id'];

$query = "SELECT * FROM ref_baris as j ORDER BY nama_baris asc
";
$result = mysqli_query($linkDB, $query);

$dataKursi = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        for ($i = 1; $i <= $row['jml_kursi']; $i++) {
            $dataKursi[] = $row['nama_baris'] . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
        }
    }
}
// echo json_encode($dataKursi);
// die();
// foreach ($dataKursi as $k) {
//     // echo json_encode($k);
//     for ($i = 1; $i <= $k['jml_kursi']; $i++) {
//         echo $k['nama_baris'] . str_pad($i, 2, '0', STR_PAD_LEFT);
//     }
//     die();
// }
$query2 = "SELECT * FROM reg_jadwal rg JOIN ref_predikat rp on rp.id_ref_predikat = rg.predikat WHERE id_jadwal = $id
ORDER BY rank_posisi ASC ,ipk DESC";
$result2 = mysqli_query($linkDB, $query2);

$dataPeserta = [];
$i = 0;
if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        if (empty($dataKursi[$i])) {
            echo json_encode(['error' => true, 'message' => "Jumlah Kursi Kurang!!"]);
            return;
        }
        $codeContents = $row2['id_reg_jadwal'] . $dataKursi[$i] . time();
        $fileName = $row2['id_reg_jadwal']  . '.png';
        $pngAbsoluteFilePath = $tempDir . $fileName;
        if (file_exists($pngAbsoluteFilePath))
            unlink($pngAbsoluteFilePath);
        QRcode::png($codeContents, $pngAbsoluteFilePath);
        $mdcode = md5($codeContents);
        $sql_update = "UPDATE reg_jadwal SET  status_reg = '2', nomor_kursi = '{$dataKursi[$i]}', qrcode= '{$mdcode}' WHERE  id_reg_jadwal = {$row2['id_reg_jadwal']}";
        mysqli_query($linkDB, $sql_update);
        // echo $sql_update;
        // die();

        $i++;
    }
}
$sql_update = "UPDATE jadwal SET status = 2 WHERE  id_jadwal = {$id}";
mysqli_query($linkDB, $sql_update);



echo json_encode($dataPeserta);
