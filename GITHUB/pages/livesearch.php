<?php

/**
 * Globalní spojení k databázi.
 * @var mysqli $connection
 */
global $connection;

// Načtení konfiguračních informací z konfiguračního souboru.
$config = parse_ini_file('../config.ini');

/**
 * Konexní parametry pro funkci `mysqli_connect`.
 *
 */
$connectionParams = [
    $config['server'],
    $config['username'],
    $config['password'],
    $config['database']
];

// Vytvoření spojení k databázi.
$connection = mysqli_connect(...$connectionParams);

// Kontrola, zda spojení bylo úspěšné.
if (!$connection) {
    /**
     * Chybová zpráva v případě neúspěšného připojení k MySQL.
     *
     */
    $errorMessage = "Error: Unable to connect to MySQL." . PHP_EOL;
    die($errorMessage);
}

/**
 * Hodnota parametru `q` přijatá pomocí HTTP GET.
 * @var string $q
 */
$q = $_GET["q"];
$q = htmlspecialchars($q);

/**
 * Escapovaná hodnota parametru `q` pro bezpečné použití v SQL dotazu.
 * @var string $q
 */
$q = mysqli_real_escape_string($connection, $q);

/**
 * Připravený dotaz pro vyhledávání ve fora podle jména.
 * @var mysqli_stmt $stmt
 */
$stmt = mysqli_prepare($connection, "SELECT idfora, name FROM fora WHERE name LIKE ?");

/**
 * Hledaný výraz s přidanými percenty pro použití ve vyhledávacím dotazu.
 *
 */
$searchTerm = '%' . $q . '%';

// Nastavení hodnoty pro vyhledávací dotaz.
mysqli_stmt_bind_param($stmt, "s", $searchTerm);

// Spuštění připraveného dotazu.
mysqli_stmt_execute($stmt);

/**
 * Výsledek vyhledávání ve fora.
 * @var mysqli_result $result
 */
$result = mysqli_stmt_get_result($stmt);

/**
 * Textový řetězec pro nápovědu (suggestion).
 *
 */
$hint = "";
$i = 0;

/**
 * Iterace přes výsledek a vytvoření formuláře pro každý nalezený záznam.
 */
while ($row = mysqli_fetch_assoc($result)) {
    // Omezení na 15 nalezených záznamů.
    if ($i >= 15) {
        break;
    }

    /**
     * ID fora z výsledku vyhledávání.
     * @var int $id
     */
    $id = $row['idfora'];

    /**
     * Název fora z výsledku vyhledávání.
     * @var string $name
     */
    $name = $row['name'];

    // Vytvoření formuláře s tlačítkem pro každý záznam.
    $hint .= "<form method='get' class='searchform' action='single_forum.php'>
                <button type='submit' name='id' value='$id'>$name</button>
              </form><br/>";
    $i++;
}

/**
 * Odpověď pro klienta (výsledek vyhledávání nebo 'no suggestion').
 *
 */
$response = ($hint == "") ? "no suggestion" : $hint;

// Výstup odpovědi.
echo $response;
