<?php
// Pastikan Anda telah menghubungkan ke database
include("../../db/koneksi.php");

// Ambil data yang dikirimkan oleh formulir pemesanan
$lapangan = $_POST['lapangan'];
$tanggal = $_POST['tanggal'];
$jam_mulai = $_POST['jam_mulai'];
$jam_selesai = $_POST['jam_selesai'];

// Cari harga per jam lapangan dari database berdasarkan pilihan lapangan

$queryHarga = "SELECT harga_per_jam FROM lapangan_futsal WHERE nama_lapangan = '$lapangan'";
$resultHarga = mysqli_query($koneksi, $queryHarga);
if ($row = mysqli_fetch_assoc($resultHarga)) {
    $harga_per_jam = $row['harga_per_jam'];
} else {
    // Handle jika lapangan tidak ditemukan
    echo "Lapangan tidak ditemukan. Kembali <a href='dashboard.php'>ke halaman dashboard</a>.";
    exit();
}

// Kalkulasikan total harga berdasarkan jam mulai dan jam selesai
$jam_mulai_timestamp = strtotime($jam_mulai);
$jam_selesai_timestamp = strtotime($jam_selesai);
$durasi = ($jam_selesai_timestamp - $jam_mulai_timestamp) / 3600; // Durasi dalam jam
$total_harga = $harga_per_jam * $durasi;

// Ambil pelanggan_id dari sesi, sesuaikan dengan implementasi login pelanggan Anda
session_start();
$pelanggan_id = $_SESSION['pelanggan_id'];

// Query SQL untuk menambahkan data pemesanan ke database
$status = "Menunggu Pembayaran"; // Status awal pemesanan
$queryPemesanan = "INSERT INTO pemesanan (pelanggan_id, lapangan, tanggal_pemesanan, jam_mulai, jam_selesai, total_harga, status) 
                   VALUES ('$pelanggan_id', '$lapangan', '$tanggal', '$jam_mulai', '$jam_selesai', '$total_harga', '$status')";

$queryCekPemesanan = "SELECT status FROM pemesanan WHERE pelanggan_id = '$pelanggan_id' AND status = 'Menunggu Pembayaran'";
// Query SQL untuk memeriksa apakah lapangan sudah dipesan oleh pelanggan lain pada rentang waktu yang sama
$queryCekJadwal = "SELECT * FROM pemesanan WHERE lapangan = '$lapangan' AND tanggal_pemesanan = '$tanggal' 
                   AND ((jam_mulai <= '$jam_mulai' AND jam_selesai >= '$jam_mulai') 
                   OR (jam_mulai <= '$jam_selesai' AND jam_selesai >= '$jam_selesai'))";
$resultCekJadwal = mysqli_query($koneksi, $queryCekJadwal);
$resultCekPemesanan = mysqli_query($koneksi, $queryCekPemesanan);
if (mysqli_num_rows($resultCekJadwal) > 0) {
    // Jadwal sudah penuh, tampilkan pesan kesalahan
    echo '<html>';
    echo '<head>';
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '</head>';
    echo '<body>';
    echo '<script>';
    echo 'Swal.fire({';
    echo '  icon: "error",';
    echo '  title: "Tidak Dapat Memproses Pemesanan Anda!",';
    echo '  text: "Jadwal lapangan sudah penuh pada rentang waktu yang dipilih. Silakan pilih waktu lain atau lapangan lain.",';
    echo '}).then(function() {';
    echo '  window.location.href = "../../pemesanan_pelanggan.php";'; // Ganti "halaman_pemesanan.php" dengan URL halaman pemesanan yang sesuai
    echo '});';
    echo '</script>';
    echo '</body>';
    echo '</html>';
} elseif (mysqli_num_rows($resultCekPemesanan) > 0) {
    // Pelanggan memiliki pemesanan yang sedang menunggu pembayaran
    echo '<html>';
    echo '<head>';
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '</head>';
    echo '<body>';
    echo '<script>';
    echo 'Swal.fire({';
    echo '  icon: "info",';
    echo '  title: "Tidak Dapat Memproses Pemesanan Ini!",';
    echo '  text: "Anda memiliki pemesanan yang belum dibayar. Silakan selesaikan pembayaran terlebih dahulu.",';
    echo '}).then(function() {';
    echo '  window.location.href = "../../pemesanan_pelanggan.php";'; // Ganti "halaman_pemesanan.php" dengan URL halaman pemesanan yang sesuai
    echo '});';
    echo '</script>';
    echo '</body>';
    echo '</html>';
} else {
    if (mysqli_query($koneksi, $queryPemesanan)) {
        // Data berhasil ditambahkan, redirect ke halaman pembayaran
        header("Location: ../../pembayaran_pelanggan.php");
    } else {
        // Handle kesalahan jika query gagal
        echo "Terjadi kesalahan. Kembali <a href='../../pemesanan_pelanggan.php'>ke halaman dashboard</a>.";
        echo "Terjadi kesalahan: " . mysqli_error($koneksi);
    }
}


// Tutup koneksi ke database
mysqli_close($koneksi);
