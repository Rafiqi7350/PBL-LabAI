<?php
include '../model/config_db.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$kategori = $_POST['kategori'];

if (!empty($_FILES["logo"]["name"])) {
    $targetDir = realpath(__DIR__ . '/../assets/img/partners/');
    if (!$targetDir) {
        mkdir(__DIR__ . '/../assets/img/partners/', 0777, true);
        $targetDir = realpath(__DIR__ . '/../assets/img/partners/');
    }

    $fileName = time() . '_' . basename($_FILES["logo"]["name"]);
    $targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

    if (move_uploaded_file($_FILES["logo"]["tmp_name"], $targetFilePath)) {
        $query = "UPDATE partners SET nama='$nama', kategori='$kategori', logo='$fileName' WHERE id=$id";
    } else {
        echo "❌ Upload gagal!";
        exit;
    }
} else {
    $query = "UPDATE partners SET nama='$nama', kategori='$kategori' WHERE id=$id";
}

$result = pg_query($conn, $query);

if ($result) {
    header("Location: ../view/partners.php");
    exit;
} else {
    echo "❌ Gagal update data: " . pg_last_error($conn);
}
?>
