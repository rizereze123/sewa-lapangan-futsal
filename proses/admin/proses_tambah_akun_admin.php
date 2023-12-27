<?php
// Pastikan Anda telah menghubungkan ke database
include("../../db/koneksi.php");


$email = $_POST['email'];
$nama_lengkap = $_POST['nama_lengkap'];
$telepon = $_POST['telepon'];
$password = $_POST['password'];
$storedPassword = base64_encode($password);

// Contoh validasi sederhana (Anda dapat menambahkan validasi lebih lanjut)
if (empty($email) || empty($nama_lengkap) || empty($telepon) || empty($password)) {
    // Handle kesalahan jika data tidak lengkap
    echo "Data akun karyawan tidak lengkap. Kembali <a href='../../admin/manajemen_akun_admin.php'>ke halaman kelola lapangan</a>.";
} else {
    // Query SQL untuk menambahkan data lapangan ke database
    $query = "INSERT INTO admin (email, nama_lengkap, telepon, password) 
              VALUES ('$email', '$nama_lengkap', '$telepon', '$storedPassword')";

    if (mysqli_query($koneksi, $query)) {
        // Data berhasil ditambahkan
        header("Location: ../../admin/manajemen_akun_admin.php"); // Redirect kembali ke halaman admin
    } else {
        // Handle kesalahan jika query gagal
        echo "Terjadi kesalahan. Kembali <a href='../../admin/manajemen_akun_admin.php'>ke halaman kelola lapangan</a>.";
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
}
