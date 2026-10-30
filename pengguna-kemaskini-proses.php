<?php
session_start();
include('connection.php');
include('kawalan.php');

# Semak kewujudan data POST
if (!empty($_POST)) {

    # Mengambil dan menapis data POST
    $nama_pengguna  = mysqli_real_escape_string($condb, $_POST['nama_pengguna']);
    $notel          = mysqli_real_escape_string($condb, $_POST['notel']);
    $katalaluan     = mysqli_real_escape_string($condb, $_POST['katalaluan']);
    $jenis_pengguna = mysqli_real_escape_string($condb, $_POST['jenis_pengguna']);
    $notel_lama     = mysqli_real_escape_string($condb, $_POST['notel_lama']);

    # had nama pengguna tidak boleh kosong
    if (trim($_POST['nama_pengguna']) == '') {
        die("<script>alert('Ralat: Nama pengguna tidak boleh kosong.');
        window.history.back();
        </script>");
    }

    # had atas had bawah katalaluan: antara 5 hingga 8 aksara
    if (strlen($katalaluan) < 5 || strlen($katalaluan) > 8) {
        die("<script>alert('Ralat: Kata laluan antara 5 - 8 aksara sahaja.');
        window.history.back();
        </script>");
    }

    # had atas had bawah nombor telefon: mestilah antara 10 hingga 12 digit
    $bil_digit = strlen(trim($_POST['notel']));
    if ($bil_digit < 10 || $bil_digit > 12) {
        die("<script>alert('Ralat: Bil Digit notel antara 10 - 12 digit sahaja.');
        window.history.back();
        </script>");
    }

    # Arahan SQL untuk kemaskini pengguna
    $arahan = "UPDATE pengguna SET
        nama_pengguna = '$nama_pengguna',
        notel = '$notel',
        katalaluan = '$katalaluan',
        jenis_pengguna = '$jenis_pengguna'
        WHERE notel = '$notel_lama'";

    if (mysqli_query($condb, $arahan)) {
        echo "<script>
                alert('Kemaskini Berjaya');
                window.location.href='pengguna-senarai.php';
            </script>";
    } else {
        echo "<script>
                alert('Kemaskini Gagal');
                window.history.back();
              </script>";
    }
} else {
    die("<script>alert('Akses secara terus.');
    window.location.href='pengguna-senarai.php';
    </script>");
}
?>
