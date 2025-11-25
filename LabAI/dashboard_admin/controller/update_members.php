<?php
include '../config/config_db.php';

$id = $_POST['id'];
$nama = $_POST['nama'];
$role = $_POST['role'];
$deskripsi = $_POST['deskripsi'];

// Lokasi folder FIX
$folder = realpath(__DIR__ . '/../assets/img/members/');

if (!$folder) {
    mkdir(__DIR__ . '/../assets/img/members/', 0777, true);
    $folder = realpath(__DIR__ . '/../assets/img/members/');
}

// Ambil data lama
$old = pg_fetch_assoc(pg_query($conn, "SELECT foto FROM members WHERE id = $id"));
$oldFoto = $old['foto'];

// Jika ada foto baru
if (!empty($_FILES['foto']['name'])) {

    $fileName = time() . '_' . basename($_FILES['foto']['name']);
    $dest = $folder . '/' . $fileName;

    if (move_uploaded_file($_FILES['foto']['tmp_name'], $dest)) {

        // Hapus foto lama
        if ($oldFoto && file_exists($folder . '/' . $oldFoto)) {
            unlink($folder . '/' . $oldFoto);
        }

        $query = "UPDATE members 
                  SET nama='$nama', role='$role', deskripsi='$deskripsi', foto='$fileName'
                  WHERE id=$id";
    } else {
        echo "Upload foto gagal ke: $dest";
        exit;
    }

} else {
    // Tanpa ganti foto
    $query = "UPDATE members 
              SET nama='$nama', role='$role', deskripsi='$deskripsi'
              WHERE id=$id";
}

pg_query($conn, $query);

header("Location: ../pages/members.php");
exit;
?>
