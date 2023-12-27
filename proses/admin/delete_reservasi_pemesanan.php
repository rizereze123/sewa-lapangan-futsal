<?php
// Pastikan Anda telah menghubungkan ke database
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil nilai yang dikirimkan melalui form
    $pemesanan_id = $_POST['pemesanan_id'];

    // Query SQL untuk menghapus data Reservasi Pemesanan berdasarkan pemesanan_id
    $query = "DELETE FROM pemesanan WHERE pemesanan_id = '$pemesanan_id'";

    if (mysqli_query($koneksi, $query)) {
        // Penghapusan berhasil
        // Redirect ke halaman yang sesuai, misalnya halaman dengan daftar Reservasi Pemesanan
        header("Location: ../../admin/reservasi_pemesanan_admin.php");
    } else {
        // Penghapusan gagal
        //echo "Terjadi kesalahan saat menghapus data. Kembali <a href='../../reservasi_pemesanan_admin.php'>ke halaman reservasi pemesanan</a>.";
        echo '<html>';
        echo '<head>';
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '</head>';
        echo '<body>';
        echo '<script>';
        echo 'Swal.fire({';
        echo '  icon: "info",';
        echo '  title: "Tidak Dapat Menghapus Data Reservasi Ini!",';
        echo '  text: "Dikarenakan Pelanggan Telah Membayar Pemesanan Sewa Lapangan",';
        echo '}).then(function() {';
        echo '  window.location.href = "../../admin/reservasi_pemesanan_admin.php";'; // Ganti "halaman_pemesanan.php" dengan URL halaman pemesanan yang sesuai
        echo '});';
        echo '</script>';
        echo '</body>';
        echo '</html>';
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
}
