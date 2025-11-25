<?php
include '../model/config_db.php';

$mode = $_GET['mode'] ?? null;

// direktori upload 
$targetDir = realpath(__DIR__ . '/../assets/img/members/');
if (!$targetDir) {
    mkdir(__DIR__ . '/../assets/img/gallery/', 0777, true);
    $targetDir = realpath(__DIR__ . '/../assets/img/gallery/');
}


// === CREATE ===
if ($mode === 'create') {

    $nama = $_POST['nama'];
    $role = $_POST['role'];
    $deskripsi = $_POST['deskripsi'];

    // Path aman (absolute)
    $basePath = __DIR__ . '/../assets/img/members/';

    // Jika folder tidak ada → buat
    if (!is_dir($basePath)) {
        mkdir($basePath, 0777, true);
    }

    // Nama file unik
    $fileName = time() . '_' . basename($_FILES["foto"]["name"]);
    $targetFilePath = $basePath . $fileName;

    // Upload file
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $targetFilePath)) {

        // Simpan ke database
        $query = "INSERT INTO members (nama, role, deskripsi, foto)
              VALUES ('$nama', '$role', '$deskripsi', '$fileName')";

        $result = pg_query($conn, $query);

        if ($result) {
            header("Location: ../pages/members.php");
            exit;
        } else {
            echo "❌ Gagal menyimpan ke database: " . pg_last_error($conn);
        }
    } else {
        echo "❌ Upload foto gagal ke: $targetFilePath";
    }
}


// === EDIT ===
if ($mode === 'edit') {

    $nama = $_POST['nama'];
    $role = $_POST['role'];
    $deskripsi = $_POST['deskripsi'];

    // Path fix ke folder members
    $folder = __DIR__ . '/../assets/img/members/';

    if (!is_dir($folder)) {
        mkdir($folder, 0777, true);
    }

    // Buat nama file unik
    $fileName = time() . '_' . basename($_FILES['foto']['name']);
    $destPath = $folder . $fileName;


    // Upload foto
    if (move_uploaded_file($_FILES['foto']['tmp_name'], $destPath)) {

        $query = "INSERT INTO members (nama, role, deskripsi, foto)
              VALUES ('$nama', '$role', '$deskripsi', '$fileName')";

        $result = pg_query($conn, $query);

        if ($result) {
            header("Location: ../pages/members.php");
            exit;
        } else {
            echo "❌ DB Error: " . pg_last_error($conn);
        }
    } else {
        echo "❌ Upload gagal ke: $destPath";
    }
}


// === DELETE ===
if ($mode === 'delete') {
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
}
