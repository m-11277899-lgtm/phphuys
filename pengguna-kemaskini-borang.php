<?php
session_start();
include('connection.php');
include('header.php');
include('kawalan.php');

# Semak data GET, jika tiada terus hantar ke fail pengguna-senarai
if (empty($_GET['notel'])) {
    die("<script>window.location.href='pengguna-senarai.php';</script>");
}

$notel = mysqli_real_escape_string($condb, $_GET['notel']);
$laksana_data = mysqli_query($condb, "SELECT * FROM pengguna WHERE notel='$notel'");
$m = mysqli_fetch_array($laksana_data);

# Jika rekod tidak dijumpai, balik ke senarai
if (!$m) {
    die("<script>window.location.href='pengguna-senarai.php';</script>");
}
?>

<div><h3>Kemaskini Maklumat Pengguna</h3></div>

<form action='pengguna-kemaskini-proses.php' method='POST'>

    <!-- notel asal dihantar semula untuk kenalpasti rekod -->
    <input type='hidden' name='notel_lama' value='<?php echo htmlspecialchars($m['notel']); ?>'>

    <label>Nama Pengguna:</label>
    <input type='text' name='nama_pengguna' value='<?php echo htmlspecialchars($m['nama_pengguna']); ?>' required><br>

    <label>No. Telefon:</label>
    <input type='text' name='notel' value='<?php echo htmlspecialchars($m['notel']); ?>' required><br>

    <label>Katalaluan: (Antara 5-8 aksara sahaja)</label>
    <input type='text' name='katalaluan' value='<?php echo htmlspecialchars($m['katalaluan']); ?>' required><br>

    <label>Jenis Pengguna:</label>
    <select name='jenis_pengguna' required>
        <option value='<?php echo htmlspecialchars($m['jenis_pengguna']); ?>'><?php echo htmlspecialchars($m['jenis_pengguna']); ?></option>

        <?php
        # Dapatkan senarai jenis Pengguna
        $laksana_arahan = mysqli_query($condb, "SELECT jenis_pengguna FROM pengguna GROUP BY jenis_pengguna");

        while ($n = mysqli_fetch_array($laksana_arahan)) {
            if ($n['jenis_pengguna'] != $m['jenis_pengguna']) {
                echo "<option value='" . htmlspecialchars($n['jenis_pengguna']) . "'> " . htmlspecialchars($n['jenis_pengguna']) . "</option>";
            }
        }
        ?>
    </select><br><br>

    <input type='submit' value='Kemaskini Data'>
</form>
</div>

<?php include('footer.php'); ?>
