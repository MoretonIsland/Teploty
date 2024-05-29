<?php
// Import třídy CsvDatabase z externího souboru 'CsvDatabase.php'
require_once 'CsvDatabase.php';

// Kontrola, zda je požadavek HTTP POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Získání indexu záznamu, který má být smazán, z POST dat (předpokládá se, že index je předán z formuláře)
    $index = $_POST['index'];

    // Vytvoření instance třídy CsvDatabase s názvem souboru 'data.csv'
    $csvDatabase = new CsvDatabase('data.csv');

    // Volání metody delete třídy CsvDatabase pro smazání záznamu podle zadaného indexu
    $success = $csvDatabase->delete($index);

    // Kontrola, zda mazání bylo úspěšné
    if ($success) {
        // Pokud bylo mazání úspěšné, zobrazí se zpráva o úspěchu
        echo "<p>Záznam byl úspěšně smazán.</p>";
        // Zobrazení tlačítka pro návrat na domovskou stránku
        echo '<a href="index.php"><button>Home</button></a>';
    } else {
        // Pokud mazání selhalo, zobrazí se chybová zpráva
        echo "<p>Chyba při mazání záznamu.</p>";
    }
}
?>
