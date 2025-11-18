<?php
include '../config/config_db.php';

$nama = $_POST['nama'];
$role = $_POST['role'];
$deskripsi = $_POST['deskripsi'];

// Path aman (absolute)
$basePath = __DIR__ . '/../assets/img/members/';

// Jika folder tidak ada → buat
if (!is_dir($basePath)) {
    mkdir($basePath, 0777, true);
}

// Nama file unik
$fileName = time() . '_' . basename($_FILES["foto"]["name"]);
$targetFilePath = $basePath . $fileName;

// Upload file
if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {

    // Simpan ke database
    $query = "INSERT INTO members (nama, role, deskripsi, foto)
              VALUES ('$nama', '$role', '$deskripsi', '$fileName')";

    $result = pg_query($conn, $query);

    if ($result) {
        header("Location: ../pages/members.php");
        exit;
    } else {
        echo "❌ Gagal menyimpan ke database: " . pg_last_error($conn);
    }

} else {
    echo "❌ Upload foto gagal ke: $targetFilePath";
}
?>
