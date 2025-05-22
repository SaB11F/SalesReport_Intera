<!--
Datoteka: SimpleSolution.php
Opis: Poročilo o nakupih oseb, ki prikazuje število nakupov, skupno vrednost in povprečno vrednost nakupa.
Podatki so pridobljeni iz CSV datotek (accounts.csv, contacts.csv, sales.csv).
Avtor: Rene Kolednik (SaB11F)
Datum: 22. maj 2025
-->

<?php
// Funkcija za branje CSV datoteke in vrnitev podatkov kot array
function readCSV($filename) {
    $data = [];
    if (($file = fopen($filename, 'r')) !== false) {
        $headers = fgetcsv($file, 0, ';'); // Prva vrstica so naslovi stolpcev
        while (($row = fgetcsv($file, 0, ';')) !== false) {
            $data[] = array_combine($headers, $row);
        }
        fclose($file);
    }
    return $data;
}

// Funkcija za obdelavo podatkov in vrnitev poročila
function generateReportData($accounts, $contacts, $sales) {
    $reportData = [];

    // Ustvari array za accounts
    $accountsById = [];
    foreach ($accounts as $account) {
        $accountsById[$account['id']] = $account['title'];
    }

    // Ustvari array za contacts
    $contactsById = [];
    foreach ($contacts as $contact) {
        $contactsById[$contact['id']] = $contact;
    }

    // Obdelaj sales podatke
    $purchaseStats = [];
    foreach ($sales as $sale) {
        $contactId = $sale['contact'];
        $amount = (float)str_replace(',', '.', $sale['ammount']); // Pretvori , v .
        if (!isset($purchaseStats[$contactId])) {
            $purchaseStats[$contactId] = [
                'number_of_purchases' => 0,
                'total_amount' => 0.0,
            ];
        }
        $purchaseStats[$contactId]['number_of_purchases'] += 1;
        $purchaseStats[$contactId]['total_amount'] += $amount;
    }

    // Ustvari poročilo za vsakega kontakta z nakupi
    foreach ($purchaseStats as $contactId => $stats) {
        if (isset($contactsById[$contactId])) {
            $contact = $contactsById[$contactId];
            $accountId = $contact['account_id'];
            $company = isset($accountsById[$accountId]) ? $accountsById[$accountId] : 'Unknown';
            $numberOfPurchases = $stats['number_of_purchases'];
            $totalAmount = $stats['total_amount'];
            $averagePurchase = $numberOfPurchases > 0 ? $totalAmount / $numberOfPurchases : 0;

            // Formatiraj datum in denarne vrednosti
            $dateOfBirth = date('d.m.Y', strtotime($contact['date_of_birth']));
            $totalAmountFormatted = number_format($totalAmount, 2, ',', '.') . ' €';
            $averagePurchaseFormatted = number_format($averagePurchase, 2, ',', '.') . ' €';

            $reportData[] = [
                'first_name' => $contact['first_name'],
                'last_name' => $contact['last_name'],
                'date_of_birth' => $dateOfBirth,
                'company' => $company,
                'number_of_purchases' => $numberOfPurchases,
                'total_amount' => $totalAmountFormatted,
                'average_purchase' => $averagePurchaseFormatted,
            ];
        }
    }

    // Sortiraj po številu nakupov v padajočem vrstnem redu (3, 2, 1)
    usort($reportData, function($a, $b) {
        return $b['number_of_purchases'] <=> $a['number_of_purchases'];
    });

    return $reportData;
}

// Funkcija za generiranje HTML tabele iz poročila
function generateHTMLTable($reportData) {
    $html = '<table border="1">';
    $html .= '<tr>';
    $html .= '<th>Ime</th>';
    $html .= '<th>Priimek</th>';
    $html .= '<th style="text-align: right;">Datum rojstva</th>';
    $html .= '<th>Podjetje</th>';
    $html .= '<th style="text-align: right;">Število nakupov</th>';
    $html .= '<th style="text-align: right;">Skupna vrednost nakupov</th>';
    $html .= '<th style="text-align: right;">Povprečna vrednost nakupa</th>';
    $html .= '</tr>';

    foreach ($reportData as $row) {
        $html .= '<tr>';
        $html .= '<td>' . htmlspecialchars($row['first_name']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['last_name']) . '</td>';
        $html .= '<td style="text-align: right;">' . htmlspecialchars($row['date_of_birth']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['company']) . '</td>';
        $html .= '<td style="text-align: right;">' . $row['number_of_purchases'] . '</td>';
        $html .= '<td style="text-align: right;">' . $row['total_amount'] . '</td>';
        $html .= '<td style="text-align: right;">' . $row['average_purchase'] . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';
    return $html;
}

// Preberi CSV datoteke
$accounts = readCSV('accounts.csv');
$contacts = readCSV('contacts.csv');
$sales = readCSV('sales.csv');

// Generiraj podatke za poročilo
$reportData = generateReportData($accounts, $contacts, $sales);
?>

<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Poročilo o nakupih</title>
</head>
<body>
    <?php
    echo generateHTMLTable($reportData);
    ?>
</body>
</html>

<!-- Zaženi -->
<!-- php -S localhost:8000 -->
<!-- Odpri v brskalniku -->
<!-- http://localhost:8000/SimpleSolution.php -->