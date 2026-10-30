<?php
# Set time zone
date_default_timezone_set('Asia/Kuala Lumpur');

# Lapor semua ralat pangkalan data (tidak sunyi / silent fail)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    # Membuat sambungan ke pangkalan data
    $condb = mysqli_connect('localhost', 'root', '', 'e_skp');
} catch (mysqli_sql_exception $e) {
    die('Sambungan pangkalan data gagal: ' . htmlspecialchars($e->getMessage()));
}

# Set charset supaya data Melayu / simbol disimpan dengan betul
mysqli_set_charset($condb, 'utf8mb4');
?>
