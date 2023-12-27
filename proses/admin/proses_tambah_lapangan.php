<?php
// Pastikan Anda telah menghubungkan ke database
include("../../db/koneksi.php");

// Ambil data dari formulir tambah lapangan
$nama_lapangan = $_POST['nama_lapangan'];
$deskripsi = $_POST['deskripsi'];
$harga_per_jam = $_POST['harga_per_jam'];
$tipe_lapangan = $_POST['tipe_lapangan']; // Menambahkan variabel tipe_lapangan

// Contoh validasi sederhana (Anda dapat menambahkan validasi lebih lanjut)
if (empty($nama_lapangan) || empty($deskripsi) || empty($harga_per_jam)) {
    // Handle kesalahan jika data tidak lengkap
    echo "Data lapangan tidak lengkap. Kembali <a href='../../admin/kelola_lapangan.php'>ke halaman kelola lapangan</a>.";
} else {
    // Query SQL untuk menambahkan data lapangan ke database
    $query = "INSERT INTO lapangan_futsal (nama_lapangan, tipe_lapangan, deskripsi, harga_per_jam) 
              VALUES ('$nama_lapangan', '$tipe_lapangan', '$deskripsi', '$harga_per_jam')";

    if (mysqli_query($koneksi, $query)) {
        // Data berhasil ditambahkan
        header("Location: ../../admin/kelola_lapangan.php"); // Redirect kembali ke halaman admin
    } else {
        // Handle kesalahan jika query gagal
        echo "Terjadi kesalahan. Kembali <a href='../../admin/kelola_lapangan.php'>ke halaman kelola lapangan</a>.";
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
}
