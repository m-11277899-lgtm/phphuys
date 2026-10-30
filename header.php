<?php
# Mulakan sesi jika belum bermula
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Semak menu ikut jenis pengguna yang berjaya login
$jenis = $_SESSION['jenis_pengguna'] ?? '';
?>

<!-- Tajuk sistem -->
<h1 align='center'>EasyMeet - Sistem e-janjitemu konsultansi peguam</h1>
<hr>

<div style="text-align: center;">
    <!-- Menu ini dipaparkan kepada SEMUA orang -->
    | <a href='index.php'>Laman Utama</a>

    <!-- Menu khas ikut jenis pengguna yang berjaya login -->
    <?php if ($jenis == "admin") { ?>
        | <a href='pengguna-senarai.php'>Senarai Pengguna</a>
        | <a href='janjitemu-senarai.php'>Senarai Janji Temu</a>
        | <a href='laporan.php'>Laporan Janji Temu</a>

    <?php } elseif ($jenis == "pengguna biasa") { ?>
        | <a href='janjitemu.php'>Janji Temu</a>

    <?php } ?>

    <!-- Butang Login/Logout -->
    <?php if (!empty($jenis)) { ?>
        | <a href='logout.php'>Logout</a>

    <?php } else { ?>
        | <a href='login.php'>Log Masuk</a>
        | <a href='signup.php'>Daftar Sini</a>

    <?php } ?>
</div>
<br>
