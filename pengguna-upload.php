<?php
session_start();
include('header.php');
include('kawalan.php');
?>
<!-- Borang muat naik fail pengguna -->
<h3 align="center">Muat Naik Data Pengguna (*.txt)</h3>
<form action='' method='POST' enctype='multipart/form-data' style="text-align:center">

    <p><b>Sila Pilih Fail TXT yang ingin dimuat naik</b></p>
    <input type='file' name='data_pengguna' accept=".txt" required><br><br>
    <button type='submit' name='upload'>Muat Naik</button>

</form>
<?php include('footer.php'); ?>

<?php
# Menyemak kewujudan data POST
if (isset($_POST['upload'])) {

    $fail_sementara = $_FILES["data_pengguna"]["tmp_name"];
    $jenis_fail     = pathinfo($_FILES["data_pengguna"]["name"], PATHINFO_EXTENSION);

    # Semak saiz fail dan jenis fail
    if ($_FILES["data_pengguna"]["size"] > 0 && strtolower($jenis_fail) == "txt") {

        # Baca keseluruhan fail txt menjadi array dan abai baris kosong
        $senarai_data = file($fail_sementara, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        $bil = 0;

        # Loop setiap baris data
        foreach ($senarai_data as $baris) {
            $pecahan = explode("|", $baris);

            # Semak jika baris lengkap dengan 3 nilai
            if (count($pecahan) < 3) continue;
            list($notel, $nama_pengguna, $katalaluan) = array_map('trim', $pecahan);

            # Buang no. siri / ruang di hadapan notel (contoh: "1  4441" -> "4441")
            $notel = preg_replace('/^\d+\s*/', '', $notel);

            if ($notel == '' || $nama_pengguna == '' || $katalaluan == '') continue;

            # Tapis hujung
            $notel         = mysqli_real_escape_string($condb, $notel);
            $nama_pengguna = mysqli_real_escape_string($condb, $nama_pengguna);
            $katalaluan    = mysqli_real_escape_string($condb, substr($katalaluan, 0, 8));

            # Semak jika nombor telefon telah wujud
            $semak = mysqli_query($condb, "SELECT notel FROM pengguna WHERE notel='$notel'");

            if (mysqli_num_rows($semak) > 0) {
                echo "<script>alert('Notel " . htmlspecialchars($notel) . " telah digunakan.');</script>";
            } else {
                # Terus simpan ke dalam pangkalan data
                $sql = "INSERT INTO pengguna (notel, nama_pengguna, katalaluan, jenis_pengguna)
                        VALUES ('$notel', '$nama_pengguna', '$katalaluan', 'pengguna biasa')";
                mysqli_query($condb, $sql);
                $bil++;
            }
        }

        echo "<script>
        alert('Import data selesai. Sebanyak $bil rekod berjaya disimpan.');
        window.location.href='pengguna-senarai.php';
        </script>";
    } else {
        echo "<script>alert('Hanya fail .txt yang boleh dimuat naik.');</script>";
    }
}
?>
