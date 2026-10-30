<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan.php');

# 1. Proses daftar perkhidmatan baru
if (isset($_POST['submit_tambah'])) {
    # Ambil data dari borang dan bersihkan input
    $kod_baru = mysqli_real_escape_string($condb, $_POST['kod_perkhidmatan']);
    $nama_baru = mysqli_real_escape_string($condb, $_POST['nama_perkhidmatan']);

    # Arahan SQL untuk tambah data ke jadual PERKHIDMATAN
    $arahan_tambah = "INSERT INTO perkhidmatan
                      (kod_perkhidmatan, nama_perkhidmatan)
                      VALUES
                      ('$kod_baru', '$nama_baru')";

    # Laksanakan arahan dan papar mesej status
    if (mysqli_query($condb, $arahan_tambah)) {
        echo "<script>
            alert('Tahniah! Jenis perkhidmatan baharu berjaya ditambah.');
            window.location.href='perkhidmatan-senarai.php';
            </script>";
    } else {
        echo "<script>
            alert('Gagal: Kod perkhidmatan mungkin telah wujud.');
            </script>";
    }
}

# 2. PROSES PADAM perkhidmatan
if (isset($_GET['padam'])) {
    $kod_padam = mysqli_real_escape_string($condb, $_GET['padam']);
    $arahan_padam = "DELETE FROM perkhidmatan WHERE kod_perkhidmatan = '$kod_padam'";
    if (mysqli_query($condb, $arahan_padam)) {
        echo "<script>
            alert('Rekod perkhidmatan berjaya dipadam.');
            window.location.href='perkhidmatan-senarai.php';
            </script>";
    }
}
?>

<h2 align='center'>SENARAI PERKHIDMATAN</h2>
<table align='center' width='60%' border='1' style='margin-bottom: 20px;'>
    <tr bgcolor='lightgreen'>
        <td align='center' style='padding: 15px;'>
            <form action='' method='POST' style='margin:0;'>
                <b>Tambah perkhidmatan:</b>&nbsp;
                <input type='text' name='kod_perkhidmatan' placeholder='Kod (Cth: K05)' required size='15'>
                <input type='text' name='nama_perkhidmatan' placeholder='Nama perkhidmatan (Cth: Daftar Talian)' required size='40'>
                <input type='submit' name='submit_tambah' value='+ Tambah perkhidmatan'>
            </form>
        </td>
    </tr>
</table>

<table align='center' width='60%' border='1' id='saiz' style='border-collapse: collapse;'>
    <tr bgcolor='lightblue'>
        <td colspan='3' style='padding: 10px;' align='right'>
            <?php include('butang-saiz.php'); ?>
        </td>
    </tr>
    <tr bgcolor='lightgray'>
        <th width='20%' style='padding: 8px;'><b>Kod Perkhidmatan</b></th>
        <th width='60%'><b>Nama Perkhidmatan</b></th>
        <th width='20%'><b>Tindakan</b></th>
    </tr>
    <?php
    # Arahan SQL untuk memaparkan senarai perkhidmatan sedia ada
    $arahan_papar = "SELECT * FROM perkhidmatan ORDER BY kod_perkhidmatan ASC";
    $laksana = mysqli_query($condb, $arahan_papar);

    while ($m = mysqli_fetch_array($laksana)) {
        echo "<tr>
            <td align='center'>".$m['kod_perkhidmatan']."</td>
            <td>".$m['nama_perkhidmatan']."</td>
            <td align='center'>
                <a href='perkhidmatan-senarai.php?padam=".$m['kod_perkhidmatan']."' onclick=\"return confirm('Anda pasti ingin memadam rekod ini?')\">[ X ] Hapus</a>
            </td>
        </tr>";
    }
    ?>
</table>

<?php include('footer.php'); ?>