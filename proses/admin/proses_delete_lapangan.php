<?php
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil ID lapangan yang akan dihapus
    $lapangan_id = $_POST["lapangan_id"];

    // Query SQL untuk menghapus data lapangan
    $query = "DELETE FROM lapangan_futsal WHERE lapangan_id = '$lapangan_id'";

    if (mysqli_query($koneksi, $query)) {
        // Redirect kembali ke halaman data lapangan setelah berhasil menghapus
        header("location: ../../admin/kelola_lapangan.php");
        exit();
    } else {
        // Handle kesalahan jika gagal menghapus
        echo "Terjadi kesalahan saat menghapus data lapangan: " . mysqli_error($koneksi);
    }
} else {
    // Redirect jika akses langsung ke file ini tanpa POST request
    header("location: ../../admin/kelola_lapangan.php");
    exit();
}
