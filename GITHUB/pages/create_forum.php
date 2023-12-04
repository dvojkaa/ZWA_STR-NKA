<?php
session_start();

include "db.php";

Connection();
IsLog();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php") ?>
</head>
<body>

<?php

if(isset($_POST["submit_form"])){
    if($_POST["csrf_token"] == $_SESSION["csrf_token"]){
        AddForFun();
       unset($_SESSION["csrf_token"]);
    }
}

include("header.php");



?>

<form class="form_div" action="../pages/create_forum.php" method="post" onsubmit=" return userKontr();">
    <table class="create">
        <tr class="forum">
            <td>Give your form name: <label for="username"></label><input type="text" id="username" required class="reqa" name="name_form" value="<?php if(isset($_POST["submit_form"])){  $name = htmlspecialchars($_POST["name_form"]); $name = mysqli_real_escape_string($connection, $name); echo $name;}?>" autocapitalize="on" autofocus placeholder="Name"><p><?php  if(isset($_POST["submit_form"])){if( strlen($name) > 30){ echo "Wrong input or lenght (30Max)";}} ?></p></td>
        </tr>
        <p class="kontrola" id="username-error"></p>
        <tr>

            <td class="categ_radio">
                <?php
                $set = "create";
                PrintCatFun($set)
                ?>
            </td>
        </tr>
        <tr class="forum">
            <td><label for="text_form"></label><input type="text" id="text_form" required class="reqa" name="text_form" value="<?php if(isset($_POST["submit_form"])){$text_form = htmlspecialchars($_POST["text_form"]); $text_form = mysqli_real_escape_string($connection, $text_form);  echo $text_form;}?>"  autocapitalize="on" placeholder="Your questions belongs here"></td>
        </tr>
    </table>
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
    <button type="submit" name="submit_form" class="button last">Submit </button>
</form>




</body>
</html>