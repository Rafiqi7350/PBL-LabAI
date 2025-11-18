<?php
include '../config/config_db.php';
$id = $_GET['id'];
pg_query($conn, "DELETE FROM gallery WHERE id = $id");
header("Location: ../pages/gallery.php");
?>
