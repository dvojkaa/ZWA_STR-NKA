<?php

global $connection;

$config = parse_ini_file('../config.ini');
$connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['database']);




if (!$connection) {
    die("Error: Unable to connect to MySQL." . PHP_EOL);
}

$q = $_GET["q"];
$q = htmlspecialchars($q);
$q = mysqli_real_escape_string($connection,$q);

$stmt = mysqli_prepare($connection, "SELECT idfora, name FROM fora WHERE name LIKE ?");
mysqli_stmt_bind_param($stmt, "s", $searchTerm);

$searchTerm = '%' . $q . '%';

mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$hint = "";
$i = 0;
while ($row = mysqli_fetch_assoc($result)) {
    if($i >= 15){
        break;
    }
    $idfora = $row['idfora'];
    $name = $row['name'];

    $hint .= "<form method='post' class='searchform' action='single_forum.php'>
                <button type='submit' name='idd' value='$idfora'>$name</button>
              </form><br/>";
    $i++;
}

$response = ($hint == "") ? "no suggestion" : $hint;

echo $response;
