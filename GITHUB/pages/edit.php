<?php
session_start();
include "db.php";

Connection();
IsLog();



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




if (!isset($_SESSION["csrf_token"])) {
    try {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    } catch (Exception $e) {
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php") ?>
</head>
<body>

<?php


include("header.php"); ?>



<div class="main-text">
<form class="form" id="cate-form" action="../pages/edit.php" method="post">
<!--    onsubmit="return categKontr()"-->
    <script>
        let cateform = document.getElementById("cate-form");
        cateform.addEventListener("submit", function (event) {
            if (!categKontr()) {
                event.preventDefault();
            }
        });</script>
    <table >
        <tr class="forum">
            <td>Give your categorie a name: <label>
                    <input type="text"  name="categname" id="categname" autocapitalize="on" autofocus placeholder="Name">
                </label>
                <p class="kontrola" id="categ-error"><?php  if(isset($_POST["add_categ"])){if( strlen($_POST["add_categ"]) > 30){ echo "Wrong input or lenght (100 Max)";}} ?></td>
        </tr>
        <tr>
            <td></td><td class="last">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                <button type="submit" name="add_categ" class="button">Create </button></td>
        </tr>
    </table>
</form>


<form class="form" id="cate-form2" action="../pages/edit.php" method="post">
<!--    onsubmit="return upCategKontr()"-->
    <script>
        let cateform2 = document.getElementById("cate-form2");
        cateform2.addEventListener("submit", function (event) {
            if (!upCategKontr()) {
                event.preventDefault();
            }
        });
    </script>
    <table >
        <tr class="forum">
            <p class="p">Update your categorie a name: </p>
                <td><label>
                        <input type="number"  name="id" autocapitalize="off"  placeholder="Id">
                    </label>
                    <label>
                        <input type="text"  name="categname2" id="categname2" autocapitalize="on" autofocus placeholder="Name">
                    </label>
                    <p class="kontrola" id="upcateg-error"><?php  if(isset($_POST["update_categ"])){if( strlen($_POST["update_categ"]) > 30){ echo "Wrong input or lenght (30 Max)";}} ?></td>
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

    <form method="get" action="categ.php" class="categ_form">
        <?php
        PrintCatFun(0)
        ?>
    </form>

</div>
</div>


</body>
</html>