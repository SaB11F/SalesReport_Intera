<?php

/* 
Glava dokumenta
Ime datoteke: DataModel.php
Namen: Razred ali funkcije, ki predstavljajo podatkovni model za obdelavo podatkov.
Avtor: Rene Kolednik
GitHub: SaB11F
 */

class PodatkowniModel {
    public $accounts = [];
    public $contacts = [];
    public $sales = [];
    public $processedContacts = [];

    public function loadData($accountsFile, $contactsFile, $salesFile) {
        $this->accounts = getAccounts($accountsFile);
        $this->contacts = getContacts($contactsFile);
        $this->sales = getSales($salesFile);
    }

    public function processData() {
        if (empty($this->accounts) || empty($this->contacts) || empty($this->sales)) {
            return;
        }

        $accountMap = array_column($this->accounts, null, 'id');
        $contactMap = array_column($this->contacts, null, 'id');

        foreach ($this->contacts as &$contact) {
            $contact['account'] = $accountMap[$contact['account_id']] ?? null;
        }

        $salesMap = [];
        foreach ($this->sales as $sale) {
            $contactId = $sale['contact'];
            if (!isset($salesMap[$contactId])) {
                $salesMap[$contactId] = [];
            }
            $salesMap[$contactId][] = $sale;
        }

        foreach ($this->contacts as &$contact) {
            $contactSales = $salesMap[$contact['id']] ?? [];
            $contact['totalPurchases'] = count($contactSales);
            $contact['totalValue'] = array_sum(array_map(fn($sale) => floatval(str_replace(',', '.', $sale['ammount'])), $contactSales));
            $contact['averageValue'] = $contact['totalPurchases'] > 0 ? $contact['totalValue'] / $contact['totalPurchases'] : 0.00;
        }

        $this->processedContacts = $this->contacts;
    }
}
?>