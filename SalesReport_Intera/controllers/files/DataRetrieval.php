<?php
/* 
Glava dokumenta
Ime datoteke: DataRetrieval.php
Namen: Funkcije za pridobivanje podatkov iz CSV datotek in njihovo pripravo za obdelavo.
Avtor: Rene Kolednik
GitHub: SaB11F
 */


function readCSV($filename) {
    $data = [];
    if (!file_exists($filename)) {
        return $data;
    }
    if (($handle = fopen($filename, 'r')) !== false) {
        $headers = fgetcsv($handle, 1000, ';');
        while (($row = fgetcsv($handle, 1000, ';')) !== false) {
            $data[] = array_combine($headers, $row);
        }
        fclose($handle);
    }
    return $data;
}

function getAccounts($filePath) {
    return readCSV($filePath);
}

function getContacts($filePath) {
    return readCSV($filePath);
}

function getSales($filePath) {
    return readCSV($filePath);
}
?>