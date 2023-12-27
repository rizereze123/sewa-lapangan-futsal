<?php
session_start();
include("db/koneksi.php");
$pelanggan_id = $_SESSION['pelanggan_id'];

// Query SQL untuk mengambil data pemesanan berdasarkan pelanggan_id
$query = "SELECT * FROM pemesanan WHERE pelanggan_id = '$pelanggan_id' ORDER BY pemesanan_id DESC LIMIT 1";
$result = mysqli_query($koneksi, $query);

// Periksa apakah sesi pelanggan telah ada
if (!isset($_SESSION['pelanggan_email'])) {
    // Jika tidak ada sesi pelanggan, maka arahkan ke halaman login pelanggan
    header("location: login_pelanggan.php");
    exit(); // Pastikan untuk menghentikan eksekusi skrip
}

if (!$result) {
    // Handle kesalahan jika query gagal
    die("Query error: " . mysqli_error($koneksi));
}

$pemesanan = mysqli_fetch_assoc($result);
// Periksa apakah ada data pemesanan
if (mysqli_num_rows($result) > 0 && $pemesanan['status'] == 'Menunggu Pembayaran') {
    // Ambil data pemesanan

    $pemesanan_id = $pemesanan['pemesanan_id']

    // Anda dapat menggunakan data pemesanan ini untuk membuat invoice sesuai dengan kebutuhan Anda
    // Misalnya, Anda dapat menggunakan HTML untuk mengatur tampilan invoice
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title>GSG Rizki Futsal | Pembayaran</title>
        <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
        <link rel="shortcut icon" href="admin/assets/images/logo/favicon.png" type="image/png">
        <link rel="shortcut icon" href="admin/assets/images/logo/favicon.png" type="image/png">

        <!-- Fonts and icons -->
        <script src="assets/js/plugin/webfont/webfont.min.js"></script>
        <!-- Tambahkan jsPDF melalui CDN -->
        <!-- Tambahkan ini di bagian head HTML -->
        <script src="https://rawgit.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>



        <script>
            WebFont.load({
                google: {
                    "families": ["Lato:300,400,700,900"]
                },
                custom: {
                    "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"],
                    urls: ['assets/css/fonts.min.css']
                },
                active: function() {
                    sessionStorage.fonts = true;
                }
            });
        </script>

        <!-- CSS Files -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/atlantis2.css">

        <!-- CSS Just for demo purpose, don't include it in your project -->
        <link rel="stylesheet" href="assets/css/demo.css">

        <style>
            .nav-item.submenu-2>.nav-link::after {
                display: none !important;
            }

            .main-header .nav-bottom .page-navigation>.nav-item.mega-menu .navbar-dropdown {
                width: 45% !important;
                /* margin-right: 150px !important; */
                left: initial !important;
                right: initial !important;
            }

            .main-header .nav-bottom .page-navigation>.nav-item .category-heading {
                margin-bottom: -15px !important;
            }

            .nav-search .form-control {
                font-size: 12px !important;
                padding: 0.1em 1em !important;

            }

            .nav-search .search-icon {
                font-size: 14px !important;
            }

            .quick-actions.quick-actions-info .quick-actions-header {
                background: #6861CE !important;
            }

            .quick-actions.quick-actions-info .quick-actions-item {
                color: #6861CE !important;
            }

            .logo-invoice {
                width: 100px !important;
                margin-top: -40px !important;
            }

            .card-invoice .transfer-to .account-transfer>div span:last-child {
                float: left !important;
            }

            .dropzone {
                margin-top: 80px !important;
            }

            .btn-bayar {
                float: right !important;
                /* margin-top: 100px !important; */
            }

            @media only screen and (min-width : 992px) {
                .main-header .nav-bottom .page-navigation {
                    margin: 0 120px !important;
                }

                .navbar .navbar-nav .nav-item-2 {
                    margin-right: 20px !important;
                }

                .logo-invoice {
                    width: 150px !important;
                }
            }
        </style>
    </head>

    <body>
        <div class="wrapper">

            <div class="main-header" data-background-color="purple">
                <div class="nav-top">
                    <div class="container d-flex flex-row">
                        <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon">
                                <i class="icon-menu"></i>
                            </span>
                        </button>
                        <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>
                        <!-- Logo Header -->
                        <a href="index.php" class="logo d-flex align-items-center">
                            <img src="assets/img/logogsg.png" alt="navbar brand" class="navbar-brand">
                        </a>
                        <!-- End Logo Header -->

                        <!-- Navbar Header -->
                        <nav class="navbar navbar-header navbar-expand-lg p-0">

                            <div class="container-fluid p-0">
                                <div class="collapse" id="search-nav">
                                    <form class="navbar-left navbar-form nav-search ml-md-3">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <button type="submit" class="btn btn-search pr-1">
                                                    <i class="fa fa-search search-icon"></i>
                                                </button>
                                            </div>
                                            <input type="text" placeholder="Search ..." class="form-control">
                                        </div>
                                    </form>
                                </div>
                                <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
                                    <li class="nav-item toggle-nav-search hidden-caret">
                                        <a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
                                            <i class="fa fa-search"></i>
                                        </a>
                                    </li>

                                    <li class="nav-item dropdown hidden-caret">
                                        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="false">
                                            <i class="fas fa-layer-group"></i>
                                        </a>
                                        <div class="dropdown-menu quick-actions quick-actions-info animated fadeIn">
                                            <div class="quick-actions-header">
                                                <span class="title mb-1">GSG Rizki Futsal</span>
                                                <span class="subtitle op-8">Shortcuts</span>
                                            </div>
                                            <div class="quick-actions-scroll scrollbar-outer">
                                                <div class="quick-actions-items">
                                                    <div class="row m-0">
                                                        <a class="col-6 col-md-4 p-0" href="index.php">
                                                            <div class="quick-actions-item">
                                                                <div class="avatar-item bg-danger rounded-circle">
                                                                    <i class="far fa-calendar-alt"></i>
                                                                </div>
                                                                <span class="text">Jadwal Tersedia</span>
                                                            </div>
                                                        </a>
                                                        <a class="col-6 col-md-4 p-0" href="admin/index.php">
                                                            <div class="quick-actions-item">
                                                                <div class="avatar-item bg-primary rounded-circle">
                                                                    <i class="icon-user"></i>
                                                                </div>
                                                                <span class="text">Halaman Admin</span>
                                                            </div>
                                                        </a>
                                                        <a class="col-6 col-md-4 p-0" href="harga.php">
                                                            <div class="quick-actions-item">
                                                                <div class="avatar-item bg-success rounded-circle">
                                                                    <i class="fas fa-file-invoice-dollar"></i>
                                                                </div>
                                                                <span class="text">Harga dan Metode Pembayaran</span>
                                                            </div>
                                                        </a>
                                                        <a class="col-6 col-md-4 p-0" href="contact.php">
                                                            <div class="quick-actions-item">
                                                                <div class="avatar-item bg-warning rounded-circle">
                                                                    <i class="fas fa-map"></i>
                                                                </div>
                                                                <span class="text">Lokasi</span>
                                                            </div>
                                                        </a>
                                                        <a class="col-6 col-md-4 p-0" href="#">
                                                            <div class="quick-actions-item">
                                                                <div class="avatar-item bg-info rounded-circle">
                                                                    <i class="icon-social-instagram"></i>
                                                                </div>
                                                                <span class="text">Instagram</span>
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="nav-item nav-item-2">
                                        <a href="#" class="nav-link quick-sidebar-toggler">
                                            <i class="icon-speech"></i>
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item dropdown hidden-caret">
                                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <div class="avatar-sm">
                                            <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                                        <div class="dropdown-user-scroll scrollbar-outer">
                                            <li>
                                                <div class="user-box">
                                                    <div class="avatar-lg"><img src="assets/img/profile.jpg" alt="image profile" class="avatar-img rounded"></div>
                                                    <div class="u-text">
                                                        <h4>Hizrian</h4>
                                                        <p class="text-muted">hello@example.com</p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#">My Profile</a>
                                                <a class="dropdown-item" href="#">Setting</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="proses/pelanggan/logout_pelanggan.php">Logout</a>
                                            </li>
                                        </div>
                                    </ul>
                                </li> -->
                                    <?php
                                    // Periksa apakah pelanggan sudah login atau belum
                                    // session_start();
                                    if (isset($_SESSION['pelanggan_email'])) {
                                        // Jika pelanggan sudah login, tampilkan tampilan dropdown
                                        // $pelanggan_nama = $_SESSION['pelanggan_nama'];
                                        $pelanggan_email = $_SESSION['pelanggan_email'];
                                        echo '<li class="nav-item dropdown hidden-caret">
            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                <div class="avatar-sm">
                    <img src="assets/img/profile.jpg" alt="..." class="avatar-img rounded-circle">
                </div>
            </a>
            <ul class="dropdown-menu dropdown-user animated fadeIn">
                <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                        <div class="user-box">
                            <div class="avatar-lg"><img src="assets/img/profile.jpg" alt="image profile" class="avatar-img rounded"></div>
                            <div class="u-text">
                                <h4>' . $_SESSION['pelanggan_nama_lengkap'] . '</h4>
                                <p class="text-muted">' . $pelanggan_email . '</p>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="profile_pelanggan.php">My Profile</a>
                        <a class="dropdown-item" href="#">Setting</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="proses/pelanggan/logout_pelanggan.php">Logout</a>
                    </li>
                </div>
            </ul>
        </li>';
                                    } else {
                                        // Jika pelanggan belum login, tampilkan tombol login
                                        echo '<li class="nav-item dropdown hidden-caret">
                                    <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
                                        <div class="avatar-sm">
                                            <img src="assets/img/profile-belum-login.png" alt="..." class="avatar-img rounded-circle">
                                        </div>
                                    </a>
                                    <ul class="dropdown-menu dropdown-user animated fadeIn">
                                        <div class="dropdown-user-scroll scrollbar-outer">
                                            <li>
                                                <div class="user-box">
                                                <a class="btn btn-secondary" href="login_pelanggan.php">
                                                <span class="btn-label">
												<i class="
                                                icon-login
                                                "></i>
											    </span> Login Pelanggan</a>
                                                </div>
                                            </li>
                                            <li>
                                            <div class="user-box">
                                            <div class="dropdown-divider"></div>
                                            <a class="btn btn-secondary btn-border" href="signup_pelanggan.php"><span class="btn-label">
                                            <i class="
                                            icon-user-follow
                                            "></i>
                                            </span> Buat Akunmu!</a>
                                            </div>
                                            </li>
                                        </div>
                                    </ul>
                                </li>';
                                    }
                                    ?>

                                </ul>
                            </div>
                        </nav>
                        <!-- End Navbar -->
                    </div>
                </div>
                <div class="nav-bottom bg-white">
                    <h3 class="title-menu d-flex d-lg-none">
                        Menu
                        <div class="close-menu"> <i class="flaticon-cross"></i></div>
                    </h3>
                    <div class="container d-flex flex-row align-center">
                        <ul class="nav page-navigation page-navigation-secondary">
                            <li class="nav-item submenu submenu-2">
                                <a class="nav-link" href="index.php">
                                    <i class="link-icon icon-screen-desktop"></i>
                                    <span class="menu-title">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item submenu submenu-2">
                                <a class="nav-link" href="pemesanan_pelanggan.php">
                                    <i class="link-icon icon-book-open"></i>
                                    <span class="menu-title">Pemesanan</span>
                                </a>
                            </li>
                            <li class="nav-item submenu submenu-2 active">
                                <a class="nav-link" href="pembayaran_pelanggan.php">
                                    <i class="link-icon icon-credit-card"></i>
                                    <span class="menu-title">Pembayaran</span>
                                </a>
                            </li>
                            <li class="nav-item submenu mega-menu dropdown">
                                <a class="nav-link" href="#">
                                    <i class="link-icon icon-film"></i>
                                    <span class="menu-title">Informasi Lapangan</span>
                                </a>
                                <div class="navbar-dropdown animated fadeIn">
                                    <div class="col-group-wrapper row">
                                        <div class="col-group col-md-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="category-heading">Rumput Sintetis</p>
                                                    <div class="submenu-item">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <ul>
                                                                    <li><a href="lapangan_a.php">Lapangan A</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-group col-md-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="category-heading">Semen Floor</p>
                                                    <div class="submenu-item">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <ul>
                                                                    <li><a href="lapangan_b.php">Lapangan B</a></li>
                                                                    <li><a href="lapangan_c.php">Lapangan C</a></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="nav-item submenu">
                                <a class="nav-link" href="#">
                                    <i class="link-icon icon-information"></i>
                                    <span class="menu-title">About Us</span>
                                </a>
                                <div class="navbar-dropdown animated fadeIn">
                                    <ul>
                                        <li>
                                            <a href="profile_gsgrizkifutsal.php">Profile GSG Rizki</a>
                                        </li>
                                        <li>
                                            <a href="contact.php">Contact</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="main-panel">
                <div class="container">
                    <div class="page-inner">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10 col-xl-9">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="page-pretitle">
                                            Payments
                                        </h6>
                                        <h4 class="page-title">Invoice #<?php echo $pemesanan['pemesanan_id']; ?></h4>
                                    </div>
                                    <div class="col-auto">
                                        <a href="#" class="btn btn-secondary" onclick="downloadPDF()">
                                            Download PDF
                                        </a>
                                    </div>
                                </div>
                                <div class=" page-divider">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="card card-invoice" id="invoice-content">
                                            <div class="card-header">
                                                <div class="invoice-header">
                                                    <h3 class="invoice-title">
                                                        <img src="admin/assets/images/logo/logo.png" alt="company logo" class="logo-invoice">
                                                    </h3>
                                                    <div class="invoice-logo text-right">
                                                        Cipadung Kulon<br>Panyileukan<br>Kota Bandung, 40614
                                                    </div>
                                                </div>
                                                <div class="invoice-desc">
                                                    Jl. Sukamaju No 10, 0851-0749-5000
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="separator-solid"></div>
                                                <div class="row">
                                                    <div class="col-md-4 info-invoice">
                                                        <h5 class="sub">Date</h5>
                                                        <p><?php echo $pemesanan['tanggal_pemesanan']; ?></p>
                                                    </div>
                                                    <div class="col-md-4 info-invoice">
                                                        <h5 class="sub">Invoice ID</h5>
                                                        <p>#<?php echo $pemesanan['pemesanan_id']; ?></p>
                                                    </div>
                                                    <!-- <div class="col-md-4 info-invoice">
                                                        <h5 class="sub">Invoice To</h5>
                                                        <p>
                                                            Jane Smith, 1234 Main, Apt. 4B<br />Springfield, ST 54321
                                                        </p>
                                                    </div> -->
                                                    <div class="col-md-4 info-invoice">
                                                        <h5 class="sub">Invoice To</h5>
                                                        <?php
                                                        // Koneksi ke database
                                                        // include("../../db/koneksi.php");

                                                        // Ambil data pemesanan dan informasi pelanggan menggunakan JOIN
                                                        $query2 = "SELECT p.pemesanan_id, p.tanggal_pemesanan, pe.nama_lengkap, pe.email, pe.telepon
                                                                    FROM pemesanan p
                                                                    INNER JOIN pelanggan pe ON p.pelanggan_id = pe.pelanggan_id
                                                                    WHERE p.pemesanan_id = '$pemesanan_id'";
                                                        $result = mysqli_query($koneksi, $query2);

                                                        if ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<p>{$row['nama_lengkap']}, {$row['email']}<br />{$row['telepon']}</p>";
                                                        } else {
                                                            echo "Informasi pelanggan tidak ditemukan.";
                                                        }

                                                        // Tutup koneksi ke database
                                                        // mysqli_close($koneksi);
                                                        ?>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="invoice-detail">
                                                            <div class="invoice-top">
                                                                <h3 class="title"><strong>Order summary</strong></h3>
                                                            </div>
                                                            <div class="invoice-item">
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped">
                                                                        <thead>
                                                                            <tr>
                                                                                <td><strong>Lapangan</strong></td>
                                                                                <td class="text-center"><strong>Tanggal Pemesanan</strong></td>
                                                                                <td class="text-center"><strong>Jam Mulai</strong></td>
                                                                                <td class="text-right"><strong>Jam Selesai</strong></td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr>
                                                                                <td><?php echo $pemesanan['lapangan']; ?></td>
                                                                                <td class="text-center"><?php echo $pemesanan['tanggal_pemesanan']; ?></td>
                                                                                <td class="text-center"><?php echo $pemesanan['jam_mulai']; ?></td>
                                                                                <td class="text-right"><?php echo $pemesanan['jam_selesai']; ?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="separator-solid  mb-3"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="row">
                                                    <div class="col-sm-7 col-md-5 mb-3 mb-md-0 transfer-to">
                                                        <h5 class="sub">Bank Transfer</h5>
                                                        <div class="account-transfer">
                                                            <div><span>Bank Name: BRI</span></div>
                                                            <div><span>Account Name: GSG Rizki Futsal</span></div>
                                                            <div><span>Account Number: 1234-678909-34</span></div>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <br>
                                                    <div class="col-sm-5 col-md-7 transfer-total">
                                                        <h5 class="sub">Total Amount</h5>
                                                        <div class="price">Rp<?php echo number_format($pemesanan['total_harga'], 0, ',', '.'); ?></div>
                                                        <span>Taxes Included</span>
                                                    </div>
                                                    <form action="proses/pelanggan/proses_upload_pembayaran.php" method="post" enctype="multipart/form-data">
                                                        <div class="dropzone">
                                                            <div class="dz-message" data-dz-message>
                                                                <div class="icon">
                                                                    <i class="flaticon-file"></i>
                                                                </div>
                                                                <h4 class="message">Kirim Bukti Pembayaranmu Disini!</h4>
                                                                <div class="note">Gambar berupa screenshoot atau hasil kamera dari bukti transfer</div>
                                                            </div>
                                                            <div class="fallback">
                                                                <input name="file" type="file" required />
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <input type="hidden" name="pemesanan_id" value="<?php echo $row['pemesanan_id']; ?>">
                                                        <button type="submit" class="btn btn-secondary btn-bayar">Bayar</button>
                                                    </form>

                                                </div>
                                                <div class="separator-solid"></div>
                                                <h6 class="text-uppercase mt-4 mb-3 fw-bold">
                                                    Notes
                                                </h6>
                                                <p class="text-muted mb-0">
                                                    Harap diperhatikan bahwa invoices ini hanya berlaku selama 3 jam sejak pembuatan, jika anda telat membayar maka pemesanan dianggap hangus. Pembayaran harus dilakukan sesuai dengan jumlah yang tertera pada invoices, tidak kurang dan tidak lebih. Butuh proses waktu sekitar 30 menit untuk melakukan pengecekan bukti pembayaran oleh Admin.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="bantuan.php">
                                    Help
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="syarat_ketentuan.php">
                                    Term & Conditions
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- <div class="copyright ml-auto">
                2023, Made with <i class="fa fa-heart heart text-danger"></i> by <a href="https://instagram.com/ntriumklorid">Kelompok Dhimaz</a>
            </div> -->
                </div>
            </footer>
        </div>


        <div class="quick-sidebar">
            <a href="#" class="close-quick-sidebar">
                <i class="flaticon-cross"></i>
            </a>
            <div class="quick-sidebar-wrapper">
                <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#settings" role="tab" aria-selected="false">Chat with Admin!</a> </li>
                </ul>
                <div class="tab-pane fade show active" id="settings" role="tabpanel">
                    <div class="quick-wrapper settings-wrapper">
                        <div class="quick-scroll scrollbar-outer">
                            <div class="quick-content settings-content">
                                <br>
                                <ul class="settings-list">
                                    <li>
                                        <span class="item-label">Admin 1</span>
                                        <div class="item-control">
                                            <button class="btn btn-success"><i class="flaticon-whatsapp"></i> Whatsapp</button>
                                        </div>
                                    </li>
                                    <li>
                                        <span class="item-label">Admin 2</span>
                                        <div class="item-control">
                                            <button class="btn btn-success"><i class="flaticon-whatsapp"></i> Whatsapp</button>
                                        </div>
                                    </li>
                                </ul>

                                <!-- <span class="category-title mt-0">Notifications</span> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>

        <script>
            function downloadPDF() {
                var element = document.getElementById('invoice-content'); // Gantilah 'container-to-pdf' dengan ID elemen yang ingin Anda ubah ke PDF
                html2pdf(element);
            }
        </script>


        <!--   Core JS Files   -->
        <script src="assets/js/core/jquery.3.2.1.min.js"></script>
        <script src="assets/js/core/popper.min.js"></script>
        <script src="assets/js/core/bootstrap.min.js"></script>

        <!-- jQuery UI -->
        <script src="assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
        <script src="assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

        <!-- jQuery Scrollbar -->
        <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

        <!-- Moment JS -->
        <script src="assets/js/plugin/moment/moment.min.js"></script>

        <!-- Chart JS -->
        <script src="assets/js/plugin/chart.js/chart.min.js"></script>

        <!-- jQuery Sparkline -->
        <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

        <!-- Chart Circle -->
        <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

        <!-- Datatables -->
        <script src="assets/js/plugin/datatables/datatables.min.js"></script>

        <!-- Bootstrap Notify -->
        <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

        <!-- Bootstrap Toggle -->
        <script src="assets/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>

        <!-- jQuery Vector Maps -->
        <script src="assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

        <!-- Google Maps Plugin -->
        <script src="assets/js/plugin/gmaps/gmaps.js"></script>

        <!-- Dropzone -->
        <script src="assets/js/plugin/dropzone/dropzone.min.js"></script>

        <!-- Fullcalendar -->
        <script src="assets/js/plugin/fullcalendar/fullcalendar.min.js"></script>

        <!-- DateTimePicker -->
        <script src="assets/js/plugin/datepicker/bootstrap-datetimepicker.min.js"></script>

        <!-- Bootstrap Tagsinput -->
        <script src="assets/js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

        <!-- Bootstrap Wizard -->
        <script src="assets/js/plugin/bootstrap-wizard/bootstrapwizard.js"></script>

        <!-- jQuery Validation -->
        <script src="assets/js/plugin/jquery.validate/jquery.validate.min.js"></script>

        <!-- Summernote -->
        <script src="assets/js/plugin/summernote/summernote-bs4.min.js"></script>

        <!-- Select2 -->
        <script src="assets/js/plugin/select2/select2.full.min.js"></script>

        <!-- Sweet Alert -->
        <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

        <!-- Atlantis JS -->
        <script src="assets/js/atlantis2.min.js"></script>

        <!-- Atlantis DEMO methods, don't include it in your project! -->
        <!-- <script src="assets/js/demo.js"></script> -->
    </body>

    </html>

<?php
} else {
    echo '<html>';
    echo '<head>';
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '</head>';
    echo '<body>';
    echo '<script>';
    echo 'Swal.fire({';
    echo '  icon: "info",';
    echo '  title: "Tidak ada data Pembayaran!",';
    echo '  text: "Anda belum melakukan pemesanan sewa lapangan sebelumnya",';
    echo '}).then(function() {';
    echo '  window.location.href = "pemesanan_pelanggan.php";'; // Ganti "halaman_pemesanan.php" dengan URL halaman pemesanan yang sesuai
    echo '});';
    echo '</script>';
    echo '</body>';
    echo '</html>';
}





// Tutup koneksi ke database
mysqli_close($koneksi);
?>