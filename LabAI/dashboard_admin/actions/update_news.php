<?php
include '../config/config_db.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$isi = $_POST['isi'];
$tanggal = $_POST['tanggal'];
$kategori = $_POST['kategori'];

$targetDir = "../assets/img/news/";

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$updateFoto = "";

if (!empty($_FILES['foto']['name'])) {
    $fileName = time() . '_' . basename($_FILES['foto']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {
        $updateFoto = ", foto='$fileName'";
    }
}

$query = "
    UPDATE news 
    SET judul='$judul',
        isi='$isi',
        tanggal='$tanggal',
        kategori='$kategori'
        $updateFoto
    WHERE id=$id
";

pg_query($conn, $query);

header("Location: ../pages/news.php");
exit;
?>
