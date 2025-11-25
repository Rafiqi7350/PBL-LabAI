<?php 
include '../model/config_db.php';

$mode = $_GET['mode'] ?? null;

// === CREATE ===
if($mode === 'create'){
    $judul = $_POST['judul'];
$isi = $_POST['isi'];
$tanggal = $_POST['tanggal'];
$kategori = $_POST['kategori'];

$targetDir = "../assets/img/news/";

if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

$fileName = time() . '_' . basename($_FILES["foto"]["name"]);
$targetFilePath = $targetDir . $fileName;

move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath);

$query = "INSERT INTO news (judul, isi, tanggal, kategori, foto)
          VALUES ('$judul', '$isi', '$tanggal', '$kategori', '$fileName')";

pg_query($conn, $query);

header("Location: ../pages/news.php");
exit;
}


// === UPDATE ===
if($mode === 'update'){
   
    $id = $_POST['id'];
$judul = $_POST['judul'];
$isi = $_POST['isi'];
$tanggal = $_POST['tanggal'];
$kategori = $_POST['kategori'];

}

?>