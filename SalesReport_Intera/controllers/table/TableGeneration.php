<?php
/* 
Glava dokumenta
Ime datoteke: TableGeneration.php
Namen: Funkcije za generiranje HTML tabele na podlagi obdelanih podatkov.
Avtor: Rene Kolednik
GitHub: SaB11F
 */

function printTableHeaders() {
    echo "<tr>
            <th>Ime</th>
            <th>Priimek</th>
            <th>Datum rojstva</th>
            <th>Podjetje</th>
            <th>Skupaj nakupov</th>
            <th>Skupaj vrednost nakupov</th>
            <th>Povprečna vrednost nakupa</th>
          </tr>";
}

function generateTable($contacts) {
    echo "<table>";
    printTableHeaders();
    foreach ($contacts as $contact) {
        if (!$contact['account']) continue;
        $dob = date('d.m.Y', strtotime($contact['date_of_birth']));
        $totalValue = number_format($contact['totalValue'], 2, ',', '');
        $avgValue = number_format($contact['averageValue'], 2, ',', '');
        echo "<tr>
                <td>{$contact['first_name']}</td>
                <td>{$contact['last_name']}</td>
                <td class='right-align'>{$dob}</td>
                <td>{$contact['account']['title']}</td>
                <td class='right-align'>{$contact['totalPurchases']}</td>
                <td class='right-align'>{$totalValue} €</td>
                <td class='right-align'>{$avgValue} €</td>
              </tr>";
    }
    echo "</table>";
}
?>