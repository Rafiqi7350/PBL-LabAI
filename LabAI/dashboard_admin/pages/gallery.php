<?php
include '../config/config_db.php';
$result = pg_query($conn, "SELECT * FROM gallery ORDER BY id DESC");
?>
<!-- ifhjdhdjkhfjkhgjs -->
 <!-- iguidoygudyfgudygd -->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gallery Management</title>

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
    .gallery-card {
      transition: all 0.3s ease;
      border: none;
      overflow: hidden;
      border-radius: 15px;
      cursor: pointer;
    }
    .gallery-card:hover {
      transform: scale(1.03);
      box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    .gallery-img {
      height: 230px;
      object-fit: cover;
      border-radius: 15px 15px 0 0;
      width: 100%;
    }
    .modal-img {
      width: 100%;
      border-radius: 10px;
      object-fit: cover;
      max-height: 60vh;
    }
    .btn-warning {
      background-color: #ff8c00;
      border: none;
    }
    .btn-warning:hover {
      background-color: #e57c00;
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
      <li><a href="products.php" class="nav-link"><i class="bi bi-box"></i> Product</a></li>
      <li><a href="members.php" class="nav-link"><i class="bi bi-people"></i> Members</a></li>
      <li><a href="partners.php" class="nav-link"><i class="bi bi-handshake"></i> Partner</a></li>
      <li><a href="gallery.php" class="nav-link active"><i class="bi bi-images"></i> Galery</a></li>
      <li><a href="news.php" class="nav-link"><i class="bi bi-newspaper"></i> News</a></li>
    </ul>
  </div>

  <!-- Topbar -->
  <div class="topbar">
    <h5 class="mb-0">Manage Gallery</h5>
    <div class="d-flex align-items-center gap-3">
      <span>Admin</span>
      <img src="../assets/img/admin.jpg" width="35" height="35" class="rounded-circle">
    </div>
  </div>

  <!-- Content -->
  <div class="content">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h5 class="fw-semibold">Galeri Kegiatan</h5>
      <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addGalleryModal">
        <i class="bi bi-plus-lg"></i> Tambah Gambar
      </button>
    </div>

    <div class="row g-4">
      <?php while($row = pg_fetch_assoc($result)) { ?>
        <div class="col-md-4 col-lg-3">
          <div class="card gallery-card"
               data-bs-toggle="modal"
               data-bs-target="#previewModal"
               data-img="../assets/img/gallery/<?= htmlspecialchars($row['gambar']); ?>"
               data-judul="<?= htmlspecialchars($row['judul']); ?>"
               data-deskripsi="<?= htmlspecialchars($row['deskripsi']); ?>">
            <img src="../assets/img/gallery/<?= htmlspecialchars($row['gambar']); ?>" class="gallery-img">
            <div class="card-body">
              <h6 class="card-title text-truncate mb-2"><?= htmlspecialchars($row['judul']); ?></h6>
              <div class="d-flex justify-content-between">
                <button class="btn btn-sm btn-outline-primary"
                        data-bs-toggle="modal"
                        data-bs-target="#editGalleryModal"
                        data-id="<?= $row['id']; ?>"
                        data-judul="<?= htmlspecialchars($row['judul']); ?>"
                        data-deskripsi="<?= htmlspecialchars($row['deskripsi']); ?>">
                  Edit
                </button>
                <a href="../actions/delete_gallery.php?id=<?= $row['id']; ?>" 
                   onclick="return confirm('Yakin hapus gambar ini?')" 
                   class="btn btn-sm btn-outline-danger">
                   Hapus
                </a>
              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>

  <!-- Modal Preview -->
  <div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
      <div class="modal-content border-0 shadow-lg">
        <div class="modal-body text-center p-0">
          <img id="preview_img" src="" class="modal-img">
          <div class="p-3">
            <h4 id="preview_judul" class="fw-bold mb-2"></h4>
            <p id="preview_deskripsi" class="text-muted"></p>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Tambah -->
  <div class="modal fade" id="addGalleryModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../actions/add_gallery_action.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Tambah Gambar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Judul</label>
              <input type="text" name="judul" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Upload Gambar</label>
              <input type="file" name="gambar" class="form-control" accept="image/*" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Modal Edit -->
  <div class="modal fade" id="editGalleryModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <form action="../actions/edit_gallery_action.php" method="POST" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Edit Gambar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" name="id" id="edit_id">
            <div class="mb-3">
              <label class="form-label">Judul</label>
              <input type="text" name="judul" id="edit_judul" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3" required></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Ganti Gambar (Opsional)</label>
              <input type="file" name="gambar" class="form-control" accept="image/*">
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const previewModal = document.getElementById('previewModal');
    previewModal.addEventListener('show.bs.modal', e => {
      const card = e.relatedTarget;
      document.getElementById('preview_img').src = card.getAttribute('data-img');
      document.getElementById('preview_judul').textContent = card.getAttribute('data-judul');
      document.getElementById('preview_deskripsi').textContent = card.getAttribute('data-deskripsi');
    });

    const editModal = document.getElementById('editGalleryModal');
    editModal.addEventListener('show.bs.modal', e => {
      const btn = e.relatedTarget;
      document.getElementById('edit_id').value = btn.getAttribute('data-id');
      document.getElementById('edit_judul').value = btn.getAttribute('data-judul');
      document.getElementById('edit_deskripsi').value = btn.getAttribute('data-deskripsi');
    });
  </script>
</body>
</html>
