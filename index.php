<?php
session_start();
include('connection.php');
include('header.php');


# Proses Pengiraan Statistik janji temu
$sql = "SELECT
SUM(CASE WHEN tarikh = CURDATE() THEN 1 ELSE 0 END) AS hari_ini,
SUM(CASE WHEN YEARWEEK(tarikh, 1) = YEARWEEK(CURDATE(), 1) THEN 1 ELSE 0 END) AS minggu_ini,
SUM(CASE WHEN MONTH(tarikh) = MONTH(CURDATE()) AND YEAR(tarikh) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS bulan_ini
FROM janjitemu";


$laksana = mysqli_query($condb, $sql);
$data = mysqli_fetch_assoc($laksana);
?>
<h2 align="center">RINGKASAN JANJI TEMU</h2>


<!-- Papar Statistik dalam jadual-->
<table align="center" width="60%" border="1" cellpadding="10"
style="text-align: center; font-size: 20px;">
    <tr bgcolor='skyblue'>
        <th width="33%">Hari Ini<br><?php echo date ('d/m/Y'); ?></th>
        <th width="33%">Minggu Ini</th>
        <th width="33%">Bulan Ini <br><?php echo date ('M Y'); ?></th>
    </tr>
    <tr>
        <!-- Papar Data. Jika tiada (null), set kepada 0 -->
        <td><b><?php echo $data['hari_ini'] ?? 0; ?></b></td>
        <td><b><?php echo $data['minggu_ini'] ?? 0; ?></b></td>
        <td><b><?php echo $data['bulan_ini'] ?? 0; ?></b></td>
    </tr>
</table>
<br><br>


<?php
include('footer.php');
?>  