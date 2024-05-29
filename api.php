<?php
// Nastavení hlavičky pro odpověď ve formátu JSON
header('Content-Type: application/json');

// Kontrola typu HTTP metody
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
// Metoda GET - načtení všech dat

// Pole pro uchování načtených dat
$data = [];

// Otevření souboru CSV pro čtení
if (($handle = fopen("data.csv", "r")) !== FALSE) {
// Načtení dat řádek po řádku a jejich přidání do pole
while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
 $data[] = $row;
}
fclose($handle); // Uzavření souboru
}

// Výstup odpovědi ve formátu JSON
echo json_encode($data);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
// Metoda POST - vložení nových dat

// Získání a formátování dat z POST požadavku
    $date = date('Y-m-d H:i:s', strtotime($_POST['date']));
    $highTemp = $_POST['high_temp'];
    $lowTemp = $_POST['low_temp'];
    $normalHighTemp = $_POST['normal_high_temp'];
    $normalLowTemp = $_POST['normal_low_temp'];
    $newData = [$date, $highTemp, $lowTemp, $normalHighTemp, $normalLowTemp];

// Otevření souboru CSV pro čtení a zápis
    $file = fopen("data.csv", "r+");

// Načtení aktuálních dat ze souboru
    $currentData = [];
    while (($row = fgetcsv($file)) !== false) {
    $currentData[] = $row;
    }

 // Hledání existujícího záznamu pro aktualizaci nebo přidání nového záznamu
    $found = false;
foreach ($currentData as $key => $rowData) {
    if ($rowData[0] === $date) {
// Aktualizace existujícího záznamu, pokud byl nalezen záznam se shodným datem
    $currentData[$key] = $newData;
    $found = true;
    break; // Ukončení cyklu po nalezení prvního shodného záznamu
    }
}
if (!$found) {
// Přidání nového záznamu, pokud nebyl nalezen žádný záznam se shodným datem
    $currentData[] = $newData;
}

// Vyprázdnění souboru a zápis všech dat
ftruncate($file, 0); // Vyprázdnění souboru
rewind($file); // Nastavení kurzoru na začátek souboru
foreach ($currentData as $rowData) {
    fputcsv($file, $rowData); // Zápis každého řádku do souboru ve formátu CSV
}
fclose($file); // Uzavření souboru

// Odpověď s potvrzením
echo json_encode(['message' => 'Data byla úspěšně aktualizována nebo vložena']);
} else {
// Nepodporovaná metoda
http_response_code(405); // Method Not Allowed
echo json_encode(['error' => 'Nepodporovaná metoda']);
}

?>