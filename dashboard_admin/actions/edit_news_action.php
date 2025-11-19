<?php
include '../config/config_db.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$isi = $_POST['isi'];
$kategori = $_POST['kategori'];
$tanggal = $_POST['tanggal'];

$fotoQuery = "";
$dir = realpath(__DIR__ . '/../assets/img/news/');

if (!empty($_FILES["gambar"]["name"])) {
    $fileName = time() . "_" . basename($_FILES["gambar"]["name"]);
    move_uploaded_file($_FILES["gambar"]["tmp_name"], $dir . "/" . $fileName);
    $gambarQuery = ", gambar = '$fileName'";
}

$query = "UPDATE news SET 
          judul='$judul',
          isi='$isi',
          kategori='$kategori',
          tanggal='$tanggal'
          $fotoQuery
          WHERE id=$id";

$run = pg_query($conn, $query);
header("Location: ../pages/news.php");
