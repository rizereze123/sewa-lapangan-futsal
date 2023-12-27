<?php
include("../../db/koneksi.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil data dari form
    $lapangan_id = $_POST["lapangan_id"];
    $nama_lapangan = $_POST["nama_lapangan"];
    $tipe_lapangan = $_POST["tipe_lapangan"];
    $deskripsi = $_POST["deskripsi"];
    $harga_per_jam = $_POST["harga_per_jam"];

    // Query SQL untuk mengupdate data lapangan
    $query = "UPDATE lapangan_futsal SET 
              nama_lapangan = '$nama_lapangan',
              tipe_lapangan = '$tipe_lapangan',
              deskripsi = '$deskripsi',
              harga_per_jam = '$harga_per_jam'
              WHERE lapangan_id = '$lapangan_id'";

    if (mysqli_query($koneksi, $query)) {
        // Redirect kembali ke halaman data lapangan setelah berhasil mengedit
        header("location: ../../admin/kelola_lapangan.php");
        exit();
    } else {
        // Handle kesalahan jika gagal mengedit
        echo "Terjadi kesalahan saat mengedit data lapangan: " . mysqli_error($koneksi);
    }
} else {
    // Redirect jika akses langsung ke file ini tanpa POST request
    header("location: ../../admin/kelola_lapangan.php");
    exit();
}
