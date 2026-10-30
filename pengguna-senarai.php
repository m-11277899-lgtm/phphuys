<?php
session_start();
include('connection.php');
include('header.php');
include('kawalan.php');
?>

<h2 align='center'>SENARAI PENGGUNA</h2>
<table align='center' width='80%' border='1' id='saiz'>
    <tr bgcolor='lightblue'>
        <td colspan='5' style='padding: 10px;'>
        <!-- Borang carian pengguna -->
        <form action='' method='POST' style='margin:0;'>
            <input type='text' name='nama_pengguna' placeholder='Carian'>
            <input type='submit' value='Cari'>
        </form>
        </td>
    </tr>

    <tr bgcolor='lightgray'>
        <th width='35%' style='padding: 8px;'>Nama Pengguna</th>
        <th width='15%'>Nombor Telefon</th>
        <th width='10%'>Katalaluan</th>
        <th width='10%'>Jenis Pengguna</th>
        <th width='20%'>Tindakan</th>
    </tr>

    <tr>
        <td colspan='4'></td>
        <td align='right' style='padding: 5px;'>
            <button onclick="window.location.href='pengguna-upload.php'">
            [ + ] Muat Naik Data Pengguna
            </button>
            <?php include('butang-saiz.php'); ?>
        </td>
    </tr>
<?php
# Tambah syarat dalam carian pengguna melalui nama_pengguna (ditapis)
$carian = mysqli_real_escape_string($condb, $_POST['nama_pengguna'] ?? '');
$tambahan = $carian !== '' ? " WHERE pengguna.nama_pengguna LIKE '%" . $carian . "%'" : "";

# Arahan SQL untuk carian data pengguna
$arahan_papar = "SELECT * FROM pengguna $tambahan ORDER BY jenis_pengguna";
$laksana = mysqli_query($condb, $arahan_papar);

# Paparkan setiap rekod pengguna
while ($m = mysqli_fetch_array($laksana)) {
    echo "<tr>
       <td style='padding: 8px;'>" . htmlspecialchars($m['nama_pengguna']) . "</td>
       <td align='center'>" . htmlspecialchars($m['notel']) . "</td>
       <td align='center'>" . htmlspecialchars($m['katalaluan']) . "</td>
       <td>" . htmlspecialchars($m['jenis_pengguna']) . "</td>
       <td align='center'>
| <a href='pengguna-kemaskini-borang.php?notel=" . urlencode($m['notel']) . "'>Kemaskini</a>
| <a href='pengguna-padam.php?notel=" . urlencode($m['notel']) . "'
    onClick=\"return confirm('Anda ingin memadam data ini.')\">Hapus</a> |
       </td>
    </tr>";
}
?>
</table>
<?php include('footer.php'); ?>
