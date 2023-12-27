<?php
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil ID lapangan yang akan dihapus
    $admin_id = $_POST["admin_id"];

    // Query SQL untuk menghapus data lapangan
    $query = "DELETE FROM admin WHERE admin_id = '$admin_id'";

    if (mysqli_query($koneksi, $query)) {
        // Redirect kembali ke halaman data lapangan setelah berhasil menghapus
        header("location: ../../admin/manajemen_akun_admin.php");
        exit();
    } else {
        // Handle kesalahan jika gagal menghapus
        echo "Terjadi kesalahan saat menghapus data akun admin: " . mysqli_error($koneksi);
    }
} else {
    // Redirect jika akses langsung ke file ini tanpa POST request
    header("location: ../../admin/manajemen_akun_admin.php");
    exit();
}
