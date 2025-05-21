<?php
/* 
Glava dokumenta
Ime datoteke: ExportPDF.php
Namen: Funkcija za izvoz obdelanih podatkov v PDF format z uporabo knjižnice FPDF.
Avtor: Rene Kolednik
GitHub: SaB11F
 */

require_once 'assets/fpdf.php';

function exportToPDF($contacts) {
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, 'Porocilo o prodaji', 0, 1, 'C');
    $pdf->Ln(10);

    $pdf->SetFont('Arial', 'B', 12);
    $headers = ['Ime', 'Priimek', 'Datum rojstva', 'Podjetje', 'Skupaj nakupov', 'Skupaj vrednost', 'Povp. vrednost'];
    $widths = [30, 30, 30, 40, 20, 30, 30];
    foreach ($headers as $i => $header) {
        $pdf->Cell($widths[$i], 10, $header, 1);
    }
    $pdf->Ln();

    $pdf->SetFont('Arial', '', 12);
    foreach ($contacts as $contact) {
        if (!$contact['account']) continue;
        $dob = date('d.m.Y', strtotime($contact['date_of_birth']));
        $totalValue = number_format($contact['totalValue'], 2, ',', '') . ' EUR';
        $avgValue = number_format($contact['averageValue'], 2, ',', '') . ' EUR';
        $pdf->Cell($widths[0], 10, $contact['first_name'], 1);
        $pdf->Cell($widths[1], 10, $contact['last_name'], 1);
        $pdf->Cell($widths[2], 10, $dob, 1);
        $pdf->Cell($widths[3], 10, $contact['account']['title'], 1);
        $pdf->Cell($widths[4], 10, $contact['totalPurchases'], 1, 0, 'R');
        $pdf->Cell($widths[5], 10, $totalValue, 1, 0, 'R');
        $pdf->Cell($widths[6], 10, $avgValue, 1, 0, 'R');
        $pdf->Ln();
    }

    $pdf->Output('D', 'porocilo_prodaje.pdf');
    exit;
}
?>