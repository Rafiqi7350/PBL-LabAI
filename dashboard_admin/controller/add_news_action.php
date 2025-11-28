<?php
include '../model/config_db.php';

// Ambil data dari form
$judul = $_POST['judul'];
$isi = $_POST['isi'];

// Konversi datetime-local → PostgreSQL timestamp
if (!empty($_POST['tanggal'])) {
    $tanggal = str_replace('T', ' ', $_POST['tanggal']);
} else {
    $tanggal = date('Y-m-d H:i:s');
}

// Folder upload utama (dashboard_admin)
$targetDir = __DIR__ . "/../assets/img/news/";

// Folder tujuan kedua (new_page)
$copyDir = __DIR__ . "/../web_page/";

// Pastikan folder utama ada
if (!is_dir($targetDir)) {
    mkdir($targetDir, 0777, true);
}

// Pastikan folder new_page ada
if (!is_dir($copyDir)) {
    mkdir($copyDir, 0777, true);
}

// Nama file unik
$fileName = time() . '_' . basename($_FILES["gambar"]["name"]);
$targetFilePath = $targetDir . $fileName;
$copyFilePath = $copyDir . $fileName;

// Upload ke folder utama
if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {

    // Salin otomatis ke folder new_page
    copy($targetFilePath, $copyFilePath);

    // Simpan ke database
    $query = "INSERT INTO news (judul, isi, tanggal, gambar)
              VALUES ('$judul', '$isi', '$tanggal', '$fileName')";
    $result = pg_query($conn, $query);

    if (!$result) {
        echo "Query error: " . pg_last_error($conn);
        exit;
    }

    header("Location: ../view/news.php");
    exit;

} else {
    echo "❌ Upload gambar gagal: $targetFilePath";
}
?>
