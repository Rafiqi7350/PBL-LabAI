<?php
include '../model/config_db.php';

$mode = $_GET['mode'] ?? null;

// direktori upload 
$targetDir = realpath(__DIR__ . '/../assets/img/gallery/');
if (!$targetDir) {
    mkdir(__DIR__ . '/../assets/img/gallery/', 0777, true);
    $targetDir = realpath(__DIR__ . '/../assets/img/gallery/');
}

// === CREATE ===
if ($mode === 'create') {
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    $fileName = time() . '_' . basename($_FILES["gambar"]["name"]);
    $targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
        $query = "INSERT INTO gallery (judul, gambar, deskripsi)
              VALUES ('$judul', '$fileName', '$deskripsi')";
        $result = pg_query($conn, $query);

        if ($result) {
            header("Location: ../pages/gallery.php");
            exit;
        } else {
            echo "❌ Gagal menyimpan ke database!";
        }
    } else {
        echo "❌ Upload gambar gagal!";
    }
}

// === UPDATE ===
if ($mode === 'edit') {
    
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $deskripsi = $_POST['deskripsi'];

    if (!empty($_FILES['gambar']['name'])) {
        $targetDir = realpath(__DIR__ . '/../assets/img/gallery/');
        $fileName = time() . '_' . basename($_FILES["gambar"]["name"]);
        $targetFilePath = $targetDir . DIRECTORY_SEPARATOR . $fileName;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFilePath)) {
            $query = "UPDATE gallery SET judul='$judul', deskripsi='$deskripsi', gambar='$fileName' WHERE id=$id";
        } else {
            echo "❌ Gagal upload gambar baru!";
            exit;
        }
    } else {
        $query = "UPDATE gallery SET judul='$judul', deskripsi='$deskripsi' WHERE id=$id";
    }

    $result = pg_query($conn, $query);

    if ($result) {
        header("Location: ../pages/gallery.php");
    } else {
        echo "❌ Gagal memperbarui data!";
    }
}


// === DELETE ===
if ($mode === 'delete') {

    $id = $_GET['id'];

    pg_query($conn, "DELETE FROM gallery WHERE id = $id");

    header("Location: ../pages/gallery.php");
    exit;
}

echo "❌ Mode tidak valid!";
