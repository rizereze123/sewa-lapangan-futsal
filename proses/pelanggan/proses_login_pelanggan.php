<?php
// Pastikan Anda telah mengatur koneksi ke database MySQL sebelumnya
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $storedPassword = base64_encode($password);

    // Lakukan validasi pengguna di sini, misalnya, periksa dengan database
    $query = "SELECT * FROM pelanggan WHERE email='$email' AND password='$storedPassword'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) == 1) {
        session_start();
        $pelanggan_data = mysqli_fetch_assoc($result); // Mengambil data admin
        $_SESSION['pelanggan_id'] = $pelanggan_data['pelanggan_id']; // Sesuaikan dengan nama kolom ID pelanggan pada tabel Anda
        $_SESSION['pelanggan_email'] = $email; // Simpan email pelanggan dalam sesi
        $_SESSION['pelanggan_nama_lengkap'] = $pelanggan_data['nama_lengkap']; // Simpan nama lengkap admin dalam sesi
        header("location: ../../login_pelanggan.php?pesan=success"); // Arahkan ke halaman dashboard pelanggan
    } else {
        // Jika login gagal, Anda dapat mengarahkan pengguna kembali ke halaman login atau menampilkan pesan kesalahan
        header("location: ../../login_pelanggan.php?pesan=fail");
    }
}
