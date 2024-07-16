<?php
include 'konek.php';

if (isset($_POST['btnTambah'])) {
    $latlng = $_POST['latlng'];
    $keterangan_tempat = $_POST['keterangan_tempat'];
    $jalan = $_POST['jalan'];
    $kecamatan = $_POST['kecamatan'];



    $gambar = $_FILES['gambar']['name'];
    $dir = 'gambar/';
    $dirFile = $_FILES['gambar']['tmp_name'];

    if (move_uploaded_file($dirFile, $dir . $gambar)) {
        $query = mysqli_query($konek, "INSERT INTO tb_lokasi (latlng, keterangan_tempat, jalan, kecamatan, gambar) VALUES ('$latlng', '$keterangan_tempat', '$jalan', '$kecamatan', '$gambar')");

        if ($query) {
            header('Location: tabel.php');
        } else {
            echo "Error: " . mysqli_error($konek);
        }
    } else {
        echo "Failed to upload image.";
    }
}
