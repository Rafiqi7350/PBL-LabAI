<?php
include '../model/config_db.php';

// Jika form dikirim
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama        = $_POST['nama'];
    $nim         = $_POST['nim'];
    $no_hp        = $_POST['no_hp'];
    $keperluan   = $_POST['keperluan'];
    $tanggal_mulai   = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $waktu_mulai   = $_POST['waktu$waktu_mulai'];
    $waktu_selesai = $_POST['wak$waktu_selesai'];

    // Gabungkan tanggal + jam
    $waktu_mulai   = $tanggal_mulai . " " . $waktu_mulai;
    $waktu_selesai = $tanggal_selesai . " " . $waktu_selesai;

    // Simpan ke database
    $query = "INSERT INTO peminjaman_ruang (nama, nim, no_hp, keperluan, waktu_mulai, waktu_selesai, status)
              VALUES ($1, $2, $3, $4, $5, $6, 'Menunggu Konfirmasi')";
    $result = pg_query_params($conn, $query, [$nama, $nim, $no_hp, $keperluan, $tanggal_mulai, $tanggal_selesai, $waktu_mulai, $waktu_selesai]);

    if ($result) {
        $success = true;
    } else {
        $error = "Gagal mengirim data!";
    }
}
