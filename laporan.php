<?php
session_start();
include('header.php');
include('connection.php');
include('kawalan.php');
?>


<!-- CSS Khas untuk mencetak laporan -->
<style>
@media print {
    .no-print { display: none !important; }
    body { background-color: white; }
}


.btn-cetak {
    padding: 8px 15px;
    background: #333;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    border: none;
    font-size: 14px;
}


.btn-cari {
    padding: 8px 15px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}
</style>


<div style="width: 80%; margin: 0 auto;">
<h2 align="center">LAPORAN JANJI TEMU HARIAN</h2>


<!-- 1. KOTAK PILIHAN TARIKH (DROP DOWN KALENDAR) -->
<div class="no-print" style="background: #e9ecef; padding: 20px; border-radius: 8px; border: 1px solid #ccc; text-align: center; margin-bottom: 20px;">
<form action="" method="POST" style="margin: 0;">
<label style="font-size: 16px; font-weight: bold;">Pilih Tarikh Janji Temu: </label>


<?php
# Kekalkan tarikh yang dipilih di dalam kotak form.
$tarikh_pilihan = $_POST['tarikh_carian'] ?? date('Y-m-d');
?>


<input type="date" name="tarikh_carian" value="<?php echo $tarikh_pilihan; ?>" required style="padding: 6px; font-size: 16px;">
<input type="submit" name="papar_laporan" value="Cari Rekod" class="btn-cari">
  
<button type="button" class="btn-cetak" onclick="window.print()">Cetak</button>
</form>
</div>


<!-- 2. HASIL LAPORAN SELEPAS TARIKH DIPILIH -->
<?php
if (isset($_POST['papar_laporan'])) {
    $tarikh = mysqli_real_escape_string($condb, $_POST['tarikh_carian']);
    
    # Tukar format tarikh untuk paparan Tajuk (Dari YYYY-MM-DD ke DD/MM/YYYY)
    $tarikh_cantik = date('d/m/Y', strtotime($tarikh));
?>


    # Header Laporan
    <div align="center">
    <p><b>Jadual Bertugas Bagi Tarikh: <b style='color:blue; font-size:18px;'><?=$tarikh_cantik?></b></b></p>
    </div>


<?php
    $sql_detail = "SELECT j.masa, p.nama_pengguna, p.notel, s.nama_perkhidmatan 
    FROM janjitemu j
    INNER JOIN pengguna p ON j.notel = p.notel
    INNER JOIN perkhidmatan s ON j.kod_perkhidmatan = s.kod_perkhidmatan
    WHERE j.tarikh = '$tarikh'
    ORDER BY j.masa ASC";


    $query_detail = mysqli_query($condb, $sql_detail);
    $jumlah_rekod = mysqli_num_rows($query_detail);


    # Paparan Insight Ringkas (Ringkasan Harian)
    echo "<table width='100%' border='0' cellpadding='10' style='background-color: #fff3cd; color: #856404; border-radius: 5px; margin-bottom: 15px; border: 1px solid #ffeeba;'>";
    echo "<tr>";
    echo "<td align='center'>";
    echo "<b>RINGKASAN HARI INI:</b> Terdapat <b>$jumlah_rekod</b> pelanggan yang telah menempah janji temu pada tarikh ini.";
    echo "</td>";
    echo "</tr>";
    echo "</table>";


    # Jadual Senarai Terperinci
    echo "<table width='100%' border='1' cellpadding='8' style='border-collapse: collapse;'>";
    echo "<tr bgcolor='#1F4E78' style='color: white;'>";
    echo "<th width='5%'>Bil</th>";
    echo "<th width='15%'>Waktu / Masa</th>";
    echo "<th width='35%'>Nama Pelanggan</th>";
    echo "<th width='20%'>No. Telefon</th>";
    echo "<th width='25%'>Urusan / Servis</th>";
    echo "</tr>";


    $bil = 1;
    if ($jumlah_rekod > 0) {
        while ($m = mysqli_fetch_array($query_detail)) {
            echo "<tr>";
            echo "<td align='center'>" . $bil++ . "</td>";
            echo "<td align='center'><b>" . $m['masa'] . "</b></td>";
            echo "<td>" . $m['nama_pengguna'] . "</td>";
            echo "<td align='center'>" . $m['notel'] . "</td>";
            echo "<td align='center'>" . $m['nama_perkhidmatan'] . "</td>";
            echo "</tr>";
        }
    } else {
        # Jika hari tersebut tiada orang tempah
        echo "<tr><td colspan='5' align='center' style='padding: 20px; color: gray;'>
        <i>Tiada sebarang janji temu ditempah pada tarikh ini.</i></td></tr>";
    }
    echo "</table>";


    # Tandatangan bawah Laporan
    echo "<br><br>";
    echo "<div style='float: right; text-align: center; width: 250px;'>";
    echo "<p>Disahkan Oleh:<br><br><br><hr><b>Penyelia Bertugas</b></p>";
    echo "</div>";
    echo "<div style='clear: both;'></div>";


} else {
    # Mesej lalai (default) sebelum carian dibuat
    echo "<br><br><h3 align='center' style='color: gray;'>
    Sila pilih tarikh pada kalendar di atas dan klik 'Cari Rekod'</h3><br><br>";
}
?>
</div>


<div class="no-print"><?php include('footer.php'); ?></div>