<?php
session_start();
include('connection.php');
include('header.php');

if (isset($_POST['notel'])) {
    # ambil data yang dihantar melalui form
    $notel      = mysqli_real_escape_string($condb, $_POST['notel']);
    $katalaluan = mysqli_real_escape_string($condb, $_POST['katalaluan']);

    # proses login
    $query = "SELECT * FROM pengguna
              WHERE notel = '$notel' AND katalaluan = '$katalaluan' LIMIT 1";
    $result = mysqli_query($condb, $query);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_array($result);
        $_SESSION['notel']          = $row['notel'];
        $_SESSION['jenis_pengguna'] = $row['jenis_pengguna'];
        echo "<script>window.location.href='index.php';</script>";
        exit;
    } else {
        echo "<script>alert('Login Gagal. Semak No Telefon dan Katalaluan.');
                    window.history.back();</script>";
    }
}
?>
<!-- form / borang login -->
<div style="text-align: center;">
    <h3>Daftar Masuk Pengguna (LOGIN)</h3>
    <p>Sila Lengkapkan Maklumat di bawah</p>
    <form action="" method="POST">
        <b>No. Telefon:</b><br>
        <input type="text" name="notel" required><br><br>
        <b>Kata Laluan:</b><br>
        <input type="password" name="katalaluan" required><br><br>
        <input type="submit" value="Daftar Masuk">
    </form>
</div>
<?php include('footer.php'); ?>
