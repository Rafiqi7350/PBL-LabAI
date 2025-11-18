<?php
include '../config/config_db.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$deskripsi = $_POST['deskripsi'];

// Ambil data lama untuk cek gambar lama
$result = pg_query($conn, "SELECT gambar FROM products WHERE id = '$id'");
$row = pg_fetch_assoc($result);
$oldgambar = $row['gambar'];

if (!empty($_FILES['gambar']['name'])) {
    $targetDir = realpath(__DIR__ . '/../assets/img/products/');
    if (!$targetDir) {
        mkdir(__DIR__ . '/../assets/img/products/', 0777, true);
        $targetDir = realpath(__DIR__ . '/../assets/img/products/');
    }

    $fileName = time() . '_' . basename($_FILES["gambar"]["name"]);
    $targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
        // Hapus gambar lama (jika ada)
        if ($oldgambar && file_exists($targetDir . '/' . $oldgambar)) {
            unlink($targetDir . '/' . $oldgambar);
        }

        $query = "UPDATE products 
                  SET nama='$nama', deskripsi='$deskripsi', gambar='$fileName'
                  WHERE id='$id'";
    } else {
        echo "Upload gambar gagal.";
        exit;
    }
} else {
    // Kalau tidak ganti gambar
    $query = "UPDATE products 
              SET nama='$nama', deskripsi='$deskripsi'
              WHERE id='$id'";
}

$result = pg_query($conn, $query);

if ($result) {
    header("Location: ../pages/products.php");
    exit;
} else {
    echo "Gagal memperbarui data.";
}
?>
