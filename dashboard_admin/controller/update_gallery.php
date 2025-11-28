<?php
include '../model/config_db.php';

// Ambil data dari form
$id = $_POST['id'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];

// Folder upload
$targetDir = realpath(__DIR__ . '/../assets/img/gallery/');

// Cek apakah user upload gambar baru
if (!empty($_FILES['gambar']['name'])) {

    // Nama file baru
    $fileName = time() . '_' . basename($_FILES["gambar"]["name"]);
    $targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

    // Upload gambar baru
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {

        // UPDATE dengan mengganti gambar
        $query = "UPDATE gallery 
                  SET judul = '$judul',
                      deskripsi = '$deskripsi',
                      gambar = '$fileName'
                  WHERE id = $id";

    } else {
        echo "❌ Gagal upload gambar baru!";
        exit;
    }

} else {

    // UPDATE tanpa mengganti gambar
    $query = "UPDATE gallery 
              SET judul = '$judul',
                  deskripsi = '$deskripsi'
              WHERE id = $id";
}

// Eksekusi query
$result = pg_query($conn, $query);

if ($result) {
    header("Location: ../view/gallery.php");
    exit;
} else {
    echo "❌ Gagal memperbarui data!";
}
?>
