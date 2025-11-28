<?php
include '../model/config_db.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$isi = $_POST['isi'];
$tanggal = $_POST['tanggal'];

$targetDir = "../assets/img/news/";

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$updateGambar = "";

if (!empty($_FILES['gambar']['name'])) {
    $fileName = time() . '_' . basename($_FILES['gambar']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
        $updateGambar = ", gambar='$fileName'";
    }
}

$query = "
    UPDATE news 
    SET judul='$judul',
        isi='$isi',
        tanggal='$tanggal',
        $updateGambar
    WHERE id=$id
";

pg_query($conn, $query);

header("Location: ../view/news.php");
exit;
?>
