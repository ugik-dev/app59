<?php

if ($linkDB->query($sql) === TRUE) {
    echo json_encode(['error' => false, 'message' => 'Berhasil']);
} else {
    echo json_encode(['error' => true, 'message' => "Gagal! " . mysqli_errno($linkDB) . ": " . mysqli_error($linkDB) . ""]);
    // echo "Error: " . $sql . "<br>" . $conn->error;
}
