<?php
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

//HASIL FUNGSI INFERENSI
echo "hasil inferensi:\n";
$durasi = ['xsebentar', 'xsedang', 'xlama'];
// Buat array untuk menyimpan hasil dan kombinasi nilai
$results = [];
//melakukan perulangan dengan pemanggilan untuk fungsi inferensi() dari berbagai kombinasi 
foreach ($durasi as $gameCategory) {
    foreach ($durasi as $editingCategory) {
        foreach ($durasi as $officeCategory) {
            foreach ($durasi as $programmingCategory) {
                //memeriksa apakah sebuah index ada, jika tidak di set 0
                $gameValue = isset($hitungx_game[$gameCategory]) ? $hitungx_game[$gameCategory] : 0;
                $editingValue = isset($hitungx_editing[$editingCategory]) ? $hitungx_editing[$editingCategory] : 0;
                $officeValue = isset($hitungx_office[$officeCategory]) ? $hitungx_office[$officeCategory] : 0;
                $programmingValue = isset($hitungx_programming[$programmingCategory]) ? $hitungx_programming[$programmingCategory] : 0;
                //memanggil fungsi inferensi
                $result = inferensi($gameValue, $editingValue, $officeValue, $programmingValue);
                //untuk menampilkan hasil inferensi beserta kombinasi dari kategorinya
                $combination = "$gameCategory,$editingCategory,$officeCategory,$programmingCategory";
                //echo "$combination : $result\n";
                $results[] = [$combination, $result];
            }
        }
    }
}

// Buat file CSV
$filename = 'output.csv';
$file = fopen($filename, 'w');

// Tulis header kolom
fputcsv($file, ['Kombinasi Nilai', 'Hasil Inferensi']);

// Tulis data
foreach ($results as $row) {
    fputcsv($file, $row);
}

// Tutup file
fclose($file);

echo "Tabel CSV berhasil dibuat dengan nama file: $filename";
