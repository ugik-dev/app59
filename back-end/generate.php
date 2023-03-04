<?php
session_start();
include('../linkDB.php');
include('../lib/phpqrcode/qrlib.php');
$tempDir = "../qrcode/";


$id = $_GET['id'];

$query = "SELECT * FROM ref_baris as j where jenis = 1 ORDER BY nama_baris asc
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

$queryO = "SELECT * FROM ref_baris as j where jenis = 2 ORDER BY nama_baris asc
";
$resultO = mysqli_query($linkDB, $queryO);

$dataKursiOrtu = [];
if ($resultO->num_rows > 0) {
    while ($rowO = $resultO->fetch_assoc()) {
        for ($i = 1; $i <= $rowO['jml_kursi']; $i++) {
            $dataKursiOrtu[] = $rowO['nama_baris'] . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
        }
    }
}


// echo json_encode($dataKursiOrtu);
// die();
// foreach ($dataKursi as $k) {
//     // echo json_encode($k);
//     for ($i = 1; $i <= $k['jml_kursi']; $i++) {
//         echo $k['nama_baris'] . str_pad($i, 2, '0', STR_PAD_LEFT);
//     }
//     die();
// }


$dataPeserta = [];
$i = 0;

$query2 = "SELECT * FROM reg_jadwal rg 
JOIN ref_predikat rp on rp.id_ref_predikat = rg.predikat 
JOIN fakultas_jurusan fj on fj.id_fakultas_jurusan = rg.fakultas_jurusan 
WHERE id_jadwal = $id AND predikat in (1,2)
ORDER BY rank_posisi ASC , no_urut";
// echo $query2;
// die();
$result2 = mysqli_query($linkDB, $query2);

function cek_next($a, $b, $dataKursi)
{
    $plus = 0;
    for ($x = $a + 1; $x <= $b; $x++) {
        if (explode('-', $dataKursi[$a])[0] !=  explode('-', $dataKursi[$x])[0]) {
            // echo $x;
            // die();
            return $x;
        }
    }
    return $a;
    // die();
    // if (explode('-', $dataKursi[$a])[0] !=  explode('-', $dataKursi[$a + 1])[0]) {
    // }
    // echo $b;
    // die();
}

if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {

        $i = cek_next($i, $i + 2, $dataKursi);

        if (empty($dataKursi[$i]) or empty($dataKursi[$i + 1] or empty($dataKursi[$i + 2]))) {
            echo json_encode(['error' => true, 'message' => "Jumlah Kursi Kurang!!"]);
            return;
        }
        $codeContents = $row2['id_reg_jadwal'] . $dataKursi[$i] . time();
        $fileName = $row2['id_reg_jadwal']  . '.png';
        $pngAbsoluteFilePath = $tempDir . $fileName;
        if (file_exists($pngAbsoluteFilePath))
            unlink($pngAbsoluteFilePath);
        QRcode::png($codeContents, $pngAbsoluteFilePath);

        $codeContents2 = $codeContents . '_ortu';
        $fileName2 = $row2['id_reg_jadwal']  . '_ortu.png';
        $pngAbsoluteFilePath2 = $tempDir . $fileName2;
        if (file_exists($pngAbsoluteFilePath2))
            unlink($pngAbsoluteFilePath2);
        QRcode::png($codeContents2, $pngAbsoluteFilePath2);
        $sql_update = "UPDATE reg_jadwal SET  status_reg = '2',status_ortu = '2', 
        nomor_kursi = '{$dataKursi[$i + 1]}', qrcode= '{$codeContents}' ,
        nomor_kursi_ortu = '{$dataKursi[$i]},{$dataKursi[$i + 2]}', qrcode_ortu= '{$codeContents2}' 

        WHERE  id_reg_jadwal = {$row2['id_reg_jadwal']}";
        mysqli_query($linkDB, $sql_update);
        // echo $sql_update;
        // die();

        $i = $i + 3;
    }
}
// die();
// GENERATE NON SPESIAL
$query2 = "SELECT * FROM reg_jadwal rg 
JOIN ref_predikat rp on rp.id_ref_predikat = rg.predikat 
JOIN fakultas_jurusan fj on fj.id_fakultas_jurusan = rg.fakultas_jurusan 
WHERE id_jadwal = $id AND predikat NOT in (1,2)
ORDER BY  no_urut";
// echo $query2;
// die();
$result2 = mysqli_query($linkDB, $query2);
$j = 0;
if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $j = cek_next($j, $j + 1, $dataKursiOrtu);

        if (empty($dataKursiOrtu[$j]) or empty($dataKursiOrtu[$j + 1]) or empty($dataKursi[$i])) {
            echo json_encode(['error' => true, 'message' => "Jumlah Kursi Kurang!!"]);
            return;
        }
        $codeContents = $row2['id_reg_jadwal'] . $dataKursi[$i] . time();
        $fileName = $row2['id_reg_jadwal']  . '.png';
        $pngAbsoluteFilePath = $tempDir . $fileName;
        if (file_exists($pngAbsoluteFilePath))
            unlink($pngAbsoluteFilePath);
        QRcode::png($codeContents, $pngAbsoluteFilePath);

        $codeContents2 = $codeContents . '_ortu';
        $fileName2 = $row2['id_reg_jadwal']  . '_ortu.png';
        $pngAbsoluteFilePath2 = $tempDir . $fileName2;
        if (file_exists($pngAbsoluteFilePath2))
            unlink($pngAbsoluteFilePath2);
        QRcode::png($codeContents2, $pngAbsoluteFilePath2);


        $sql_update = "UPDATE reg_jadwal SET  status_reg = '2', status_ortu = '2',
        nomor_kursi = '{$dataKursi[$i]}', qrcode= '{$codeContents}' ,
        nomor_kursi_ortu = '{$dataKursiOrtu[$j]},{$dataKursiOrtu[$j + 1]}', qrcode_ortu= '{$codeContents2}' 

        WHERE  id_reg_jadwal = {$row2['id_reg_jadwal']}";
        // if ($row2['id_reg_jadwal'] == 35) {
        //     echo $sql_update;
        //     die();
        // }
        mysqli_query($linkDB, $sql_update);
        // echo $sql_update;
        // die();

        $i++;
        $j = $j + 2;
    }
}
$sql_update = "UPDATE jadwal SET status = 2 WHERE  id_jadwal = {$id}";
mysqli_query($linkDB, $sql_update);



echo json_encode($dataPeserta);
