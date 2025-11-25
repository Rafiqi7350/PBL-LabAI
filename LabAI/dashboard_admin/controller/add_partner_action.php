<?php
include '../config/config_db.php';

$nama = $_POST['nama'];
$kategori = $_POST['kategori'];

$targetDir = realpath(__DIR__ . '/../assets/img/partners/');
if (!$targetDir) {
    mkdir(__DIR__ . '/../assets/img/partners/', 0777, true);
    $targetDir = realpath(__DIR__ . '/../assets/img/partners/');
}

$fileName = time() . '_' . basename($_FILES["logo"]["name"]);
$targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFilePath)) {
    $query = "INSERT INTO partners (nama, kategori, logo)
              VALUES ('$nama', '$kategori', '$fileName')";
    $result = pg_query($conn, $query);

    if ($result) {
        header("Location: ../pages/partners.php");
        exit;
    } else {
        echo "❌ Gagal menyimpan ke database: " . pg_last_error($conn);
    }
} else {
    echo "❌ Upload logo gagal!";
}
?>
