<?php
session_start();

// Hapus semua data sesi pengguna
session_destroy();
echo '<html>';
echo '<head>';
echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
echo '</head>';
echo '<body>';
echo '<script>';
echo 'Swal.fire({';
echo '  icon: "success",';
echo '  title: "Proses Edit Account Admin Berhasil!",';
echo '  text: "Silahkan Login Kembali.",';
echo '}).then(function() {';
echo '  window.location.href = "../../index.php";';
echo '});';
echo '</script>';
echo '</body>';
echo '</html>';
// Redirect pengguna kembali ke halaman login admin atau halaman beranda admin (sesuai kebutuhan)
//header("location: ../../admin/index.php"); // Ganti dengan URL halaman login admin atau halaman beranda admin
