<?php
include '../config/config_db.php';
$result = pg_query($conn, "SELECT * FROM news ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage News</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { background-color: #f7f8fa; font-family: 'Poppins', sans-serif; }
    .sidebar { width:240px;height:100vh;background:#fff;box-shadow:0 0 10px rgba(0,0,0,0.1);position:fixed; }
    .sidebar .nav-link { color:#444;font-weight:500;margin-bottom:6px; }
    .sidebar .nav-link.active { background:#ff8c00;color:white; }
    .topbar { height:60px;background:#0b3c75;color:white;display:flex;align-items:center;justify-content:space-between;padding:0 25px; }
    .content { margin-left:240px;padding:25px; }
    .card { border-radius:10px;box-shadow:0 1px 6px rgba(0,0,0,0.1); }
  </style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar p-3">
  <div class="text-center mb-4">
    <img src="../assets/img/logo.png" width="130">
  </div>

  <ul class="nav flex-column">
      <li><a href="products.php" class="nav-link"><i class="bi bi-box"></i> Products</a></li>
      <li><a href="members.php" class="nav-link"><i class="bi bi-people"></i> Members</a></li>
      <li><a href="partners.php" class="nav-link"><i class="bi bi-handshake"></i> Partners</a></li>
      <li><a href="gallery.php" class="nav-link"><i class="bi bi-images"></i> Gallery</a></li>
      <li><a href="news.php" class="nav-link active"><i class="bi bi-newspaper"></i> News</a></li>
  </ul>
</div>

<!-- Topbar -->
<div class="topbar">
  <h5 class="mb-0">Manage News</h5>
  <div class="d-flex align-items-center gap-3">
    <span>Admin</span>
    <img src="../assets/img/logo.jpg" width="35" height="35" class="rounded-circle">
  </div>
</div>

<!-- Content -->
<div class="content">
  <div class="card p-4">

    <div class="d-flex justify-content-between mb-3">
      <h5 class="fw-semibold">News List</h5>
      <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addNewsModal">
        <i class="bi bi-plus-lg"></i> Add News
      </button>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th>No</th>
            <th>Foto</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          <?php $no=1; while ($row = pg_fetch_assoc($result)) { ?>
            <tr>
              <td><?= $no++ ?></td>

              <td>
                <img src="../assets/img/news/<?= $row['foto'] ?>"
                     width="80" height="60" class="border rounded">
              </td>

              <td><?= htmlspecialchars($row['judul']) ?></td>
              <td><?= htmlspecialchars($row['kategori']) ?></td>
              <td><?= htmlspecialchars($row['tanggal']) ?></td>

              <td>
                <button class="btn btn-outline-secondary btn-sm editBtn"
                  data-id="<?= $row['id'] ?>"
                  data-judul="<?= htmlspecialchars($row['judul']) ?>"
                  data-isi="<?= htmlspecialchars($row['isi']) ?>"
                  data-tanggal="<?= $row['tanggal'] ?>"
                  data-kategori="<?= htmlspecialchars($row['kategori']) ?>"
                  data-foto="<?= htmlspecialchars($row['foto']) ?>"
                  data-bs-toggle="modal" data-bs-target="#editNewsModal">
                  <i class="bi bi-pencil"></i>
                </button>

                <a href="../actions/delete_news.php?id=<?= $row['id'] ?>"
                   onclick="return confirm('Yakin hapus data ini?')"
                   class="btn btn-outline-danger btn-sm">
                   <i class="bi bi-trash"></i>
                </a>
              </td>
            </tr>
          <?php } ?>
        </tbody>

      </table>
    </div>

  </div>
</div>

<!-- MODAL ADD NEWS -->
<div class="modal fade" id="addNewsModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form action="../actions/add_news.php" method="POST" enctype="multipart/form-data">

        <div class="modal-header">
          <h5 class="modal-title">Add News</h5>
          <button class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Isi</label>
            <textarea name="isi" class="form-control" rows="4" required></textarea>
          </div>

          <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="kategori" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control" accept="image/*" required>
          </div>
        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-primary" type="submit">Simpan</button>
        </div>

      </form>

    </div>
  </div>
</div>

<!-- MODAL EDIT NEWS -->
<div class="modal fade" id="editNewsModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <form action="../actions/update_news.php" method="POST" enctype="multipart/form-data">

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit News</h5>
          <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">

          <input type="hidden" name="id" id="edit_id">

          <div class="text-center mb-3">
            <img id="edit_preview" src="" width="130" class="border rounded">
          </div>

          <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" id="edit_judul" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Isi</label>
            <textarea name="isi" id="edit_isi" class="form-control" rows="4" required></textarea>
          </div>

          <div class="mb-3">
            <label>Kategori</label>
            <input type="text" name="kategori" id="edit_kategori" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Tanggal</label>
            <input type="date" name="tanggal" id="edit_tanggal" class="form-control" required>
          </div>

          <div class="mb-3">
            <label>Ganti Foto</label>
            <input type="file" name="foto" id="edit_foto" class="form-control" accept="image/*">
          </div>

        </div>

        <div class="modal-footer">
          <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button class="btn btn-warning" type="submit">Simpan Perubahan</button>
        </div>

      </form>

    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", () => {
  const editButtons = document.querySelectorAll(".editBtn");

  editButtons.forEach(btn => {
    btn.addEventListener("click", () => {
      document.getElementById("edit_id").value = btn.dataset.id;
      document.getElementById("edit_judul").value = btn.dataset.judul;
      document.getElementById("edit_isi").value = btn.dataset.isi;
      document.getElementById("edit_kategori").value = btn.dataset.kategori;
      document.getElementById("edit_tanggal").value = btn.dataset.tanggal;

      document.getElementById("edit_preview").src =
        "../assets/img/news/" + btn.dataset.foto;

      document.getElementById("edit_foto").value = "";
    });
  });
});
</script>

</body>
</html>
