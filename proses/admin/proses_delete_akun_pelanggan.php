<?php
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil ID lapangan yang akan dihapus
    $pelanggan_id = $_POST["pelanggan_id"];

    // Query SQL untuk menghapus data lapangan
    $query = "DELETE FROM pelanggan WHERE pelanggan_id = '$pelanggan_id'";

    if (mysqli_query($koneksi, $query)) {
        // Redirect kembali ke halaman data lapangan setelah berhasil menghapus
        header("location: ../../admin/manajemen_akun_pelanggan.php");
        exit();
    } else {
        // Handle kesalahan jika gagal menghapus
        echo "Terjadi kesalahan saat menghapus data akun pelanggan: " . mysqli_error($koneksi);
    }
} else {
    // Redirect jika akses langsung ke file ini tanpa POST request
    header("location: ../../admin/manajemen_akun_pelanggan.php");
    exit();
}
