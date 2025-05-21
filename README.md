# SalesReport_Intera
Sales Report Generator
Sales Report Generator je spletna aplikacija, razvita v PHP, ki omogoča uporabnikom nalaganje CSV datotek (accounts.csv, contacts.csv, sales.csv), obdelavo podatkov in generiranje poročil v obliki HTML tabele in tortnega diagrama. Uporabniki lahko filtrirajo podatke po podjetju ter izvozijo rezultate v CSV ali PDF format.
Predpogoji
Preden zaženete projekt, se prepričajte, da imate nameščeno naslednje:

PHP (priporočena različica 7.4 ali novejša)
Spletni brskalnik (npr. Chrome, Firefox)
Git (za kloniranje repozitorija)

Navodila za namestitev

Klonirajte repozitorij:git clone https://github.com/SaB11F/sales-report-generator.git


Premaknite se v mapo projekta:cd sales-report-generator


Zaženite vgrajen PHP strežnik:php -S localhost:8000


Odprite projekt v brskalniku:
Pojdite na http://localhost:8000/index.php



Navodila za uporabo

Naložite CSV datoteke:
Uporabite obrazec za nalaganje datotek (accounts.csv, contacts.csv, sales.csv).
Kliknite "Generiraj poročilo" za obdelavo podatkov.


Filtrirajte podatke:
Izberite podjetje iz spustnega seznama za filtriranje rezultatov.


Izvozite poročilo:
Kliknite "Izvozi v CSV" ali "Izvozi v PDF" za prenos poročila.



Struktura projekta

assets/: CSS in JavaScript datoteke ter knjižnica FPDF.
css/: Stili za obrazce, tabele in grafe.
scripts.js: Funkcije za ustvarjanje tortnega diagrama.


controllers/: Logika aplikacije.
FileUpload.php: Funkcije za nalaganje datotek.
DataRetrieval.php: Funkcije za pridobivanje podatkov.
DataFiltering.php: Funkcije za filtriranje podatkov.
DataPreparationForCharts.php: Priprava podatkov za diagrame.
ExportCSV.php: Izvoz v CSV.
ExportPDF.php: Izvoz v PDF.
TableGeneration.php: Generiranje HTML tabele.


models/: Podatkovni modeli.
DataModel.php: Model za obdelavo podatkov.


views/: HTML predloge.
main_view.php: Glavna predloga za prikaz obrazca in poročila.


uploaded_files/: Mapa za shranjevanje naloženih CSV datotek.
index.php: Glavna datoteka za obdelavo podatkov in prikaz.

Kontakt
Za vprašanja ali podporo se obrnite na:

Avtor: Rene Kolednik
GitHub: SaB11F

