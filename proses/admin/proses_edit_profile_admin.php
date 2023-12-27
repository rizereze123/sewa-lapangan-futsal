<?php
session_start();
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $admin_id = $_POST["admin_id"];
    $email = $_POST["email"];
    $nama_lengkap = $_POST["nama_lengkap"];
    $telepon = $_POST["telepon"];
    $password = $_POST["password"];
    $encryptedPassword = base64_encode($password);

    // Ambil nilai nama_lengkap dari session
    $current_nama_lengkap = $_SESSION['current_nama_lengkap'];
    $current_email = $_SESSION['current_email'];

    // Query SQL untuk mengupdate data lapangan
    $query = "UPDATE admin SET 
              email = '$email',
              nama_lengkap = '$nama_lengkap',
              telepon = '$telepon',
              password = '$encryptedPassword'
              WHERE admin_id = '$admin_id'";

    if (mysqli_query($koneksi, $query)) {
        // Redirect kembali ke halaman data lapangan setelah berhasil mengedit
        if ($nama_lengkap !== $current_nama_lengkap || $email !== $current_email) {
            header("location: logoutedit_admin.php");
            exit();
        } else {
            header("location: ../../admin/profile_admin.php");
            exit();
        }
    } else {
        // Handle kesalahan jika gagal mengedit
        echo "Terjadi kesalahan saat mengedit data profil admin anda: " . mysqli_error($koneksi);
    }
} else {
    // Redirect jika akses langsung ke file ini tanpa POST request
    header("location: ../../admin/profile_admin.php");
    exit();
}
