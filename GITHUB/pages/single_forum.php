<?php
session_start();
include "db.php";

Connection();
if(isset($_POST["idd"])) {
    $idses = $_POST["idd"];
}else{
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php") ?>
</head>
<body>

<?php  include("header.php");

if(isset($_POST["update_for"])) {
    if($_POST["csrf_token"] == $_SESSION["csrf_token"]) {
        UpdateForFun();
        unset($_SESSION["csrf_token"]);
    }
}

if(isset($_POST["delete_for"])) {
    if($_POST["csrf_token"] == $_SESSION["csrf_token"]) {
        DeleteForFun();
        unset($_SESSION["csrf_token"]);
    }
}
?>

<div class="fora_div">
                <?php
                $name_single = mysqli_fetch_assoc(mysqli_query($connection, "SELECT name FROM fora WHERE idfora ='$idses'"))["name"];
                $user_single = mysqli_fetch_assoc(mysqli_query($connection, "SELECT user FROM fora WHERE idfora ='$idses'"))["user"];
                $text_single = mysqli_fetch_assoc(mysqli_query($connection, "SELECT text FROM fora WHERE idfora ='$idses'"))["text"];
                $tim_single = mysqli_fetch_assoc(mysqli_query($connection, "SELECT time FROM fora WHERE idfora ='$idses'"))["time"];
                if(empty($_SESSION["username"])){$_SESSION["username"] = "QWERTZUIOPASDFGHJKL";}
                if($_SESSION["username"] === $user_single) {


                    $username = $_SESSION["username"];

                    echo '<form class="fora_div" action="../pages/single_forum.php" method="post" onsubmit=" return userKontr();">
                       <label><input type="text" id="username" name="name_form" value=' .$name_single .'></label>
                       <p class="kontrola" id="username-error"></p>
                       <label><input type="text" id="text_form"  name="text_form" placeholder=' .$text_single .'></label>
                       <label><input type="hidden" id="id_form" name="id" value=' .$idses .'></label>
                       <input type="hidden" name="csrf_token" value="'. $_SESSION["csrf_token"] .'">
                       <button type="submit" name="update_for" class="button">Update </button></form>
                       
                       <form method="post" action="../pages/single_forum.php">
                       <input type="hidden" name="csrf_token" value="'. $_SESSION["csrf_token"] .'">
                       <button type="submit" name="delete_for" class="button last">Delete </button>
                       <input type="hidden" id="id_form" name="id" value=' .$idses . '></form>';

                }else{
                echo '<div class="name_form single h3">'.$name_single .'</div>';
                echo '<div class="text_form single">'.$text_single .'</div>';
                echo '<div id="user_time_form">'.$user_single ." " .$tim_single .'</div>';
                }
            ?>

<form method="post" class="form" action="index.php">
    <div class="back">
        <button type="submit" name="submit_form" class="button">Go back to the main page </button>
    </div>
</form>
</div>




</body>
</html>