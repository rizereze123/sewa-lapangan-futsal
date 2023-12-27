<?php
session_start();
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $pelanggan_id = $_POST["pelanggan_id"];
    $email = $_POST["email"];
    $nama_lengkap = $_POST["nama_lengkap"];
    $telepon = $_POST["telepon"];
    $password = $_POST["password"];
    $encryptedPassword = base64_encode($password);

    // Ambil nilai nama_lengkap dari session
    $current_nama_lengkap = $_SESSION['current_nama_lengkap'];
    $current_email = $_SESSION['current_email'];

    $query = "UPDATE pelanggan SET 
              email = '$email',
              nama_lengkap = '$nama_lengkap',
              telepon = '$telepon',
              password = '$encryptedPassword'
              WHERE pelanggan_id = '$pelanggan_id'";

    if (mysqli_query($koneksi, $query)) {
        // Memeriksa perubahan pada nama_lengkap
        if ($nama_lengkap !== $current_nama_lengkap || $email !== $current_email) {
            // Jika terjadi perubahan pada nama_lengkap, arahkan ke halaman logoutedit_pelanggan.php
            header("location: logoutedit_pelanggan.php");
            exit();
        } else {
            // Jika tidak ada perubahan pada nama_lengkap, arahkan ke halaman lain (misalnya, index.php)
            header("location: ../../profile_pelanggan.php");
            exit();
        }
    } else {
        // Handle kesalahan jika gagal mengedit
        echo "Terjadi kesalahan saat mengedit data profil anda: " . mysqli_error($koneksi);
    }
} else {
    // Redirect jika akses langsung ke file ini tanpa POST request
    header("location: ../../profile_pelanggan.php");
    exit();
}
