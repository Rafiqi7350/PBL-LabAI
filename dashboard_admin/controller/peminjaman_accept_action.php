<?php
include '../config/config_db.php';

$id = $_GET['id'];

pg_query($conn, "UPDATE peminjaman SET status='diterima' WHERE id=$id");

header("Location: ../view/peminjaman.php");
exit;
?>
