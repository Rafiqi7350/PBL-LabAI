<?php
include '../config/config_db.php';

$id = $_GET['id'];

// Hapus file logo dulu
$getLogo = pg_query($conn, "SELECT logo FROM partners WHERE id = $id");
if ($row = pg_fetch_assoc($getLogo)) {
    $filePath = realpath(__DIR__ . '/../assets/img/' . $row['logo']);
    if ($filePath && file_exists($filePath)) {
        unlink($filePath);
    }
}

// Hapus data dari database
pg_query($conn, "DELETE FROM partners WHERE id = $id");

header("Location: ../pages/partners.php");
exit;
?>
