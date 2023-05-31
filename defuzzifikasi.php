<?php
// Mengatur koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "test";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
    echo "g konek";
}

// Kueri SQL untuk mencari nilai maksimal berdasarkan kolom "then"
$sql = "SELECT 
            MAX(CASE WHEN `then` = 'low' THEN nilai END) AS max_low,
            MAX(CASE WHEN `then` = 'low_mid' THEN nilai END) AS max_low_mid,
            MAX(CASE WHEN `then` = 'mid' THEN nilai END) AS max_mid,
            MAX(CASE WHEN `then` = 'mid_high' THEN nilai END) AS max_mid_high,
            MAX(CASE WHEN `then` = 'high' THEN nilai END) AS max_high
        FROM tabel_inferensi";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Mengambil nilai maksimal dari setiap kolom "then"
    $row = $result->fetch_assoc();
    $max_low = round($row['max_low'], 2);
    $max_low_mid = round($row['max_low_mid'], 2);
    $max_mid = round($row['max_mid'], 2);
    $max_mid_high = round($row['max_mid_high'], 2);
    $max_high = round($row['max_high'], 2);

    // Menampilkan nilai maksimal
    echo "Nilai Maksimal Low: " . $max_low . "<br>";
    echo "Nilai Maksimal Low Mid: " . $max_low_mid . "<br>";
    echo "Nilai Maksimal Mid: " . $max_mid . "<br>";
    echo "Nilai Maksimal Mid High: " . $max_mid_high . "<br>";
    echo "Nilai Maksimal High: " . $max_high . "<br>";
} else {
    echo "Tidak ada data yang ditemukan.";
}

function defuzzifikasi($max_low, $max_low_mid, $max_mid, $max_mid_high, $max_high)
{
    $nilai_sampel = [
        "low" => [],
        "low_mid" => [6, 7, 8.3, 8.8],
        "mid" => [8.5, 9, 10.5, 11.5],
        "mid_high" => [10.5, 11.5, 11.7, 11.9],
        "high" => [],
    ];

    $hasil1 = 0;
    $hasil2 = 0;

    if ($max_low !== 0) {
        $hasil1 += $max_low * array_sum($nilai_sampel["low"]);
        $hasil2 += $max_low * count($nilai_sampel["low"]);
    }
    if ($max_low_mid !== 0) {
        $hasil1 += $max_low_mid * array_sum($nilai_sampel["low_mid"]);
        $hasil2 += $max_low_mid * count($nilai_sampel["low_mid"]);
    }
    if ($max_mid !== 0) {
        $hasil1 += $max_mid * array_sum($nilai_sampel["mid"]);
        $hasil2 += $max_mid * count($nilai_sampel["mid"]);
    }
    if ($max_mid_high !== 0) {
        $hasil1 += $max_mid_high * array_sum($nilai_sampel["mid_high"]);
        $hasil2 += $max_mid_high * count($nilai_sampel["mid_high"]);
    }
    if ($max_high !== 0) {
        $hasil1 += $max_high * array_sum($nilai_sampel["high"]);
        $hasil2 += $max_high * count($nilai_sampel["high"]);
    }

    return round($hasil1 / $hasil2, 2);
}

// penggunaan fungsi
$rumus = defuzzifikasi($max_low, $max_low_mid, $max_mid, $max_mid_high, $max_high);
echo "Hasil Rumus: " . $rumus;

// Menutup koneksi
$conn->close();
