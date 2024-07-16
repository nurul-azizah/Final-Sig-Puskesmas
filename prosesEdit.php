<?php
include 'konek.php';
if (isset($_POST['btnEdit'])) {
    $id_lokasi = $_POST['id_lokasi'];
    $latlng = $_POST['latlng'];
    $keterangan_tempat = $_POST['keterangan_tempat'];
    $jalan = $_POST['jalan'];
    $kecamatan = $_POST['kecamatan'];

    if ($_FILES['gambar']['name'] != "") {
        $stmt = $konek->prepare("SELECT gambar FROM tb_lokasi WHERE id_lokasi = ?");
        $stmt->bind_param("i", $id_lokasi);
        $stmt->execute();
        $result = $stmt->get_result();
        $hasil = $result->fetch_assoc();
        if ($hasil['gambar']) {
            unlink("gambar/" . $hasil['gambar']);
        }

        $gambar = $_FILES['gambar']['name'];
        $dir = 'gambar/';
        $dirFile = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($dirFile, $dir . $gambar);
        
        $stmt = $konek->prepare("UPDATE tb_lokasi SET latlng = ?, keterangan_tempat = ?, jalan = ?, kecamatan = ?, gambar = ? WHERE id_lokasi = ?");
        $stmt->bind_param("sssssi", $latlng, $keterangan_tempat, $jalan, $kecamatan, $gambar, $id_lokasi);
    } else {
        $stmt = $konek->prepare("UPDATE tb_lokasi SET latlng = ?, keterangan_tempat = ?, jalan = ?, kecamatan = ? WHERE id_lokasi = ?");
        $stmt->bind_param("ssssi", $latlng, $keterangan_tempat, $jalan, $kecamatan, $id_lokasi);
    }

    if ($stmt->execute()) {
        header('location:tabel.php');
    } else {
        echo "Error updating record: " . $stmt->error;
    }
    $stmt->close();
}
?>