<?php
include '../model/config_db.php';

// Ambil berita
$result = pg_query($conn, "SELECT * FROM view_news_detail ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita - Lab AI</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">


    <style>

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

        /* HERO */
        .hero {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url('../../dashboard_admin/assets/img/header-news.png') center/cover no-repeat;
            height: 300px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 42px;
            font-weight: bold;
        }
        /* TITLE */
        .title-section {
            text-align: center;
            font-size: 24px;
            color: #003366;
            font-weight: bold;
            margin: 40px 0;
        }

        /* GRID NEWS */
        .grid-news {
            width: 90%;
            margin: auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18);
        }

        .card img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            border-radius: 12px 12px 0 0;
        }

        .date {
            font-size: 12px;
            color: #555;
            padding: 12px 18px 0;
        }

        .title {
            font-size: 15px;
            font-weight: bold;
            padding: 5px 18px;
        }

        .desc {
            padding: 0 18px;
            font-size: 13px;
            color: #444;
        }

        .btn-read {
            margin: 15px 18px;
            padding: 8px 12px;
            border-radius: 6px;
            border: none;
            background: #0b3c75;
            color: white;
            cursor: pointer;
        }

        /* LOAD MORE */
        .load-more {
            display: flex;
            justify-content: center;
            margin: 40px 0;
        }

        .load-more button {
            padding: 10px 24px;
            background: #0b3c75;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
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
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<body>
    <!-- navbar -->
    <div class="navbar-top"></div>
    <nav class="navbar navbar-expand-lg navbar-main">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="../../dashboard_admin/assets/img/logo.png" alt="Applied Informatics" height="50">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navMenu">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="../../web_page/index.php">Beranda</a></li>
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
    <div class="hero">OUR NEWS</div>
    <div class="title-section">Berita Terbaru Laboratory Applied Informatics</div>

    <div class="grid-news">
        <?php while ($row = pg_fetch_assoc($result)) { ?>
            <div class="card">
                <img src="../../dashboard_admin/assets/img/news/<?= $row['gambar']; ?>">
                <div class="date"><?= $row['tanggal']; ?> - Berita Terkini</div>
                <div class="title"><?= $row['judul']; ?></div>
                <div class="desc"><?= substr($row['isi'], 0, 110); ?>...</div>
                <button class="btn-read">Baca Selengkapnya</button>
            </div>
        <?php } ?>
    </div>

    <div class="load-more">
        <button>Load More</button>
    </div>

    <!-- FOOTER TETAP ADA -->
    <footer>
        <div class="footer-container">
            <div class="footer-left">
                <img src="../../dashboard_admin/assets/img/logo.png">
                <p>Applied Informatics Laboratory<br>
                    Postgraduate Building, 2nd Floor, Malang State Polytechnic</p>
            </div>

            <div class="footer-right">
                <h3>Quick Link</h3>
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="../product.php">Produk</a></li>
                    <li><a href="../member.php">Member</a></li>
                    <li><a href="../mitra.php">Mitra</a></li>
                    <li><a href="news.php">Berita</a></li>
                    <li><a href="../layanan.php">Layanan</a></li>
                    <li><a href="../kontak.php">Kontak</a></li>
                </ul>
            </div>
        </div>

        <div class="copyright">
            Copyright © 2025 Lab Applied Informatics Polinema
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>