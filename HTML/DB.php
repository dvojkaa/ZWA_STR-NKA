<?php


function writeDataToFile()
{
    $name = $_POST["playerName"];
    $score = $_POST["highScore"];

    if (checkScore($name,$score) != null && $name != ""){
        $score = checkScore($name,$score);
    }else{
        return;
    }
    $data = file_exists('../data/leaderboardList.json') ? json_decode(file_get_contents('../data/leaderboardList.json'), true) : [];

    $data[] = array("playerName" => $name, "highScore" => $score);

    file_put_contents('../data/leaderboardList.json', json_encode($data));


}

function checkScore($name, $score)
{
    $fileName = '../data/leaderboardList.json';

    $fileContent = file_get_contents($fileName);

    if ($fileContent === false) {
        return null;

    }
    $data = json_decode($fileContent, true);

    if ($data === null) {
        return null;    }
    $i = 0;
    foreach ($data as $player) {
        if (isset($player['highScore']) && isset($player['playerName']) && $player['playerName'] === $name) {
                $playerScore = $player['highScore'];
                if ($playerScore < $score) {
                    unset($data[$i]);
                    file_put_contents($fileName, json_encode(array_values($data)));
                    return $score;
                } else {
                    return null;
                }
            }
        $i ++;
    }
    return $score;
}

