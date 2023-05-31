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

//fungsi fuzzifikasi
function fuzzifikasi($x, $sebentar, $sedang, $lama)
{
    $hitungx = array();

    if ($x <= $sebentar) {
        $hitungx['xsebentar'] = 1;
    } else if ($x > $sebentar && $x < $sedang) {
        $hitungx['xsebentar'] = ($x - $sebentar) / ($sedang - $sebentar);
        $hitungx['xsedang'] = ($sedang - $x) / ($sedang - $sebentar);
    } else if ($x == $sedang) {
        $hitungx['xsedang'] = 1;
    } else if ($x > $sedang && $x < $lama) {
        $hitungx['xsedang'] = ($lama - $x) / ($lama - $sedang);
        $hitungx['xlama'] = ($x - $sedang) / ($lama - $sedang);
    } else if ($x >= $lama) {
        $hitungx['xlama'] = 1;
    }

    return $hitungx;
}

//fungsi inferensi
function inferensi($game, $editing, $office, $programming)
{
    $hasil = min($game, $editing, $office, $programming);
    return $hasil;
}

//HASIL FUNGSI FUZZIFIKASI

//menentukan x
$x_game = 150;
$x_office = 400;
$x_editing = 360;
$x_programming = 360;

//memberikan parameter masing2 kategori
$kategori = [
    "game" => [
        "sebentar" => 120,
        "sedang" => 240,
        "lama" => 360,
    ],
    "office" => [
        "sebentar" => 120,
        "sedang" => 300,
        "lama" => 480,
    ],
    "editing" => [
        "sebentar" => 120,
        "sedang" => 420,
        "lama" => 720,
    ],
    "programming" => [
        "sebentar" => 120,
        "sedang" => 300,
        "lama" => 480,
    ]
];

//menghitung nilai keanggotaan masing2 kategori
$hitungx_game = fuzzifikasi($x_game, $kategori["game"]["sebentar"], $kategori["game"]["sedang"], $kategori["game"]["lama"]);
$hitungx_office = fuzzifikasi($x_office, $kategori["office"]["sebentar"], $kategori["office"]["sedang"], $kategori["office"]["lama"]);
$hitungx_editing = fuzzifikasi($x_editing, $kategori["editing"]["sebentar"], $kategori["editing"]["sedang"], $kategori["editing"]["lama"]);
$hitungx_programming = fuzzifikasi($x_programming, $kategori["programming"]["sebentar"], $kategori["programming"]["sedang"], $kategori["programming"]["lama"]);

//tampilkan hasil fuzzyfikasi
echo "fuzzyfikasi X Game:\n";
var_dump($hitungx_game);
echo "\n";

echo "fuzzyfikasi X Editing:\n";
var_dump($hitungx_editing);
echo "\n";

echo "fuzzyfikasi X Office:\n";
var_dump($hitungx_office);
echo "\n";

echo "fuzzyfikasi X Programming:\n";
var_dump($hitungx_programming);
echo "\n";

// Memperbarui kolom "nilai" di setiap baris tabel dengan hasil inferensi yang sesuai
//$stmt = $conn->prepare("UPDATE tabel_inferensi SET nilai = ? WHERE id = ?");

$categories = ['xsebentar', 'xsedang', 'xlama'];
$counter = 1;

foreach ($categories as $gameCategory) {
    foreach ($categories as $editingCategory) {
        foreach ($categories as $officeCategory) {
            foreach ($categories as $programmingCategory) {
                $gameValue = isset($hitungx_game[$gameCategory]) ? $hitungx_game[$gameCategory] : 0;
                $editingValue = isset($hitungx_editing[$editingCategory]) ? $hitungx_editing[$editingCategory] : 0;
                $officeValue = isset($hitungx_office[$officeCategory]) ? $hitungx_office[$officeCategory] : 0;
                $programmingValue = isset($hitungx_programming[$programmingCategory]) ? $hitungx_programming[$programmingCategory] : 0;

                $nilai = round(inferensi($gameValue, $editingValue, $officeValue, $programmingValue), 2);
                //echo $counter . ":" . $nilai . "<br>";

                $sql = "UPDATE tabel_inferensi SET nilai = $nilai WHERE id = $counter";
                if (mysqli_query($conn, $sql)) {
                    echo "Record updated successfully";
                } else {
                    echo "Error updating record: " . mysqli_error($conn);
                }
                $counter++;
            }
        }
    }
}

mysqli_close($conn);
