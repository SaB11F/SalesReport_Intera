<!--
Glava dokumenta
Ime datoteke: main_view.php
Namen: Predloga za prikaz obrazca, tabele in grafikona na spletni strani.
Avtor: Rene Kolednik
GitHub: SaB11F
 -->
<!DOCTYPE html>
<html lang="sl">
<head>
    <meta charset="UTF-8">
    <title>Poročilo o prodaji</title>
    <link rel="stylesheet" href="assets/css/base.css">
    <link rel="stylesheet" href="assets/css/layout.css">
    <link rel="stylesheet" href="assets/css/forms.css">
    <link rel="stylesheet" href="assets/css/tables.css">
    <link rel="stylesheet" href="assets/css/charts.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <h1>Poročilo o prodaji</h1>
    </header>
    <main class="container">
        <section class="upload-section">
            <form method="post" enctype="multipart/form-data">
                <div class="file-container-wrapper">
                    <div class="file-container">
                        <label for="accounts_file">Naloži accounts.csv:</label>
                        <input type="file" name="accounts_file" id="accounts_file" accept=".csv">
                    </div>
                    <div class="file-container">
                        <label for="contacts_file">Naloži contacts.csv:</label>
                        <input type="file" name="contacts_file" id="contacts_file" accept=".csv">
                    </div>
                    <div class="file-container">
                        <label for="sales_file">Naloži sales.csv:</label>
                        <input type="file" name="sales_file" id="sales_file" accept=".csv">
                    </div>
                </div>
                <div class="button-container">
                    <button type="submit">Generiraj poročilo</button>
                </div>
            </form>
        </section>

        <?php if ($uploadMessage): ?>
            <p class="upload-message"><?php echo htmlspecialchars($uploadMessage); ?></p>
        <?php endif; ?>

        <?php if (!empty($processedContacts)): ?>
            <section class="filter-section">
                <form method="get">
                    <label for="filter_company">Filtriraj po podjetju:</label>
                    <select name="filter_company" id="filter_company" onchange="this.form.submit()">
                        <option value="">Vsa podjetja</option>
                        <?php foreach (getCompanyList($processedContacts) as $company): ?>
                            <option value="<?php echo htmlspecialchars($company); ?>" <?php echo $filterCompany === $company ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($company); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </section>

            <h2>Tabela prodaje</h2>
            <?php generateTable($filteredContacts); ?>

            <div class="export-section">
                <a href="index.php?export=csv" class="export-button">Izvozi v CSV</a>
                <a href="index.php?export=pdf" class="export-button">Izvozi v PDF</a>
            </div>

            <h2>Porazdelitev porabe po kupcih (%)</h2>
            <canvas id="salesChart" width="600" height="400"></canvas>
            <script src="assets/scripts.js"></script>
            <script>
                const chartData = <?php echo json_encode($chartData); ?>;
                console.log('Chart data in HTML:', chartData);
                createPieChart(chartData);
            </script>
        <?php else: ?>
            <p class="upload-message">Prosim, najprej naložite datoteke, da lahko uporabite filtriranje ali izvoz.</p>
        <?php endif; ?>
    </main>
</body>
</html>