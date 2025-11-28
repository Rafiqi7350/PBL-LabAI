<?php
include '../model/config_db.php';
$result = pg_query($conn, "SELECT * FROM members ORDER BY id ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Members</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body { background-color: #f7f8fa; font-family: 'Poppins', sans-serif; }

    .sidebar {
      width: 240px; height: 100vh; background-color: #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.1); position: fixed;
    }
    .sidebar .nav-link { color: #444; font-weight: 500; margin-bottom: 6px; }
    .sidebar .nav-link.active { background-color: #ff8c00; color: #fff; }

    .topbar {
      height: 60px; background-color: #0b3c75; color: white;
      display: flex; justify-content: space-between; align-items: center;
      padding: 0 25px;
    }

    .content { margin-left: 240px; padding: 25px; }

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

    .btn-warning { background-color: #ff8c00; border: none; }
    .btn-warning:hover { background-color: #e57c00; }
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
      <li><a href="members.php" class="nav-link active"><i class="bi bi-people"></i> Members</a></li>
      <li><a href="partners.php" class="nav-link"><i class="bi bi-person-heart"></i> Partners</a></li>
      <li><a href="gallery.php" class="nav-link"><i class="bi bi-images"></i> Gallery</a></li>
      <li><a href="news.php" class="nav-link"><i class="bi bi-newspaper"></i> News</a></li>
      <li><a href="peminjaman.php" class="nav-link"><i class="bi bi-journal-text"></i> Peminjaman</a></li>
    </ul>
  </div>

  <!-- Topbar -->
  <div class="topbar">
    <h5 class="mb-0">Manage Members</h5>
    <div class="d-flex align-items-center gap-3">
      <span>Admin</span>
      <img src="../assets/img/admin.jpg" width="35" height="35" class="rounded-circle">
    </div>
  </div>

  <!-- Content -->
  <div class="content">

    <!-- HEADER LIST -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h5 class="fw-semibold mb-0">Members List</h5>

      <div class="d-flex align-items-center gap-3">

        <!-- Search -->
        <div class="position-relative">
          <i class="bi bi-search search-icon"></i>
          <input type="text" id="searchInput" class="form-control search-box" placeholder="Search Member">
        </div>

        <!-- Add -->
        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#addMemberModal">
          <i class="bi bi-plus-lg"></i> Add Member
        </button>

      </div>
    </div>

    <!-- Table -->
    <div class="card p-4">
      <div class="table-responsive">
        <table class="table table-hover align-middle" id="membersTable">
          <thead class="table-light">
            <tr>
              <th>No</th>
              <th>Foto</th>
              <th>Nama</th>
              <th>Role</th>
              <th>Deskripsi</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            <?php $no = 1; while ($row = pg_fetch_assoc($result)) { ?>
              <tr class="member-row"
                data-nama="<?= strtolower($row['nama']) ?>"
                data-role="<?= strtolower($row['role']) ?>"
                data-deskripsi="<?= strtolower($row['deskripsi']) ?>">

                <td><?= $no++ ?></td>

                <td>
                  <img src="../assets/img/members/<?= htmlspecialchars($row['foto']) ?>"
                       width="55" height="55" class="rounded-circle border">
                </td>

                <td><?= htmlspecialchars($row['nama']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td><?= htmlspecialchars($row['deskripsi']) ?></td>

                <td>
                  <button class="btn btn-outline-secondary btn-sm editBtn"
                    data-id="<?= $row['id'] ?>"
                    data-nama="<?= htmlspecialchars($row['nama']) ?>"
                    data-role="<?= htmlspecialchars($row['role']) ?>"
                    data-deskripsi="<?= htmlspecialchars($row['deskripsi']) ?>"
                    data-foto="<?= htmlspecialchars($row['foto']) ?>"
                    data-bs-toggle="modal" data-bs-target="#editMemberModal">
                    <i class="bi bi-pencil"></i> Edit
                  </button>

                  <a href="../controller/delete_member.php?id=<?= $row['id'] ?>"
                    onclick="return confirm('Yakin hapus member ini?')"
                    class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash"></i> Delete
                  </a>
                </td>

              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <!-- Modal Add Member -->
  <div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="../controller/add_member_action.php" method="POST" enctype="multipart/form-data">

          <div class="modal-header">
            <h5 class="modal-title">Add Member</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">

            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input type="text" name="nama" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Role</label>
              <input type="text" name="role" class="form-control">
            </div>

            <div class="mb-3">
              <label class="form-label">Deskripsi</label>
              <textarea name="deskripsi" class="form-control"></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label">Foto</label>
              <input type="file" name="foto" class="form-control" accept="image/*" required>
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-warning">Simpan</button>
          </div>

        </form>

      </div>
    </div>
  </div>

  <!-- Modal Edit -->
  <div class="modal fade" id="editMemberModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">

        <form action="../controller/update_members.php" method="POST" enctype="multipart/form-data">

          <div class="modal-header bg-primary text-white">
            <h5 class="modal-title">Edit Member</h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
          </div>

          <div class="modal-body">

            <input type="hidden" name="id" id="edit_id">

            <div class="text-center mb-3">
              <img id="preview_foto" src="" width="80" height="80" class="rounded-circle border shadow-sm">
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Nama</label>
              <input type="text" name="nama" id="edit_nama" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Role</label>
              <input type="text" name="role" id="edit_role" class="form-control">
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Deskripsi</label>
              <textarea name="deskripsi" id="edit_deskripsi" class="form-control" rows="3"></textarea>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Ganti Foto (Opsional)</label>
              <input type="file" name="foto" id="edit_foto_input" class="form-control" accept="image/*">
            </div>

          </div>

          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
          </div>

        </form>

      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // FILL EDIT MODAL
    document.addEventListener("DOMContentLoaded", () => {
      const editButtons = document.querySelectorAll(".editBtn");
      const preview = document.getElementById("preview_foto");
      const fileInput = document.getElementById("edit_foto_input");

      editButtons.forEach(btn => {
        btn.addEventListener("click", () => {
          document.getElementById("edit_id").value = btn.dataset.id;
          document.getElementById("edit_nama").value = btn.dataset.nama;
          document.getElementById("edit_role").value = btn.dataset.role;
          document.getElementById("edit_deskripsi").value = btn.dataset.deskripsi;

          preview.src = "../assets/img/members/" + btn.dataset.foto;
          fileInput.value = "";
        });
      });

      // Preview Foto Baru
      fileInput.addEventListener("change", (e) => {
        const file = e.target.files[0];
        if (file) {
          const reader = new FileReader();
          reader.onload = (event) => { preview.src = event.target.result; };
          reader.readAsDataURL(file);
        }
      });
    });

    // SEARCH FUNCTION
    document.getElementById("searchInput").addEventListener("input", function () {
      const keyword = this.value.toLowerCase();
      const rows = document.querySelectorAll(".member-row");

      rows.forEach(row => {
        const nama = row.dataset.nama;
        const role = row.dataset.role;
        const desk = row.dataset.deskripsi;

        row.style.display =
          (nama.includes(keyword) || role.includes(keyword) || desk.includes(keyword))
          ? "" : "none";
      });
    });
  </script>

</body>
</html>
