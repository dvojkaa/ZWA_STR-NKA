<?php
session_start();
include "DB.php";

if(isset($_POST['playerName']) && isset($_POST['highScore'])) {
    writeDataToFile();
    header("Location: score.php");
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Score</title>
    <link rel="stylesheet" href="../CSS/stylesheet.css">
    <link rel="stylesheet" href="../CSS/score.css">
    <link rel="icon" href="data:;base64,iVBORw0KGgo=">
</head>
<body>

<audio id="audioPlayer" autoplay loop>
    <source src="../music/Background_music.mp3" type="audio/mp3">
    Your browser does not support the audio element.
</audio>


<form id="nameForm" method="post" action="score.php">
    <label for="playerName">Enter your name:</label>
    <input type="text" id="playerName" name="playerName" autofocus="autofocus" placeholder="Your name">
    <br>
    <input type="hidden" id="highScore" name="highScore">
    <button type="submit">Save</button>
</form>
<a href="index.html">Get back</a>
<h1>Leaderboard</h1>
<ul id="leaderboardList"></ul>


<script src="../JS/score.js"></script>
</body>
</html>