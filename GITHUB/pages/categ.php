<?php
session_start();

include "db.php";

Connection();


if(isset($_GET["categorie"])){
    $y = $_GET["categorie"];

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


    echo "<h2 class='categ'>$y </h2>";

?>

<div class="main-text">
    <form method="get" action="categ.php" class="categ_form">
        <?php
        PrintCatFun(0)
        ?>

    </form>
<fieldset>
        <?php
        $_SESSION["categ"] = $y;
        PrintForFun("categ");
        ?>
</fieldset>

    <button type="submit" id="back" class="button" >Go back</button>
</div>
</body>
</html>

