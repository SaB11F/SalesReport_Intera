<?php
/* 
Glava dokumenta
Ime datoteke: ExportCSV.php
Namen: Funkcija za izvoz obdelanih podatkov v CSV format.
Avtor: Rene Kolednik
GitHub: SaB11F
 */

function exportToCSV($contacts) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="porocilo_prodaje.csv"');

    $output = fopen('php://output', 'w');
    fputcsv($output, ['Ime', 'Priimek', 'Datum rojstva', 'Podjetje', 'Skupaj nakupov', 'Skupaj vrednost nakupov', 'Povprecna vrednost nakupa'], ';');

    foreach ($contacts as $contact) {
        if (!$contact['account']) continue;
        $dob = date('d.m.Y', strtotime($contact['date_of_birth']));
        $totalValue = number_format($contact['totalValue'], 2, ',', '');
        $avgValue = number_format($contact['averageValue'], 2, ',', '');
        fputcsv($output, [
            $contact['first_name'],
            $contact['last_name'],
            $dob,
            $contact['account']['title'],
            $contact['totalPurchases'],
            $totalValue,
            $avgValue
        ], ';');
    }

    fclose($output);
    exit;
}
?>