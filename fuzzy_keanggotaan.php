<?php
function hitung_keanggotaan($x, $sebentar, $sedang, $lama)
{
    $keanggotaan = array();
    // Himpunan 'sebentar'
    if ($x <= $sebentar[0]) {
        $keanggotaan['sebentar'] = 1;
    } else if ($x > $sebentar[0] && $x <= $sebentar[1]) {
        $keanggotaan['sebentar'] = ($sebentar[1] - $x) / ($sebentar[1] - $sebentar[0]);
    } else {
        $keanggotaan['sebentar'] = 0;
    }

    // Himpunan 'sedang'
    if ($x <= $sedang[0]) {
        $keanggotaan['sedang'] = 0;
    } else if ($x > $sedang[0] && $x <= $sedang[1]) {
        $keanggotaan['sedang'] = ($x - $sedang[0]) / ($sedang[1] - $sedang[0]);
    } else if ($x > $sedang[1] && $x <= $sedang[3]) {
        $keanggotaan['sedang'] = ($sedang[3] - $x) / ($sedang[3] - $sedang[2]);
    } else {
        $keanggotaan['sedang'] = 0;
    }

    // Himpunan 'lama'
    if ($x <= $lama[0]) {
        $keanggotaan['lama'] = 0;
    } else if ($x > $lama[0] && $x <= $lama[1]) {
        $keanggotaan['lama'] = ($x - $lama[0]) / ($lama[1] - $lama[0]);
    } else {
        $keanggotaan['lama'] = 1;
    }

    return $keanggotaan;
}

$kategori = [
    "game" => [
        "sebentar" => [2, 3],
        "sedang" => [2, 3, 5, 6],
        "lama" => [5, 6],
    ],
    "office" => [
        "sebentar" => [2, 3],
        "sedang" => [2, 3, 7, 8],
        "lama" => [7, 8],
    ],
    "editing" => [
        "sebentar" => [2, 3],
        "sedang" => [2, 3, 11, 12],
        "lama" => [11, 12],
    ],
    "programming" => [
        "sebentar" => [2, 3],
        "sedang" => [2, 3, 7, 8],
        "lama" => [7, 8],
    ]
];

$keanggotaan_game = hitung_keanggotaan(5.4, $kategori['game']['sebentar'], $kategori['game']['sedang'], $kategori['game']['lama']);
$keanggotaan_office = hitung_keanggotaan(7.5, $kategori['office']['sebentar'], $kategori['office']['sedang'], $kategori['office']['lama']);
$keanggotaan_editing = hitung_keanggotaan(0, $kategori['editing']['sebentar'], $kategori['editing']['sedang'], $kategori['editing']['lama']);
$keanggotaan_programming = hitung_keanggotaan(2.5, $kategori['programming']['sebentar'], $kategori['programming']['sedang'], $kategori['programming']['lama']);

print_r($keanggotaan_game);
echo "<br>";
print_r($keanggotaan_office);
echo "<br>";
print_r($keanggotaan_editing);
echo "<br>";
print_r($keanggotaan_programming);
echo "<br>";
