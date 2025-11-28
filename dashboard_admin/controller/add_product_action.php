<?php
include '../model/config_db.php';

$nama = $_POST['nama'];
$deskripsi = $_POST['deskripsi'];

// Buat folder kalau belum ada
$targetDir = realpath(__DIR__ . '/../assets/img/products/');
if (!$targetDir) {
    mkdir(__DIR__ . '/../assets/img/products/', 0777, true);
    $targetDir = realpath(__DIR__ . '/../assets/img/products/');
}

// Nama file unik
$fileName = time() . '_' . basename($_FILES["gambar"]["name"]);
$targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

// Upload file foto
if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
    // Simpan data ke database 
    $query = "INSERT INTO products (nama, deskripsi, gambar)
              VALUES ('$nama', '$deskripsi', '$fileName')";
    $result = pg_query($conn, $query);

    if ($result) {
        header("Location: ../view/products.php");
        exit;
    } else {
        echo "Gagal menyimpan ke database.";
    }
} else {
    echo "Gagal mengunggah foto.";
}
?>
