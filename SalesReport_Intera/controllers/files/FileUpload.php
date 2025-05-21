<?php
/* 
Glava dokumenta
Ime datoteke: FileUpload.php
Namen: Funkcije za nalaganje in obdelavo CSV datotek, ki so naložene prek obrazca.
Avtor: Rene Kolednik
GitHub: SaB11F
 */

function handleFileUploads($uploadDir) {
    $message = '';
    $allowedFiles = [
        'accounts_file' => 'accounts',
        'contacts_file' => 'contacts',
        'sales_file' => 'sales'
    ];

    // Ustvari podmapo z unikatnim imenom (na podlagi časovnega žiga)
    $timestamp = date('Ymd_His');
    $sessionDir = $uploadDir . $timestamp . '/';
    if (!is_dir($sessionDir)) {
        mkdir($sessionDir, 0777, true);
    }

    // Shrani unikatne poti datotek v sejo (seja je že začeta v index.php)
    $uploadedFiles = [];

    foreach ($allowedFiles as $inputName => $baseName) {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $tmpName = $_FILES[$inputName]['tmp_name'];
            $name = $_FILES[$inputName]['name'];
            if (pathinfo($name, PATHINFO_EXTENSION) !== 'csv') {
                $message .= "Napaka: Datoteka $name mora biti v formatu CSV. ";
                continue;
            }
            // Unikatno ime datoteke
            $targetFile = $baseName . '_' . $timestamp . '.csv';
            $destination = $sessionDir . $targetFile;
            if (move_uploaded_file($tmpName, $destination)) {
                $message .= "Datoteka $name uspešno naložena kot $targetFile. ";
                $uploadedFiles[$baseName] = $destination;
            } else {
                $message .= "Napaka pri nalaganju datoteke $name. ";
            }
        }
    }

    // Shrani poti v sejo
    if (!empty($uploadedFiles)) {
        $_SESSION['last_uploaded_files'] = $uploadedFiles;
    }

    return $message ?: 'Prosim, naložite datoteke za generiranje poročila.';
}

function getLastUploadedFiles() {
    // Seja je že začeta v index.php
    return $_SESSION['last_uploaded_files'] ?? [];
}
?>