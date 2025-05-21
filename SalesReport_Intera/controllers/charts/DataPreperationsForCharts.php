<?php
/* 
Glava dokumenta
Ime datoteke: DataPreparationForCharts.php
Namen: Funkcije za pripravo podatkov za prikaz v tortnem diagramu.
Avtor: Rene Kolednik
GitHub: SaB11F
 */

function generateChartData($contacts) {
    $chartData = [
        'labels' => [],
        'data' => [],
        'colors' => []
    ];

    $totalValue = array_sum(array_column($contacts, 'totalValue'));
    if ($totalValue == 0) return $chartData;

    foreach ($contacts as $contact) {
        if ($contact['totalValue'] <= 0) continue;
        $percentage = ($contact['totalValue'] / $totalValue) * 100;
        $chartData['labels'][] = "{$contact['first_name']} {$contact['last_name']}";
        $chartData['data'][] = round($percentage, 2);
        $chartData['colors'][] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }

    return $chartData;
}
?>