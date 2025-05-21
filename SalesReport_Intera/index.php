<?php
/* 
Glava dokumenta
Ime datoteke: index.php
Namen: Glavna datoteka za obdelavo podatkov, nalaganje datotek in generiranje poročil.
Avtor: Rene Kolednik
GitHub: SaB11F
 */

require_once __DIR__ . '\controllers\files\DataRetrieval.php';
require_once __DIR__ . '\controllers\files\FileUpload.php';
require_once __DIR__ . '\models\DataModel.php';
require_once __DIR__ . '\controllers\table\TableGeneration.php';
require_once __DIR__ . '\controllers\charts\DataPreperationsForCharts.php';
require_once __DIR__ . '\controllers\filtering\DataFiltering.php';
require_once __DIR__ . '\controllers\exports\ExportCSV.php';
require_once __DIR__ . '\controllers\exports\ExportPDF.php';

// Inicializacija seje
session_start();

// Inicializacija
$model = new PodatkowniModel();
$uploadMessage = '';
$processedContacts = [];
$chartData = [];
$filteredContacts = [];
$filterCompany = $_GET['filter_company'] ?? '';

$uploadDir = 'nalozene_datoteke/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Obdelava naloženih datotek in generiranje podatkov
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['accounts_file'])) {
    $uploadMessage = handleFileUploads($uploadDir);

    // Pridobi zadnje naložene datoteke iz seje
    $uploadedFiles = getLastUploadedFiles();

    if (isset($uploadedFiles['accounts']) && isset($uploadedFiles['contacts']) && isset($uploadedFiles['sales'])) {
        $model->loadData($uploadedFiles['accounts'], $uploadedFiles['contacts'], $uploadedFiles['sales']);
        $model->processData();
        $processedContacts = $model->processedContacts;

        if (!empty($processedContacts)) {
            // Shranimo obdelane podatke v sejo
            $_SESSION['processed_contacts'] = $processedContacts;
            $filteredContacts = filterContacts($processedContacts, $filterCompany);
            $chartData = generateChartData($filteredContacts);
        } else {
            $uploadMessage .= 'Ni obdelanih kontaktov za prikaz.';
        }
    } else {
        $uploadMessage .= 'Manjka vsaj ena datoteka. Prosim, naložite vse tri datoteke.';
    }
}

// Obdelava podatkov iz seje za filtriranje in izvoz
if (isset($_SESSION['processed_contacts']) && empty($processedContacts)) {
    $processedContacts = $_SESSION['processed_contacts'];
    $filteredContacts = filterContacts($processedContacts, $filterCompany);
    $chartData = generateChartData($filteredContacts);
}

// Obdelava izvoza
if (isset($_GET['export']) && !empty($processedContacts)) {
    if ($_GET['export'] === 'csv') {
        exportToCSV($processedContacts);
    } elseif ($_GET['export'] === 'pdf') {
        exportToPDF($processedContacts);
    }
}

// Prikaz
include 'views\MainView.php';
?>