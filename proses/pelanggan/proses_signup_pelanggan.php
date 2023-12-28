<?php
// Pastikan Anda telah menghubungkan ke database
include("../../db/koneksi.php");


$email = $_POST['email'];
$nama_lengkap = $_POST['nama_lengkap'];
$telepon = $_POST['telepon'];
$password = $_POST['password'];
$encryptedPassword = base64_encode($password);
// Check if the email is already used
$queryCheckEmail = "SELECT * FROM pelanggan WHERE email='$email'";
$resultCheckEmail = mysqli_query($koneksi, $queryCheckEmail);

if (mysqli_num_rows($resultCheckEmail) > 0) {
    // Handle error if email is already used
    echo "Email yang anda daftarkan sudah terdaftar. Kembali <a href='../../index.php'>ke halaman dashboard</a>.";
} else {
    // Continue with the original code
    if (empty($email) || empty($nama_lengkap) || empty($telepon) || empty($password)) {
        // Handle kesalahan jika data tidak lengkap
        echo "Data akun pelanggan tidak lengkap. Kembali <a href='../../index.php'>ke halaman dashboard</a>.";
    } else {
        $query = "INSERT INTO pelanggan (email, nama_lengkap, telepon, password, tanggal_daftar) 
                 VALUES ('$email', '$nama_lengkap', '$telepon', '$encryptedPassword', NOW())";

        if (mysqli_query($koneksi, $query)) {
            // Data berhasil ditambahkan
            header("Location: ../../signup_pelanggan.php?pesan=success"); // Redirect kembali ke halaman login
        } else {
            // Handle kesalahan jika query gagal
            // echo "Terjadi kesalahan. Kembali <a href='../../index.php'>ke halaman dashboard</a>.";
            header("Location: ../../signup_pelanggan.php?pesan=fail");
        }

        // Tutup koneksi ke database
        mysqli_close($koneksi);
    }
}
