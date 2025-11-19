<?php
include '../config/config_db.php';

$id = $_POST['id'];
$judul = $_POST['judul'];
$deskripsi = $_POST['deskripsi'];

if (!empty($_FILES['gambar']['name'])) {
    $targetDir = realpath(__DIR__ . '/../assets/img/gallery/');
    $fileName = time() . '_' . basename($_FILES["gambar"]["name"]);
    $targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
        $query = "UPDATE gallery SET judul='$judul', deskripsi='$deskripsi', gambar='$fileName' WHERE id=$id";
    } else {
        echo "❌ Gagal upload gambar baru!";
        exit;
    }
} else {
    $query = "UPDATE gallery SET judul='$judul', deskripsi='$deskripsi' WHERE id=$id";
}

$result = pg_query($conn, $query);

if ($result) {
    header("Location: ../pages/gallery.php");
} else {
    echo "❌ Gagal memperbarui data!";
}
?>
