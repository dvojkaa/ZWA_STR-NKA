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

if(isset($_POST["add_categ"])) {
    if($_POST["csrf_token"] == $_SESSION["csrf_token"]){
        AddCateg();
        unset($_SESSION["csrf_token"]);
    }

}
if(isset($_POST["update_categ"])) {
    if($_POST["csrf_token"] == $_SESSION["csrf_token"]){
        UpdateCatFun();
        unset($_SESSION["csrf_token"]);
    }

}
if(isset($_POST["delete_categ"])) {
    if($_POST["csrf_token"] == $_SESSION["csrf_token"]){
        DeleteCatFun();
        unset($_SESSION["csrf_token"]);
    }

}


include("header.php"); ?>



<div class="main-text">
<form class="form" action="../pages/edit.php" method="post" onsubmit="return categKontr()">
    <table >
        <tr class="forum">
            <td>Give your categorie a name: <label>
                    <input type="text"  name="categname" id="categname" value="<?php if(isset($_POST["add_categ"])){ $name = htmlspecialchars($_POST["categname"]); $name = mysqli_escape_string($connection, $name); echo $name;}?>" autocapitalize="on" autofocus placeholder="Name">
                </label>
                <p class="kontrola" id="categ-error"><?php  if(isset($_POST["add_categ"])){if( strlen($name) > 30){ echo "Wrong input or lenght (100 Max)";}} ?></td>
        </tr>
        <tr>
            <td></td><td class="last">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                <button type="submit" name="add_categ" class="button">Create </button></td>
        </tr>
    </table>
</form>


<form class="form" action="../pages/edit.php" method="post" onsubmit="return upCategKontr()">
    <table >
        <tr class="forum">
            <p class="p">Update your categorie a name: </p>
                <td><label>
                        <input type="number"  name="id" autocapitalize="off"  placeholder="Id">
                    </label>
                    <label>
                        <input type="text"  name="categname2" id="categname2" value="<?php if(isset($_POST["update_categ"])){$name2 = htmlspecialchars($_POST["categname2"]); $name2 = mysqli_real_escape_string($connection, $name2);  echo $name2;}?>" autocapitalize="on" autofocus placeholder="Name">
                    </label>
                    <p class="kontrola" id="upcateg-error"><?php  if(isset($_POST["update_categ"])){if( strlen($name2) > 30){ echo "Wrong input or lenght (100 Max)";}} ?></td>
        </tr>
        <tr>
            <td></td><td class="last">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                <button type="submit" name="update_categ" class="button">Update </button></td>
        </tr>
    </table>
</form>
<form class="form" action="../pages/edit.php" method="post">
    <table >
        <tr class="forum">
            <td>Delete your categorie a name: <label>
                    <input type="number"  name="id2" autocapitalize="off"  placeholder="Id">
                </label></td>
        </tr>
        <tr>
            <td></td><td class="last">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                <button type="submit" name="delete_categ" class="button">Delete </button></td>
        </tr>
    </table>
</form>

<div class="categ_form">

<!--    -->
<!--    <form method="post" action=fillFunction() class="categ_form">-->
<!---->
<!---->
<!--        --><?php
//        PrintCatFun(0)
//        ?>
<!--    </form>-->

    <?php
            PrintCatFun(0)
            ?>

</div>
</div>


</body>
</html>