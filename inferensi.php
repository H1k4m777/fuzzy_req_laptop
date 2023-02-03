<?php
function fuzzy_inferensi($penggunaan_game, $budget)
{
    // membership function untuk himpunan budget
    if ($budget == 'low') {
        $mf_budget = min(1, max(0, (1 / 5) * ($budget - 10)));
    } elseif ($budget == 'low-mid') {
        $mf_budget = min(1, max(0, (($budget - 5) / 5), (1 - (($budget - 15) / 5))));
    } elseif ($budget == 'mid') {
        $mf_budget = min(1, max(0, (1 / 5) * ($budget - 15), (1 - (1 / 5) * ($budget - 20))));
    } elseif ($budget == 'mid-high') {
        $mf_budget = min(1, max(0, (($budget - 20) / 5), (1 - (($budget - 25) / 5))));
    } elseif ($budget == 'high') {
        $mf_budget = min(1, max(0, (1 - (1 / 5) * ($budget - 25))));
    } else {
        $mf_budget = 0;
    }

    // fuzzy inferensi
    if ($penggunaan_game == 'sebentar') {
        $inferensi = min($mf_budget, 1);
    } elseif ($penggunaan_game == 'sedang') {
        $inferensi = min($mf_budget, 0.5, 1);
    } elseif ($penggunaan_game == 'lama') {
        $inferensi = min($mf_budget, 0.2, 0.5, 1);
    } else {
        $inferensi = 0;
    }

    return $inferensi;
}

$penggunaan_game = 'sedang';
$budget = 'mid-high';

$inferensi = fuzzy_inferensi($penggunaan_game, $budget);

echo "Nilai inferensi adalah: " . $inferensi;
