<?php
// Query SQL untuk mengambil data lapangan dari database
include("../db/koneksi.php");
$query = "SELECT * FROM pelanggan";
$result = mysqli_query($koneksi, $query);
?>
<?php
session_start();

// Periksa apakah sesi pelanggan telah ada
if (!isset($_SESSION['admin_email'])) {
    // Jika tidak ada sesi pelanggan, maka arahkan ke halaman login pelanggan
    header("location: index.php");
    exit(); // Pastikan untuk menghentikan eksekusi skrip
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSG Rizki | Manajemen Akun Pelanggan</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
    <link rel="stylesheet" href="assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="assets/css/pages/simple-datatables.css">
    <style>
        .dataTable-search {
            margin-top: 5px !important;
        }

        .dataTable-input {
            padding: 6px 23px !important;
        }
    </style>
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div class="logo">
                            <a href="#"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                                <!-- <label class="form-check-label">Mode</label> -->
                            </div>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>

                        <li class="sidebar-item">
                            <a href="dashboard_admin.php" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item  ">
                            <a href="reservasi_pemesanan_admin.php" class='sidebar-link'>
                                <i class="bi bi-journal-check"></i>
                                <span>Reservasi Pemesanan</span>
                            </a>
                        </li>

                        <li class="sidebar-item  ">
                            <a href="pendapatan_admin.php" class='sidebar-link'>
                                <i class="bi bi-cash"></i>
                                <span>Pendapatan</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="kelola_lapangan.php" class='sidebar-link'>
                                <i class="bi bi-file-earmark-medical-fill"></i>
                                <span>Kelola Lapangan</span>
                            </a>
                        </li>

                        <li class="sidebar-item  has-sub active">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-person-badge-fill"></i>
                                <span>Manajemen Akun</span>
                            </a>
                            <ul class="submenu active">
                                <li class="submenu-item active">
                                    <a href="#">Pelanggan</a>
                                </li>
                                <li class="submenu-item ">
                                    <a href="manajemen_akun_admin.php">Karyawan</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main" class='layout-navbar'>
            <header class='mb-3'>
                <nav class="navbar navbar-expand navbar-light navbar-top">
                    <div class="container-fluid">
                        <a href="#" class="burger-btn d-block">
                            <i class="bi bi-justify fs-3"></i>
                        </a>

                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ms-auto mb-lg-0">
                                <!-- notif disini -->
                                <li class="nav-item dropdown me-3" id="notificationItem">

                                </li>
                            </ul>
                            <div class="dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <div class="user-menu d-flex">
                                        <div class="user-name text-end me-3">
                                            <!-- <h6 class="mb-0 text-gray-600">John Ducky</h6> -->
                                            <h6 class="mb-0 text-gray-600">
                                                <?php echo $_SESSION['admin_nama_lengkap'] ?>
                                            </h6>
                                            <p class="mb-0 text-sm text-gray-600">Administrator</p>
                                        </div>
                                        <div class="user-img d-flex align-items-center">
                                            <div class="avatar avatar-md">
                                                <img src="assets/images/faces/1.jpg">
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton" style="min-width: 11rem;">

                                    <li><a class="dropdown-item" href="profile_admin.php"><i class="icon-mid bi bi-person me-2"></i> My
                                            Profile</a></li>
                                    <li><a class="dropdown-item" href="#"><i class="icon-mid bi bi-gear me-2"></i>
                                            Settings</a></li>
                                    <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="../proses/admin/logout_admin.php"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </header>
            <!-- <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header> -->
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3>Manajemen Akun Pelanggan</h3>
                                <p class="text-subtitle text-muted">Kelola Akun Pelanggan Setiamu Disini!</p>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                            <table class="table table-striped" id="table1">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Telepon</th>
                                        <th>Member Sejak</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                        <tr>
                                            <td><?php echo $row['nama_lengkap']; ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td><?php echo $row['telepon']; ?></td>
                                            <td><?php echo $row["tanggal_daftar"]; ?></td>
                                            <td>
                                                <div class="buttons">
                                                    <a href="#" class="btn icon btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $row['pelanggan_id']; ?>"><i class="bi bi-x"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Delete Modal -->
                                        <div class="modal fade text-left" id="deleteModal<?php echo $row['pelanggan_id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1602" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger">
                                                        <h5 class="modal-title white" id="myModalLabel1602">Konfirmasi Hapus Akun Pelanggan
                                                        </h5>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i data-feather="x"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus data akun pelanggan ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <form action="../proses/admin/proses_delete_akun_pelanggan.php" method="post">
                                                            <input type="hidden" name="pelanggan_id" value="<?php echo $row['pelanggan_id']; ?>">
                                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </section>

                <footer>
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-end">
                            <p>2023 &copy; GSG Rizki Futsal, Bandung</p>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="assets/js/bootstrap.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
        <script src="assets/js/pages/simple-datatables.js"></script>
        <script>
            // Fungsi untuk memeriksa pembayaran terbaru secara berkala
            function cekPembayaranTerbaru() {
                fetch('../proses/admin/proses_cek_pembayaran_terbaru.php') // Memanggil file untuk memeriksa pembayaran terbaru
                    .then(response => response.text())
                    .then(data => {
                        // Memeriksa hasil dari proses_cek_pembayaran_terbaru.php
                        if (data === 'ada') {
                            // Jika terdapat pembayaran terbaru, tambahkan notifikasi ke dalam dropdown
                            const notificationItem = document.getElementById('notificationItem');
                            notificationItem.innerHTML = `
                        <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <i class='bi bi-bell bi-sub fs-4'></i>
                            <span class="badge badge-notification bg-success">1</span>
                        </a>
                            <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-header">
                                    <h6>Notifikasi Pembayaran Masuk Hari Ini</h6>
                                </li>
                                <li class="dropdown-item notification-item">
                                    <a class="d-flex align-items-center" href="reservasi_pemesanan_admin.php">
                                    <div class="notification-icon bg-success">
                                        <i class="bi bi-file-earmark-check"></i>
                                    </div>
                                    <div class="notification-text ms-4">
                                        <p class="notification-title font-bold">Ada Pembayaran Baru</p>
                                        <p class="notification-subtitle font-thin text-sm">Silakan cek di Menu Reservasi Pemesanan</p>
                                    </div>
                                    </a> 
                                </li>
                            </ul>`;
                        } else if (data === 'tidak ada') {
                            // Jika tidak ada pembayaran terbaru, tampilkan pesan 'Tidak ada Notifikasi'
                            const notificationItem = document.getElementById('notificationItem');
                            notificationItem.innerHTML = `
                        <a class="nav-link active dropdown-toggle text-gray-600" href="#" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                            <i class='bi bi-bell bi-sub fs-4'></i>
                            <span class="badge badge-notification bg-danger">0</span>
                        </a>
                            <ul class="dropdown-menu dropdown-menu-end notification-dropdown" aria-labelledby="dropdownMenuButton">
                                <li class="dropdown-header">
                                    <h6>Notifikasi Pembayaran Masuk Hari Ini</h6>
                                </li>
                                <div class="notification-text ms-4">
                                    <p class="notification-title font-bold">Tidak ada Notifikasi Pembayaran Baru</p>
                                </div> 
                            </ul>`;
                        } else {
                            // Jika ada kesalahan saat memeriksa pembayaran terbaru
                            console.error('Ada kesalahan dalam proses memeriksa pembayaran terbaru.');
                        }
                    })
                    .catch(error => {
                        console.error('Ada kesalahan dalam melakukan fetch:', error);
                    });
            }

            // Jalankan fungsi cekPembayaranTerbaru setiap 5 detik
            setInterval(cekPembayaranTerbaru, 5000); // Ubah interval sesuai kebutuhan
        </script>
</body>

</html>