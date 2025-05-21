<?php
/* 
Glava dokumenta
Ime datoteke: DataFiltering.php
Namen: Funkcije za filtriranje podatkov po določenih kriterijih, kot je podjetje.
Avtor: Rene Kolednik
GitHub: SaB11F
 */

 function filterContacts($contacts, $filterCompany = '') {
    if (empty($filterCompany)) {
        return $contacts;
    }

    return array_filter($contacts, function($contact) use ($filterCompany) {
        return $contact['account'] && $contact['account']['title'] === $filterCompany;
    });
}

function getCompanyList($contacts) {
    $companies = array_unique(array_filter(array_column(array_filter($contacts, fn($c) => isset($c['account'])), 'account'), fn($a) => !empty($a['title'])), SORT_REGULAR);
    return array_column($companies, 'title');
}
?>