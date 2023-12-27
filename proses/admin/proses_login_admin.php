<?php
// Pastikan Anda telah mengatur koneksi ke database MySQL sebelumnya
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $storedPassword = base64_encode($password);

    // Lakukan validasi admin di sini, misalnya, periksa dengan database
    $query = "SELECT * FROM admin WHERE email='$email' AND password='$storedPassword'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        session_start();
        $admin_data = mysqli_fetch_assoc($result); // Mengambil data admin
        $_SESSION['admin_email'] = $email; // Simpan email admin dalam sesi
        $_SESSION['admin_nama_lengkap'] = $admin_data['nama_lengkap']; // Simpan nama lengkap admin dalam sesi
        // header("location: ../../admin/dashboard_admin.php"); // Arahkan ke halaman dashboard admin
        header("location: ../../admin/index.php?pesan=success");
    } else {
        // Jika login gagal, Anda dapat mengarahkan pengguna kembali ke halaman login admin atau menampilkan pesan kesalahan
        header("location: ../../admin/index.php?pesan=fail");
    }
}
