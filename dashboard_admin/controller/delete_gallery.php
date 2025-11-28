<?php
include '../model/config_db.php';

$id = $_GET['id'];

// hapus data
pg_query($conn, "DELETE FROM gallery WHERE id = $id");

header("Location: ../view/gallery.php");
exit;
?>
