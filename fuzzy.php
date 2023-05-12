<?php

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

//tampilkan hasil
echo "Hitung X Game:<br>";
var_dump($hitungx_game);
echo "<br>";

echo "Hitung X Editing:<br>";
var_dump($hitungx_editing);
echo "<br>";

echo "Hitung X Office:<br>";
var_dump($hitungx_office);
echo "<br>";

echo "Hitung X Programming:<br>";
var_dump($hitungx_programming);
echo "<br>";
