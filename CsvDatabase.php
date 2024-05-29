<?php
/*
  Třída CsvDatabase slouží k manipulaci s daty uloženými v CSV souboru.
  Tato třída obsahuje metody pro načítání dat z CSV souboru, mazání řádků 
 a přepisování CSV souboru novými daty.
 */
class CsvDatabase {
    private $csvFile;

    /*Konstruktor třídy CsvDatabase*/
    public function __construct($csvFile) {
        $this->csvFile = $csvFile;
    }

    /* Metoda pro odstranění řádku z CSV souboru.*/
    public function delete($index) {
        // Načtení dat z CSV souboru
        $data = $this->loadData();

        // Odebrání řádku z dat na základě indexu
        unset($data[$index]);

        // Přepsání souboru s novými daty
        $this->writeData($data);

        return true; // nebo false v případě neúspěchu
    }
     
     /* Private function pro načtení dat z CSV souboru.
     */
    private function loadData() {
    // Načtení obsahu CSV souboru a převedení do pole
        $lines = file($this->csvFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $data = array_map('str_getcsv', $lines);

        return $data;
    }
 
     /* Soukromá metoda pro zápis dat do CSV souboru
     */
    private function writeData($data) {
        // Otevření CSV souboru pro zápis
        $file = fopen($this->csvFile, 'w');

        // Zápis dat z pole zpět do CSV souboru
        foreach ($data as $row) {
            fputcsv($file, $row);
        }

        // Uzavření souboru
        fclose($file);
    }
}
?>
