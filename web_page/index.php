<?php
include 'model/config_db.php';

$news = pg_query($conn, "SELECT * FROM news ORDER BY id DESC LIMIT 4");
$gallery = pg_query($conn, "SELECT * FROM gallery ORDER BY id DESC LIMIT 6");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lab Applied Informatics</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f7f9fd;
    }

    /* NAVBAR */
    .navbar-top {
      background: #0b3b63;
      height: 40px;
    }

    .navbar-main {
      background: #fff;
    }

    .navbar-main .nav-link {
      color: #0b3b63;
      font-weight: 600;
      margin: 0.8px;
    }

    .navbar-main .nav-link:hover {
      color: #f37021;
    }

    .hero {
      background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
        url('../dashboard_admin/assets/img/backgorund.jpg') center/cover no-repeat;
      height: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 42px;
      font-weight: bold;
    }

    .section-title {
      text-align: center;
      font-weight: 700;
      margin: 50px 0 30px;
    }

    .news-card img {
      height: 180px;
      object-fit: cover;
    }

    /* FOOTER */
    footer {
      margin-top: 60px;
      background: #0b3c75;
      color: white;
      padding: 40px 0;
    }

    footer .footer-container {
      width: 90%;
      margin: auto;
      display: grid;
      grid-template-columns: 2fr 1fr;
      gap: 20px;
    }

    .footer-left img {
      height: 55px;
    }

    .footer-right ul {
      list-style: none;
      padding: 0;
    }

    .footer-right a {
      color: white;
      text-decoration: none;
    }

    .copyright {
      text-align: center;
      font-size: 14px;
      margin-top: 20px;
    }
  </style>
</head>

<body>

  <!-- navbar -->
  <div class="navbar-top"></div>
  <nav class="navbar navbar-expand-lg navbar-main">
    <div class="container">
      <a class="navbar-brand" href="#">
        <img src="../dashboard_admin/assets/img/logo.png" alt="Applied Informatics" height="50">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item"><a class="nav-link" href="../web_page/view/index.php">Beranda</a></li>
          <li class="nav-item"><a class="nav-link" href="../web_page/view/product.php">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="../web_page/view/members.php">Members</a></li>
          <li class="nav-item"><a class="nav-link" href="../web_page/view/mitra.php">Mitra</a></li>
          <li class="nav-item"><a class="nav-link" href="../web_page/view/news.php">Berita</a></li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Layanan</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="../web_page/view/peminjaman.php">Peminjaman Ruangan</a></li>
              <li><a class="dropdown-item" href="#">Daftar Asisten</a></li>
              <li><a class="dropdown-item" href="#">Daftar Magang</a></li>
            </ul>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Kontak</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="#">Email</a></li>
              <li><a class="dropdown-item" href="#">Alamat</a></li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- HERO -->
  <section class="hero">
    <div class="container hero-overlay text-center">
      <h1 class="fw-bold">Laboratorium for Applied Informatics</h1>
      <p class="lead">Politeknik Negeri Malang</p>
    </div>
  </section>

  <!-- CAMPUS NEWS -->
  <section class="container">
    <h3 class="section-title">CAMPUS NEWS</h3>
    <div class="row g-4">
      <?php while ($n = pg_fetch_assoc($news)) { ?>
        <div class="col-md-3">
          <div class="card news-card shadow-sm h-100">
          <img src="../dashboard_admin/assets/img/news/   <?= htmlspecialchars($row['gambar']) ?>; ?>" class="card-img-top">
            <div class="card-body">
              <h6 class="fw-bold"><?php echo $n['judul']; ?></h6>
              <p class="small text-muted"><?php echo substr($n['isi'], 0, 80); ?>...</p>
              <a href="../web_page/view/news.php" class="btn btn-outline-primary btn-sm">Baca Selengkapnya</a>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
    <div class="text-center mt-4">
      <a href="../web_page/view/news.php" class="btn btn-primary">Lihat Semua</a>
    </div>
  </section>

  <!-- PRIORITY RESEARCH TOPICS -->
  <section class="container">
    <h3 class="section-title">PRIORITY RESEARCH TOPICS</h3>
    <div class="row g-3">
      <?php for ($i = 1; $i <= 7; $i++) { ?>
        <div class="col-md-4">
          <div class="card p-3 shadow-sm h-100">
            <strong><?php echo $i; ?>.</strong> Smart Technology Topic Description
          </div>
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- VISION & MISSION -->
  <section class="container">
    <h3 class="section-title">VISION & MISSION</h3>
    <div class="row">
      <div class="col-md-8">
        <div class="bg-light p-4 rounded shadow-sm">
          <h5 class="fw-bold">VISION</h5>
          <p>To become a leading laboratory in innovative technology research.</p>

          <h5 class="fw-bold mt-3">MISSION</h5>
          <ul>
            <li>Application of IT innovation</li>
            <li>Industry 4.0 solutions</li>
            <li>Data driven systems</li>
          </ul>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card text-center shadow-sm p-4">
          <img src="assets/img/head.png" class="rounded-circle mx-auto" width="120">
          <h6 class="mt-3 fw-bold">HEAD LAB</h6>
          <p>Ir. Yan Wattegulis Syaifudin, S.T., M.MT., Ph.D</p>
          <a href="#" class="btn btn-outline-primary btn-sm">More Detail</a>
        </div>
      </div>
    </div>
  </section>

  <!-- GALLERY -->
  <section class="container">
    <h3 class="section-title">GALLERY</h3>
    <div class="row g-3">
      <?php while ($g = pg_fetch_assoc($gallery)) { ?>
        <div class="col-md-4">
          <img src="uploads/gallery/<?php echo $g['image']; ?>" class="img-fluid rounded shadow-sm">
        </div>
      <?php } ?>
    </div>
  </section>

  <!-- FOOTER -->
  <footer>
    <div class="container">
      <div class="row">
        <div class="col-md-6">
          <h5>Applied Informatics Laboratory</h5>
          <p>Postgraduate Building, 2nd Floor<br>Polinema</p>
        </div>
        <div class="col-md-6 text-md-end">
          <h5>Quick Link</h5>
          <a href="#" class="text-white d-block">Beranda</a>
          <a href="news.php" class="text-white d-block">Berita</a>
        </div>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>