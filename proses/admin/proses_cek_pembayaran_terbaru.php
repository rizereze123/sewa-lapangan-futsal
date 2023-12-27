<?php
// Sertakan file koneksi ke database atau konfigurasi lain yang diperlukan
include("../../db/koneksi.php");
// Lakukan query untuk memeriksa apakah ada pembayaran terbaru dalam interval waktu tertentu (misalnya, 1 jam terakhir)
$query = "SELECT COUNT(*) AS jumlah_pembayaran FROM pembayaran WHERE TIMESTAMPDIFF(MINUTE, tanggal_pembayaran, NOW()) <= 30;";
$result = mysqli_query($koneksi, $query);

if ($result) {
    $row = mysqli_fetch_assoc($result);
    $jumlahPembayaran = $row['jumlah_pembayaran'];

    // Jika ada pembayaran terbaru dalam interval 1 jam terakhir, kembalikan respons 'ada'
    if ($jumlahPembayaran > 0) {
        echo 'ada';
    } else {
        echo 'tidak ada';
    }
} else {
    // Jika terjadi kesalahan dalam query
    echo 'error';
}
