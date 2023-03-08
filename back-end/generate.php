<?php
session_start();
include('../linkDB.php');
include('../lib/phpqrcode/qrlib.php');
$tempDir = "../qrcode/";


$id = $_GET['id'];

$query_khusus = "SELECT * FROM ref_baris as j where jenis = 1 and khusus = 'Y' ORDER BY nama_baris asc ";
$result_khusus = mysqli_query($linkDB, $query_khusus);

$dataKursiKhusus = [];
if ($result_khusus->num_rows > 0) {
    while ($row = $result_khusus->fetch_assoc()) {
        for ($i = 1; $i <= $row['jml_kursi']; $i++) {
            $dataKursiKhusus[] = $row['nama_baris'] . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
        }
    }
}


$query_ortu = "SELECT * FROM ref_baris as j where jenis = 2 ORDER BY nama_baris asc
";
$result_ortu = mysqli_query($linkDB, $query_ortu);

$dataKursiOrtu = [];
if ($result_ortu->num_rows > 0) {
    while ($rowO = $result_ortu->fetch_assoc()) {
        for ($i = 1; $i <= $rowO['jml_kursi']; $i++) {
            $dataKursiOrtu[] = $rowO['nama_baris'] . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
        }
    }
}


$dataPeserta = [];
$i = 0;
$j = 0;

$query2 = "SELECT * FROM reg_jadwal rg 
JOIN ref_predikat rp on rp.id_ref_predikat = rg.predikat 
JOIN fakultas_jurusan fj on fj.id_fakultas_jurusan = rg.fakultas_jurusan 
WHERE id_jadwal = $id AND predikat in (1,2)
ORDER BY rank_posisi ASC , no_urut";

$result2 = mysqli_query($linkDB, $query2);

function cek_next($a, $b, $dataKursi)
{
    $plus = 0;
    if (empty($dataKursi[$a]) or empty($dataKursi[$b])) {
        echo json_encode(['error' => true, 'message' => "Jumlah Kursi Wali Mahasiswa Kurang!!"]);
        // return 'error';
        die();
    }
    for ($x = $a + 1; $x <= $b; $x++) {
        if (empty($dataKursi[$x])) {
            echo json_encode(['error' => true, 'message' => "Jumlah Kursi Wali Mahasiswa Kurang!!"]);
            // return false;
            die();
        }
        if (explode('-', $dataKursi[$a])[0] !=  explode('-', $dataKursi[$x])[0]) {
            // $j++;
            return $x;
        }
    }
    return $a;
}

if ($result2->num_rows > 0) {
    while ($row2 = $result2->fetch_assoc()) {
        $j = cek_next($j, $j + 1, $dataKursiOrtu);
        // die();
        if (empty($dataKursiOrtu[$j]) or empty($dataKursiOrtu[$j + 1]) or empty($dataKursiKhusus[$i])) {
            echo json_encode(['error' => true, 'message' => "Jumlah Kursi Kurang!!"]);
            return;
        }

        $codeContents = $row2['id_reg_jadwal'] . $dataKursiKhusus[$i] . time();
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
        nomor_kursi = '{$dataKursiKhusus[$i]}', qrcode= '{$codeContents}',
        nomor_kursi_ortu = '{$dataKursiOrtu[$j]},{$dataKursiOrtu[$j + 1]}', qrcode_ortu= '{$codeContents2}' 
        WHERE  id_reg_jadwal = {$row2['id_reg_jadwal']}";
        mysqli_query($linkDB, $sql_update);
        $i++;
        $j = $j + 2;
    }
}
// die();
// GENERATE NON SPESIAL
$query_jurusan = "SELECT * FROM fakultas as j 
                       ";
$result_jurusan = mysqli_query($linkDB, $query_jurusan);
if ($result_jurusan->num_rows > 0) {
    while ($row_jurusan = $result_jurusan->fetch_assoc()) {
        // echo json_encode($dataKursiKhusus);
        // echo json_encode($row_jurusan);
        // die();
        $query_mhs = "SELECT * FROM ref_baris as j 
        where jenis = 1 and khusus = 'N' and fakultas = '{$row_jurusan['id_fakultas']}' 
        ORDER BY nama_baris asc ";
        $result_mhs = mysqli_query($linkDB, $query_mhs);

        $dataKursiMhs = [];
        if ($result_mhs->num_rows > 0) {
            while ($row = $result_mhs->fetch_assoc()) {
                for ($i = 1; $i <= $row['jml_kursi']; $i++) {
                    $dataKursiMhs[] = $row['nama_baris'] . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
                }
            }
        }

        $query2 = "SELECT * FROM reg_jadwal rg 
            JOIN ref_predikat rp on rp.id_ref_predikat = rg.predikat 
            JOIN fakultas_jurusan fj on fj.id_fakultas_jurusan = rg.fakultas_jurusan 
            JOIN fakultas f on f.id_fakultas = fj.fakultas 
            WHERE id_jadwal = $id AND predikat NOT in (1,2) AND fj.fakultas = '{$row_jurusan['id_fakultas']}' 
            ORDER BY  no_urut";

        $result_perjurusan = mysqli_query($linkDB, $query2);
        $k = 0;
        $last_baris = explode('-', $dataKursiMhs[$k])[0];
        if ($result_perjurusan->num_rows > 0) {
            while ($row_perjurusan = $result_perjurusan->fetch_assoc()) {
                if (empty($dataKursiMhs[$k])) {
                    echo json_encode(['error' => true, 'message' => "Kursi kurang untuk " . $row_perjurusan['nama_fakultas'] . '-' . $row_perjurusan['nama_jurusan'] . '-' . $row_perjurusan['strata']]);
                    return;
                }
                if ($k == 0) {
                    $cur_strata = $row_perjurusan['strata'];
                } else {
                    if ($row_perjurusan['strata'] != $cur_strata) {

                        while ($last_baris == explode('-', $dataKursiMhs[$k])[0]) {
                            if (empty($dataKursiMhs[$k + 1])) {
                                echo json_encode(['error' => true, 'message' => "Kursi kurang untuk " . $row_perjurusan['nama_fakultas'] . '-' . $row_perjurusan['nama_jurusan'] . '-' . $row_perjurusan['strata']]);
                                return;
                            }
                            $k++;
                        }
                        $last_baris = explode('-', $dataKursiMhs[$k])[0];
                    }
                    // die();
                }
                $cur_strata = $row_perjurusan['strata'];

                // echo json_encode($row_perjurusan['strata']);
                // die();
                $j = cek_next($j, $j + 1, $dataKursiOrtu);
                // if (!$j) {
                //     return;
                // }
                // echo json_encode($dataKursiMhs);
                if (empty($dataKursiOrtu[$j]) or empty($dataKursiOrtu[$j + 1]) or empty($dataKursiMhs[$k])) {
                    echo json_encode(['error' => true, 'message' => "Jumlah Kursi Kurang!!"]);
                    return;
                }
                $codeContents = $row_perjurusan['id_reg_jadwal'] . $dataKursiMhs[$k] . time();
                $fileName = $row_perjurusan['id_reg_jadwal']  . '.png';
                $pngAbsoluteFilePath = $tempDir . $fileName;
                if (file_exists($pngAbsoluteFilePath))
                    unlink($pngAbsoluteFilePath);
                QRcode::png($codeContents, $pngAbsoluteFilePath);

                $codeContents2 = $codeContents . '_ortu';
                $fileName2 = $row_perjurusan['id_reg_jadwal']  . '_ortu.png';
                $pngAbsoluteFilePath2 = $tempDir . $fileName2;
                if (file_exists($pngAbsoluteFilePath2))
                    unlink($pngAbsoluteFilePath2);
                QRcode::png($codeContents2, $pngAbsoluteFilePath2);
                $sql_update = "UPDATE reg_jadwal SET  status_reg = '2', status_ortu = '2',
                nomor_kursi = '{$dataKursiMhs[$k]}', qrcode= '{$codeContents}',
                nomor_kursi_ortu = '{$dataKursiOrtu[$j]},{$dataKursiOrtu[$j + 1]}', qrcode_ortu= '{$codeContents2}' 
                WHERE  id_reg_jadwal = {$row_perjurusan['id_reg_jadwal']}";
                mysqli_query($linkDB, $sql_update);
                $k++;
                $j = $j + 2;
            }

            // die();
        }
    }
}
// die();

$sql_update = "UPDATE jadwal SET status = 2 WHERE  id_jadwal = {$id}";
mysqli_query($linkDB, $sql_update);



echo json_encode('');
