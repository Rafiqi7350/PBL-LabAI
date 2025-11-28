<?php 
include '../model/config_db.php'; 
$result = pg_query($conn, "SELECT * FROM peminjaman_ruang ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Peminjaman</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background-color: #f7f8fa;
            font-family: 'Poppins', sans-serif;
        }
        .sidebar {
            width: 240px;
            height: 100vh;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            position: fixed;
        }
        .sidebar .nav-link {
            color: #444;
            font-weight: 500;
            margin-bottom: 6px;
        }
        .sidebar .nav-link.active {
            background-color: #ff8c00;
            color: #fff;
        }
        .topbar {
            height: 60px;
            background-color: #0b3c75;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 25px;
        }
        .content {
            margin-left: 240px;
            padding: 25px;
        }
        .search-box {
            width: 280px;
            border-radius: 50px;
            padding-left: 40px;
        }
        .search-icon {
            position: absolute;
            left: 15px;
            top: 10px;
            color: gray;
        }
    </style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar d-flex flex-column p-3">
    <div class="text-center mb-4">
        <img src="../assets/img/logo.png" width="130">
    </div>

    <ul class="nav flex-column">
        <li><a href="products.php" class="nav-link"><i class="bi bi-box"></i> Products</a></li>
        <li><a href="members.php" class="nav-link"><i class="bi bi-people"></i> Members</a></li>
        <li><a href="partners.php" class="nav-link"><i class="bi bi-person-heart"></i> Partners</a></li>
        <li><a href="gallery.php" class="nav-link"><i class="bi bi-images"></i> Gallery</a></li>
        <li><a href="news.php" class="nav-link"><i class="bi bi-newspaper"></i> News</a></li>
        <li><a href="peminjaman.php" class="nav-link active"><i class="bi bi-journal-text"></i> Peminjaman</a></li>
    </ul>
</div>

<!-- Topbar -->
<div class="topbar">
    <h5 class="mb-0">Manage Peminjaman</h5>
    <div class="d-flex align-items-center gap-3">
        <span>Admin</span>
        <img src="../assets/img/admin.jpg" width="35" height="35" class="rounded-circle">
    </div>
</div>

<!-- Content -->
<div class="content">

    <!-- HEADER + SEARCH -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-semibold mb-0">Peminjaman List</h5>

        <div class="d-flex align-items-center gap-3">
            <div class="position-relative">
                <i class="bi bi-search search-icon"></i>
                <input type="text" id="searchInput" class="form-control search-box" placeholder="Search Peminjaman">
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="card p-4">
        <div class="table-responsive">

            <table class="table table-hover align-middle" id="peminjamanTable">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    <?php 
                    $no = 1; 
                    while($row = pg_fetch_assoc($result)) { 
                    ?>
                    <tr class="peminjaman-row"
                        data-nama="<?= strtolower($row['nama']) ?>"
                        data-barang="<?= strtolower($row['barang']) ?>">

                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['nama']) ?></td>
                        <td><?= htmlspecialchars($row['barang']) ?></td>
                        <td><?= htmlspecialchars($row['tanggal_pinjam']) ?></td>

                        <td>
                            <?php if ($row['status'] == "pending") { ?>
                                <span class="badge bg-warning text-dark">Pending</span>
                            <?php } else if ($row['status'] == "diterima") { ?>
                                <span class="badge bg-success">Diterima</span>
                            <?php } else { ?>
                                <span class="badge bg-danger">Ditolak</span>
                            <?php } ?>
                        </td>

                        <td>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                    Aksi
                                </button>
                                <ul class="dropdown-menu">

                                    <li>
                                        <button class="dropdown-item detailBtn"
                                            data-id="<?= $row['id'] ?>"
                                            data-nama="<?= htmlspecialchars($row['nama']) ?>"
                                            data-nim="<?= htmlspecialchars($row['nim']) ?>"
                                            data-prodi="<?= htmlspecialchars($row['prodi']) ?>"
                                            data-barang="<?= htmlspecialchars($row['barang']) ?>"
                                            data-pinjam="<?= $row['tanggal_pinjam'] ?>"
                                            data-kembali="<?= $row['tanggal_kembali'] ?>"
                                            data-catatan="<?= htmlspecialchars($row['catatan']) ?>"
                                            data-bs-toggle="modal" data-bs-target="#detailModal">
                                            <i class="bi bi-eye"></i> Detail
                                        </button>
                                    </li>

                                    <?php if ($row['status'] == "pending") { ?>
                                    <li>
                                        <a class="dropdown-item text-success" 
                                           href="../actions/peminjaman_accept.php?id=<?= $row['id'] ?>">
                                           <i class="bi bi-check-circle"></i> Terima
                                        </a>
                                    </li>

                                    <li>
                                        <a class="dropdown-item text-danger" 
                                           href="../actions/peminjaman_reject.php?id=<?= $row['id'] ?>">
                                           <i class="bi bi-x-circle"></i> Tolak
                                        </a>
                                    </li>
                                    <?php } ?>

                                </ul>
                            </div>
                        </td>

                    </tr>
                    <?php } ?>
                </tbody>
            </table>

        </div>
    </div>

</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">Detail Peminjaman</h5>
                <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered">
                    <tr><th>Nama</th><td id="d_nama"></td></tr>
                    <tr><th>NIM</th><td id="d_nim"></td></tr>
                    <tr><th>Prodi</th><td id="d_prodi"></td></tr>
                    <tr><th>Barang</th><td id="d_barang"></td></tr>
                    <tr><th>Tanggal Pinjam</th><td id="d_pinjam"></td></tr>
                    <tr><th>Tanggal Kembali</th><td id="d_kembali"></td></tr>
                    <tr><th>Catatan</th><td id="d_catatan"></td></tr>
                </table>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// SEARCH
document.getElementById("searchInput").addEventListener("input", function () {
    const keyword = this.value.toLowerCase();
    const rows = document.querySelectorAll(".peminjaman-row");

    rows.forEach(row => {
        const nama = row.dataset.nama;
        const barang = row.dataset.barang;

        row.style.display = (nama.includes(keyword) || barang.includes(keyword)) ? "" : "none";
    });
});

// DETAIL MODAL FILLER
document.addEventListener("DOMContentLoaded", () => {
    const detailButtons = document.querySelectorAll(".detailBtn");

    detailButtons.forEach(btn => {
        btn.addEventListener("click", () => {
            document.getElementById("d_nama").innerText = btn.dataset.nama;
            document.getElementById("d_nim").innerText = btn.dataset.nim;
            document.getElementById("d_prodi").innerText = btn.dataset.prodi;
            document.getElementById("d_barang").innerText = btn.dataset.barang;
            document.getElementById("d_pinjam").innerText = btn.dataset.pinjam;
            document.getElementById("d_kembali").innerText = btn.dataset.kembali;
            document.getElementById("d_catatan").innerText = btn.dataset.catatan;
        });
    });
});
</script>

</body>
</html>
