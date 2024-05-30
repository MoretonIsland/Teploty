<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">

    <title>Data teploty</title>
    
    
</head>
<body>
<div class="container">  

<h2>Data teploty</h2>

<!-- Tabulka pro zobrazení teplot -->
<table>
    <!-- Hlavička tabulky s názvy sloupců -->
    <tr>
        <th>Datum a čas</th>
        <th>Nejvyšší teplota</th>
        <th>Nejnižší teplota</th>
        <th>Průměrná nejvyšší teplota</th>
        <th>Průměrná nejnižší teplota</th>
    </tr>
    <?php
    // Cesta k CSV souboru
    $csvFile = 'data.csv';


/* Otevře CSV soubor pro čtení. */
$fileHandle = fopen($csvFile, 'r');

// Pokud se nepodaří otevřít soubor, ukončí běh skriptu a vypíše chybovou zprávu.
if ($fileHandle === false) {
    die("Nelze otevřít soubor: $csvFile");
}


    // Čtení řádků z CSV souboru a vytvoření řádků tabulky
while (($row = fgetcsv($fileHandle)) !== false) {
    echo "<tr>";

    // Procházení každého řádku a vytváření buněk tabulky
    foreach ($row as $cell) {
        // Rozdělení buňky podle oddělovače a vložení do odpovídající buňky v tabulce
        $data = explode(";", $cell);

        // Procházení každé hodnoty v buňce a vkládání hodnoty jako obsah buňky tabulky
        foreach ($data as $value) {
            // Převedení obsahu buňky na bezpečný text a vložení do buňky tabulky
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
    }

    // Uzavření řádku tabulky
    echo "</tr>";
}

// Uzavření souboru
fclose($fileHandle);
?>

</table>

<h2>Smazat data</h2>

<form action="delete.php" method="post">
<label for="index">Vyberte záznam k odstranění:</label>
<select id="index" name="index">
<?php
// Načtení obsahu CSV souboru a vytvoření možností pro výběr záznamů
    $csvFile = 'data.csv';
    $fileHandle = fopen($csvFile, 'r');
    if ($fileHandle === false) {
    die("Nelze otevřít soubor: $csvFile");
    }

    $index = 0;
    while (($row = fgetcsv($fileHandle)) !== false) {
    // Vytvoření možnosti pro výběr záznamu s indexem
    echo "<option value=\"$index\">" . htmlspecialchars($row[0]) . "</option>";
    $index++;
    }
    fclose($fileHandle);
    ?>
    </select>
    <button type="submit">Smazat</button>
</form>


<h2>Vložit data</h2>
<form id="insertForm">
    <label for="date">Datum:</label>
    <input type="datetime-local" id="date" name="date" required><br><br>
    <label for="high_temp">Nejvyšší teplota:</label>
    <input type="number" id="high_temp" name="high_temp" step="0.01" required><br><br>
    <label for="low_temp">Nejnižší teplota:</label>
    <input type="number" id="low_temp" name="low_temp" step="0.01" required><br><br>
    <label for="normal_high_temp">Průměrná nejvyšší teplota:</label>
    <input type="number" id="normal_high_temp" name="normal_high_temp" step="0.01" required><br><br>
    <label for="normal_low_temp">Průměrná nejnižší teplota:</label>
    <input type="number" id="normal_low_temp" name="normal_low_temp" step="0.01" required><br><br>
    <button type="submit">Vložit</button>
</form>
</div>

<script>
    // Po odeslání formuláře se provede vložení nových dat
    document.getElementById('insertForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Zabrání přesměrování po odeslání formuláře
        const formData = new FormData(this);
        insertData(formData);
    });

    // Funkce pro vložení nových dat pomocí API
    function insertData(formData) {
        fetch('api.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log('Nová data byla úspěšně vložena:', data);
            location.reload(); // Aktualizace stránky po vložení nových dat
        })
        .catch(error => console.error('Chyba při vkládání dat:', error));
    }
</script>

</body>
</html>
