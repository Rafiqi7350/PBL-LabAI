<?php
include '../config/config_db.php';

$id = $_GET['id'];

// Ambil foto
$data = pg_fetch_assoc(pg_query($conn, "SELECT foto FROM members WHERE id = $id"));
$foto = $data['foto'];

$folder = __DIR__ . '/../assets/img/members/';

// Hapus foto jika ada
if ($foto && file_exists($folder . $foto)) {
    unlink($folder . $foto);
}

// Delete dari DB
$query = "DELETE FROM members WHERE id = $id";
pg_query($conn, $query);

header("Location: ../pages/members.php");
exit;
?>
