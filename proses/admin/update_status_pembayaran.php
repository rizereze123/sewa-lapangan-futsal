<?php
// Pastikan Anda telah menghubungkan ke database
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pemesanan_id = $_POST['pemesanan_id'];
    $status_pembayaran = $_POST['status_pembayaran'];

    // Query SQL untuk mengupdate status pembayaran
    $query = "UPDATE pembayaran SET status = '$status_pembayaran' WHERE pemesanan_id = '$pemesanan_id'";

    if (mysqli_query($koneksi, $query)) {
        // Pembaruan berhasil
        // $response = array('success' => true);
        // echo json_encode($response);
        echo '<html>';
        echo '<head>';
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '</head>';
        echo '<body>';
        echo '<script>';
        echo 'Swal.fire({';
        echo '  icon: "success",';
        echo '  title: "Update Data Reservasi Berhasil",';
        echo '  text: "Pembayaran Berhasil Diverifikasi!",';
        echo '}).then(function() {';
        echo '  window.location.href = "../../admin/reservasi_pemesanan_admin.php";'; // Ganti "halaman_pemesanan.php" dengan URL halaman pemesanan yang sesuai
        echo '});';
        echo '</script>';
        echo '</body>';
        echo '</html>';
    } else {
        // Pembaruan gagal
        $response = array('success' => false);
        echo json_encode($response);
    }

    // Tutup koneksi ke database
    mysqli_close($koneksi);
}
