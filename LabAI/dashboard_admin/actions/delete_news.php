<?php
include '../config/config_db.php';

$id = $_GET['id'];

pg_query($conn, "DELETE FROM news WHERE id=$id");

header("Location: ../pages/news.php");
exit;
?>
