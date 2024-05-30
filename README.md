# Teploty

Tato webová aplikace, ve které jsou použity programovací jazyky HTML, CSS, PHP a JS, umožňuje prostřednictvím API vkládat a mazat data, která jsou uložena v CSV databázi, a která jsou také zobrazena na webové stránce v tabulce. Uživatel může přidat a smazat data pomocí formulářů na stránce. Přidání a smazání dat se projeví jak v databázi, tak v tabulce na stránce.
1.	Soubor index.php
Tento soubor obsahuje HTML strukturu stránky spolu s PHP kódem pro načítání, zobrazování a mazání dat z CSV databáze, stejně jako JavaScript kód pro odesílání nových dat pomocí API. 
Částí souboru:
HTML struktura obsahuje základní HTML značky pro vytvoření stránky, včetně záhlaví (<head>), těla (<body>) a kontejneru (<div class="container">).
Tabulka zobrazuje data z CSV databáze.
Každý řádek CSV souboru vytváří odpovídající řádek v tabulce.
Každý řádek je rozdělen na buňky, které obsahují hodnoty teplot.
Formulář pro mazání dat umožňuje uživateli vybrat záznam k odstranění. Načítá obsah CSV souboru a dává možnosti pro výběr záznamů.
Po odeslání formuláře  funkce delete.php provede mazání záznamu z CSV souboru.
Formulář pro vložení nových dat obsahuje možnost vložit nové hodnoty teplot.
Po odeslání formuláře provede JavaScript funkci insertData, kterou odešle data pomocí API na api.php.
Po odeslání dat se stránka aktualizuje, aby zobrazila nová data.
Soubor obsahuje integraci PHP kódu pro manipulaci s daty uloženými v CSV souboru a JavaScript kódu pro interaktivitu a odesílání dat pomocí API.

2. Soubor CsvDatabase.php 
V souboru je třída CsvDatabase. 
class CsvDatabase 
Tato třída poskytuje jednoduché rozhraní pro manipulaci s daty uloženými v CSV souboru, umožňující načítání dat, mazání řádků a přepisování souboru novými daty.
Má tuto strukturu a funkce: 
Konstruktor (__construct), který slouží inicializaci instance třídy. 
Parametr $csvFile představuje cestu k CSV souboru, se kterým budou prováděny operace.
Metoda delete($index) slouží k odstranění řádku z CSV souboru na základě zadaného indexu. Parametr $index určuje index řádku, který má být odstraněn.
Metoda načte data, odstraní požadovaný řádek a následně přepíše soubor novými daty.
Privátní metoda loadData() slouží k načtení dat z CSV souboru. Načte obsah CSV souboru a převede ho do pole, kde každý řádek je samostatný prvek pole.
Privátní metoda writeData($data) slouží k zápisu dat do CSV souboru. Otevře CSV soubor pro zápis, zapíše data z pole do souboru ve formátu CSV a následně soubor uzavře.

3 . Soubor delete.php 
Obsahuje kód napsaný v PHP, který zpracovává požadavky HTTP POST na smazání záznamu ze souboru CSV. 
Částí souboru:
Import třídy CsvDatabase: require_once 'CsvDatabase.php';
Tímto kódem se importuje třída CsvDatabase z externího souboru CsvDatabase.php, který obsahuje definici třídy pro práci s CSV soubory.

Kontrola metody požadavku:
if ($_SERVER["REQUEST_METHOD"] == "POST") {
Tato podmínka kontroluje, zda byl požadavek HTTP POST. Pokud ano, znamená to, že tento soubor byl zavolán formulářem odeslaným metodou POST.

Získání indexu záznamu ke smazání:
$index = $_POST['index']
Tento řádek kódu získává index záznamu, který má být smazán, z dat odeslaných metodou POST. Tento index byl předán z formuláře.
Vytváří novou instanci třídy CsvDatabase s názvem souboru 'data.csv', což je jméno CSV souboru, se kterým se bude pracovat. 
$csvDatabase = new CsvDatabase('data.csv')

$success = $csvDatabase->delete($index)
Volá metodu delete na instanci třídy CsvDatabase, která slouží k odstranění záznamu ze souboru CSV podle zadaného indexu.

Zobrazení výsledku:
if ($success) {
    echo "<p>Záznam byl úspěšně smazán.</p>";
    echo '<a href="index.php"><button>Home</button></a>';
} else {
    echo "<p>Chyba při mazání záznamu.</p>";
}
Tento kód zobrazuje zprávy o úspěchu nebo chybě, které se vrátily z metody delete. Pokud je mazání úspěšné, zobrazí se zpráva o úspěšném smazání. V opačném případě se zobrazí chybová zpráva.

4. Soubor api.php
Tento soubor obsahuje PHP kód pro načítání a vkládání dat ze/na server pomocí rozhraní API. 
Soubor nastavuje hlavičku odpovědi na Content-Type: application/json, což značí, že odpověď bude ve formátu JSON.
Provádí kontrolu, zda byl požadavek zaslán metodou GET nebo POST.
Pokud byl požadavek zaslán metodou GET, skript načte všechna data ze souboru data.csv.
Data jsou načtena ze souboru CSV a následně jsou vypsána ve formátu JSON jako odpověď na požadavek.
Pokud byl požadavek zaslán metodou POST, skript zpracuje data získaná z formuláře a vloží je do souboru data.csv.
Nejprve jsou data zformátována a následně se otevře soubor data.csv pro čtení a zápis.
Pokud existuje záznam se stejným datem, je aktualizován; jinak je přidán nový záznam.
Po úspěšném zápisu je vypsána odpověď s potvrzením úspěchu.

Nepodporovaná metoda:
Pokud byl požadavek zaslán jinou metodou než GET nebo POST, skript vrátí odpověď s chybovým kódem 405 (Method Not Allowed) a zprávou o nepodporované metodě v JSON formátu.
Soubor zajišťuje interakci s daty uloženými v CSV souboru pomocí rozhraní API a zpracovává požadavky na jejich načítání a vkládání.

5. Soubor data.csv
Jedná se o databázi CSV, která obsahuje data dnů a naměřené teploty. Jedná se o teploty od 1.1.2024 do 26.5.2024, a to o nejvyšší teploty za určitý den, nejnižší teploty za určitý den, o nejvyšší průměrné teploty a o nejnižší průměrné teploty. 
V prvním řádku jsou názvy sloupců, které reprezentují různé atributy dat.
"DateTime", "High temperature", "Low temperature", "Normal high temperature", "Normal low temperature". Další řádky obsahují oddělená data (čárka, středník).
CSV (Comma-Separated Values) je formát souboru, který slouží k ukládání tabulkových dat. Jedná se o jednoduchý a rozšířený formát, který obsahuje data oddělená určitým znakem a řádky oddělené novým řádkem.
CSV soubory mohou být použity jako způsob ukládání a sdílení dat mezi různými aplikacemi a systémy.

6. Soubor style.css
Obsahuje CSS styly pro základní vzhled webové stránky. 
Definuje body, včetně výběru písma, odstranění okrajů a vnitřního odstupu, a nastavení pozadí. Používá animaci changeBackground, která mění barvu pozadí stránky v odstínech růžové a modré a trvá celkově 8 vteřin po načtení stránky. 
Definuje styly pro kontejner, který obklopuje obsah stránky. Nastavuje maximální šířku, zarovnání na střed, vnitřní odsazení, barvu pozadí, zaoblené rohy a další.
Dále definuje styly pro tabulku, styly pro buňky tabulky th, td, a styly pro tlačítka.





