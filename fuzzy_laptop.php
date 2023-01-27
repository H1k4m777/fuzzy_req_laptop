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

// Contoh penggunaan
$x = 5.4; // Nilai yang akan dihitung tingkat keanggotanya
$sebentar = [2, 3]; // domain himpunan 'sebentar'
$sedang = [2, 3, 5, 6]; // domain himpunan 'sedang'
$lama = [5, 6]; // domain himpunan 'lama'
$keanggotaan = hitung_keanggotaan($x, $sebentar, $sedang, $lama);

var_dump($keanggotaan);
echo "<br>";

// Mengambil himpunan dengan nilai paling besar
$himpunan_terpilih = array_search(max($keanggotaan), $keanggotaan);
echo "Nilai x = $x termasuk dalam himpunan '$himpunan_terpilih' dengan tingkat keanggotaannya sebesar: " . max($keanggotaan);
