<?php
// Pastikan Anda telah menghubungkan ke database
include("../../db/koneksi.php");

// Periksa apakah ada file yang diunggah
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    // Direktori penyimpanan gambar
    $uploadDirectory = 'uploads/';

    // Generate nama unik untuk file
    $fileName = uniqid() . '_' . $_FILES['file']['name'];

    // Lokasi lengkap file yang akan disimpan di server
    $filePath = $uploadDirectory . $fileName;

    // Pindahkan file ke direktori penyimpanan
    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        // File berhasil diunggah, tambahkan informasi ke database
        $pemesanan_id = $_POST['pemesanan_id'];
        date_default_timezone_set('Asia/Jakarta');
        $tanggal_pembayaran = date('Y-m-d H:i:s'); // Gunakan tanggal saat ini
        $status = 'Belum Diverifikasi'; // Status awal

        // Query SQL untuk memasukkan data pembayaran ke database
        $queryPembayaran = "INSERT INTO pembayaran (pemesanan_id, tanggal_pembayaran, status, bukti_pembayaran)
                            VALUES ('$pemesanan_id', '$tanggal_pembayaran', '$status', '$filePath')";

        if (mysqli_query($koneksi, $queryPembayaran)) {
            // Data pembayaran berhasil ditambahkan, lakukan pengalihan atau tindakan lain yang sesuai
            //echo "Pembayaran berhasil. Terima kasih!";
            echo '<html>';
            echo '<head>';
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '</head>';
            echo '<body>';
            echo '<script>';
            echo 'Swal.fire({';
            echo '  icon: "success",';
            echo '  title: "Bukti Pembayaran Anda Berhasil Terkirim!",';
            echo '  text: "Selalu cek website secara berkala untuk melihat status pembayaran terverifikasi oleh Admin",';
            echo '}).then(function() {';
            echo '  window.location.href = "../../pemesanan_pelanggan.php";'; // Ganti "halaman_pemesanan.php" dengan URL halaman pemesanan yang sesuai
            echo '});';
            echo '</script>';
            echo '</body>';
            echo '</html>';
            // Set status pemesanan menjadi "Sudah Bayar"
            $queryUpdateStatus = "UPDATE pemesanan SET status = 'Telah Bayar' WHERE pemesanan_id = '$pemesanan_id'";
            if (mysqli_query($koneksi, $queryUpdateStatus)) {
                // Status pemesanan berhasil diupdate
                echo "Status pemesanan berhasil diupdate.";
            } else {
                // Handle kesalahan jika gagal mengupdate status pemesanan
                echo "Terjadi kesalahan saat mengupdate status pemesanan. Kembali <a href='../../pembayaran_pelanggan.php'>ke halaman Pembayaran</a>.";
            }
        } else {
            // Handle kesalahan jika query gagal
            echo "Terjadi kesalahan saat memasukkan data pembayaran. Kembali <a href='../../pembayaran_pelanggan.php'>ke halaman Pembayaran</a>.";
        }
    } else {
        // Handle kesalahan jika gagal memindahkan file
        echo "Terjadi kesalahan saat mengunggah file. Kembali <a href='../../pembayaran_pelanggan.php'>ke halaman Pembayaran</a>.";
    }
} else {
    // Handle jika tidak ada file yang diunggah
    echo "Tidak ada file yang diunggah. Kembali <a href='../../pembayaran_pelanggan.php'>ke halaman Pembayaran</a>.";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
