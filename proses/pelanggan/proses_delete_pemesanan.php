<?php
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil ID lapangan yang akan dihapus
    $pemesanan_id = $_POST["pemesanan_id"];

    // Query SQL untuk menghapus data lapangan
    $query = "DELETE FROM pemesanan WHERE pemesanan_id = '$pemesanan_id'";

    if (mysqli_query($koneksi, $query)) {
        // Redirect kembali ke halaman data lapangan setelah berhasil menghapus
        header("location: ../../pemesanan_pelanggan.php");
        exit();
    } else {
        // Handle kesalahan jika gagal menghapus
        //echo "Terjadi kesalahan saat menghapus data pemesanan: " . mysqli_error($koneksi);
        echo '<html>';
        echo '<head>';
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '</head>';
        echo '<body>';
        echo '<script>';
        echo 'Swal.fire({';
        echo '  icon: "info",';
        echo '  title: "Tidak Dapat Menghapus Data Pemesanan Ini!",';
        echo '  text: "Dikarenakan data pemesanan telah masuk pada tahap proses verifikasi pembayaran oleh Admin",';
        echo '}).then(function() {';
        echo '  window.location.href = "../../pemesanan_pelanggan.php";'; // Ganti "halaman_pemesanan.php" dengan URL halaman pemesanan yang sesuai
        echo '});';
        echo '</script>';
        echo '</body>';
        echo '</html>';
    }
} else {
    // Redirect jika akses langsung ke file ini tanpa POST request
    header("location: ../../pemesanan_pelanggan.php");
    exit();
}
