<?php
include '../config/config_db.php';

$nama = $_POST['nama'];
$role = $_POST['role'];
$deskripsi = $_POST['deskripsi'];

// Path fix ke folder members
$folder = __DIR__ . '/../assets/img/members/';

if (!is_dir($folder)) {
    mkdir($folder, 0777, true);
}

// Buat nama file unik
$fileName = time() . '_' . basename($_FILES['foto']['name']);
$destPath = $folder . $fileName;

// Upload foto
if (move_uploaded_file($_FILES['foto']['tmp_name'], $destPath)) {

    $query = "INSERT INTO members (nama, role, deskripsi, foto)
              VALUES ('$nama', '$role', '$deskripsi', '$fileName')";

    $result = pg_query($conn, $query);

    if ($result) {
        header("Location: ../pages/members.php");
        exit;
    } else {
        echo "❌ DB Error: " . pg_last_error($conn);
    }

} else {
    echo "❌ Upload gagal ke: $destPath";
}
?>
