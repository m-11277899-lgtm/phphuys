<?php
# Mulakan sesi jika belum bermula
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Menguji jika pengguna telah login atau tidak
$jenis = $_SESSION['jenis_pengguna'] ?? '';

# admin dan pengguna biasa hendaklah sama dengan phpmyadmin
$akses = ["admin", "pengguna biasa"];

if (empty($jenis) || !in_array($jenis, $akses)) {
    $mesej = "Sila login untuk mengakses halaman ini.";
    $skrip = "<script>alert('" . $mesej . "'); window.location='logout.php';</script>";
    die($skrip);
}
?>
