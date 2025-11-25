<?php
include '../config/config_db.php';

if (!isset($_GET['id'])) {
    die("ID produk tidak ditemukan.");
}

$id = $_GET['id'];

// Ambil gambar untuk dihapus dari folder
$getgambar = pg_query($conn, "SELECT gambar FROM products WHERE id = $id");
$data = pg_fetch_assoc($getgambar);

if ($data && !empty($data['gambar'])) {
    $filePath = realpath(__DIR__ . '/../assets/img/products/' . $data['gambar']);
    if ($filePath && file_exists($filePath)) {
        unlink($filePath);
    }
}

// Hapus data produk
$query = "DELETE FROM products WHERE id = $id";
$result = pg_query($conn, $query);

if ($result) {
    header("Location: ../pages/products.php");
    exit;
} else {
    echo "Gagal menghapus produk!";
}
