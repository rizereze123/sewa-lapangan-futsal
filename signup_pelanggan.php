<?php
// Query SQL untuk mengambil data lapangan dari database
include("db/koneksi.php");
$query = "SELECT * FROM pelanggan";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSG Rizki - Daftar Akun Pelanggan</title>
    <link rel="stylesheet" href="admin/assets/css/main/app.css">
    <link rel="stylesheet" href="admin/assets/css/main/app-dark.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="shortcut icon" href="admin/assets/images/logo/favicon.png" type="image/png">
    <link rel="shortcut icon" href="admin/assets/images/logo/favicon.png" type="image/png">
    <style>
        body {
            background-color: #42599F !important;
        }

        .card {
            background-color: #F2F7FF !important;
        }

        .yeti-img {
            width: 100%;
        }
    </style>
</head>

<body>
    <?php
    // Memeriksa pesan dari URL
    if (isset($_GET['pesan']) && $_GET['pesan'] === 'fail') {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Pendaftaran Akun Gagal',
                text: 'Mari Coba Lagi'
            });
          </script>";
    }
    if (isset($_GET['pesan']) && $_GET['pesan'] === 'success') {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Pendaftaran Akun Sukses',
                text: 'Silahkan Login Untuk Pemesanan Sewa Lapangan',
                customClass: {
                    container: 'swal2-height-auto'
                }
            }).then(function () {
                window.location.href = 'login_pelanggan.php';
            });
          </script>";
    }
    ?>

    <div class="container">
        <div class="card mt-5">
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-4">
                            <img src="admin/assets/images/samples/yeti.png" alt="yeti" srcset="" class="yeti-img">
                        </div>
                        <div class="col-12 col-sm-12 col-md-8 mt-1">
                            <div class="tab-content text-justify" id="nav-tabContent">
                                <div class="tab-pane show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                    <div class="card-body">
                                        <form class="form form-vertical" action="proses/pelanggan/proses_signup_pelanggan.php" method="post">
                                            <div class="row">
                                                <div class="page-heading">
                                                    <div class="page-title">
                                                        <h3>Daftarkan Akunmu Disini! 👋🏻</h3>
                                                        <p class="text-subtitle text-muted">Register Akun Member Pelanggan GSG Rizki Futsal</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" id="email" class="form-control" name="email" placeholder="Masukkan Email" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="nama_lengkap">Nama Lengkap</label>
                                                        <input type="text" id="nama_lengkap" class="form-control" placeholder="Masukkan Nama Lengkap" name="nama_lengkap" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="telepon">Telepon</label>
                                                        <input type="text" id="telepon" class="form-control" placeholder="Masukkan No Telepon (08XXXXXXXX)" name="telepon" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input type="password" id="password" class="form-control" name="password" placeholder="Masukkan Password" required>
                                                    </div>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <button type="submit" class="btn btn-primary me-1 mb-1">SignUp</button>
                                                    <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                </div>
                                                <div class="col-12 d-flex justify-content-end">
                                                    <a href="index.php" class="text-sm mt-3"><i class="bi bi-chevron-left"></i></i>Back to Dashboard</a>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="admin/assets/js/bootstrap.js"></script>
    <script src="admin/assets/js/app.js"></script>
    <script>
        document.body.classList.remove('swal2-height-auto');
    </script>
</body>

</html>