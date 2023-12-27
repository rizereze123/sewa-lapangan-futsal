<?php
// Query SQL untuk mengambil data lapangan dari database
session_start();
include("../db/koneksi.php");
$email = $_SESSION['admin_email']; // Mengambil email sesi
$query = "SELECT * FROM admin WHERE email = '$email'";
$result = mysqli_query($koneksi, $query);
?>
<?php

// Periksa apakah sesi pelanggan telah ada
if (!isset($_SESSION['admin_email'])) {
    // Jika tidak ada sesi pelanggan, maka arahkan ke halaman login pelanggan
    header("location: index.php");
    exit(); // Pastikan untuk menghentikan eksekusi skrip
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSG Rizki - Profil Admin</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/main/app-dark.css">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
    <link rel="shortcut icon" href="assets/images/logo/favicon.png" type="image/png">
    <!-- <style>
        .padding-judul {
            margin-top: -10px;
        }
    </style> -->
</head>

<body>
    <nav class="navbar navbar-light">
        <div class="container d-block">
            <a href="dashboard_admin.php"><i class="bi bi-chevron-double-left"></i></a>
            <a class="navbar-brand" href="dashboard_admin.php">
                <img src="assets/images/logo/logo.png">
            </a>
            <div class="theme-toggle d-flex gap-2 mt-1 align-items-center float-end">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                    <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path>
                </svg>
                <div class="form-check form-switch fs-6">
                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                    <label class="form-check-label"></label>
                </div>
            </div>
        </div>
    </nav>


    <div class="container">

        <div class="card mt-3">
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-3">
                            <div class="list-group" role="tablist">
                                <div class="card-heading text-center mt-3">
                                    <div class="avatar avatar-xl me-3">
                                        <img src="assets/images/faces/1.jpg" alt="" srcset="">
                                    </div>
                                    <div class="user-name text-center me-3 mb-4">
                                        <!-- <h6 class="mb-0 text-gray-600">John Ducky</h6> -->
                                        <h6 class="mb-0 text-xl text-gray-900 mt-1">
                                            <?php echo $_SESSION['admin_nama_lengkap'] ?>
                                        </h6>
                                        <p class="mb-0 text-sm text-gray-600">Administrator / Karyawan</p>
                                    </div>
                                </div>
                                <a class="list-group-item list-group-item-action active" id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab"><i class="icon-mid bi bi-person me-2"></i> My Profile</a>
                                <a class="list-group-item list-group-item-action" href="../proses/admin/logout_admin.php"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a>
                            </div>
                        </div>
                        <div class="col-12 col-sm-12 col-md-9 mt-1">
                            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                                <div class="tab-content text-justify" id="nav-tabContent">
                                    <div class="tab-pane show active" id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                                        <div class="card-body">
                                            <form class="form form-vertical" action="../proses/admin/proses_edit_profile_admin.php" method="post">
                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <input type="hidden" name="admin_id" value="<?php echo $row['admin_id']; ?>">
                                                            <?php $_SESSION['current_email'] = $row['email']; ?>
                                                            <label for="email">Email</label>
                                                            <input type="email" id="email" class="form-control" name="email" value="<?php echo $row['email']; ?>" placeholder="Masukkan Email" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="nama_lengkap">Nama Lengkap</label>
                                                            <?php $_SESSION['current_nama_lengkap'] = $row['nama_lengkap']; ?>
                                                            <input type="text" id="nama_lengkap" class="form-control" value="<?php echo $row['nama_lengkap']; ?>" placeholder="Masukkan Nama Lengkap" name="nama_lengkap" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="telepon">Telepon</label>
                                                            <input type="text" id="telepon" class="form-control" value="<?php echo $row['telepon']; ?>" placeholder="Masukkan No Telepon (08XXXXXXXX)" name="telepon" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label for="password">Password</label>
                                                            <input type="password" id="password" class="form-control" name="password" value="<?php $decryptedPassword = base64_decode($row['password']);
                                                                                                                                                echo $decryptedPassword; ?>" placeholder="Masukkan Password" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <button type="submit" class="btn btn-primary me-1 mb-1">Update</button>
                                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                                    </div>
                                                    <div class="col-12 d-flex justify-content-end">
                                                        <a href="dashboard_admin.php" class="text-sm mt-3"><i class="bi bi-chevron-left"></i></i>Back to Dashboard</a>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>