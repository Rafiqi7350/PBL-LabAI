<?php
include '../model/config_db.php';

// direktori upload 
$targetDir = realpath(__DIR__ . '/../assets/img/gallery/');
if (!$targetDir) {
    mkdir(__DIR__ . '/../assets/img/gallery/', 0777, true);
    $targetDir = realpath(__DIR__ . '/../assets/img/gallery/');
}

$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];

$fileName = time() . '_' . basename($_FILES["gambar"]["name"]);
$targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {

    $query = "INSERT INTO gallery (judul, gambar, deskripsi)
              VALUES ('$judul', '$fileName', '$deskripsi')";

    $result = pg_query($conn, $query);

    if ($result) {
        header("Location: ../view/gallery.php");
        exit;
    } else {
        echo "❌ Gagal menyimpan ke database!";
    }

} else {
    echo "❌ Upload gambar gagal!";
}
?>
