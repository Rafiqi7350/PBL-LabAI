<?php include '../model/config_db.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Peminjaman Ruangan</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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


        .form-section {
            padding: 40px 0;
        }

        .title {
            font-size: 28px;
            font-weight: 700;
            color: #083b71;
            text-align: center;
            margin-bottom: 40px;
        }

        .btn-send {
            background-color: #083b71;
            color: white;
            padding: 10px 40px;
        }

        .btn-send:hover {
            background-color: #062d57;
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

    <!-- ======= FORM AREA ======= -->
    <div class="container form-section">
        <h2 class="title">LAYANAN PEMINJAMAN RUANGAN</h2>

        <form action="../controller/add_peminjaman.php" method="POST">
            <div class="row justify-content-center">

                <div class="col-lg-8">

                    <!-- Nama -->
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>

                    <!-- NIM -->
                    <div class="mb-3">
                        <label class="form-label">NIM</label>
                        <input type="text" name="nim" class="form-control" required>
                    </div>

                    <!-- No HP -->
                    <div class="mb-3">
                        <label class="form-label">No Hp</label>
                        <input type="text" name="nohp" class="form-control" required>
                    </div>

                    <!-- Keperluan -->
                    <div class="mb-3">
                        <label class="form-label">Keperluan</label>
                        <input type="text" name="keperluan" class="form-control" required>
                    </div>

                    <!-- Waktu Mulai -->
                    <div class="row mb-3">
                        <label class="form-label">Waktu Mulai</label>
                        <div class="col-6">
                            <input type="date" name="tgl_mulai" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <input type="time" name="jam_mulai" class="form-control" required>
                        </div>
                    </div>

                    <!-- Waktu Selesai -->
                    <div class="row mb-4">
                        <label class="form-label">Waktu Selesai</label>
                        <div class="col-6">
                            <input type="date" name="tgl_selesai" class="form-control" required>
                        </div>
                        <div class="col-6">
                            <input type="time" name="jam_selesai" class="form-control" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button class="btn btn-send" type="submit">Send</button>
                    </div>
                </div>

            </div>
        </form>
    </div>

    <!-- ======= FOOTER ======= -->
    <footer>
        <div class="container">
            <div class="row">

                <div class="col-md-6">
                    <p><b>Applied Informatics Laboratory</b><br>
                        Postgraduate Building, 2nd Floor, Malang State Polytechnic</p>
                </div>

                <div class="col-md-6 text-end">
                    <p><b>Quick Link</b></p>
                    <a href="#">Beranda</a> •
                    <a href="#">Produk</a> •
                    <a href="#">Member</a> •
                    <a href="#">Berita</a> •
                    <a href="#">Peminjaman</a> •
                    <a href="#">Kontak</a>
                </div>

            </div>

            <hr style="border-color: rgba(255,255,255,0.3);">

            <p class="text-center">Copyright © 2025 Lab Applied Informatics Polinema</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>