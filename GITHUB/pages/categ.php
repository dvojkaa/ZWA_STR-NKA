<?php
session_start();

include "db.php";

Connection();


if(isset($_POST["categorie"])){
    $y = $_POST["categorie"];

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
    <form method="post" action="categ.php" class="categ_form">
        <?php
        PrintCatFun(0)
        ?>

    </form>
<fieldset>
        <?php
        global $set;
        $set = "categ";
        $_SESSION["categ"] = $y;
        PrintForFun($y);
        ?>
</fieldset>

    <form method="post" action="index.php">
    <button type="submit" class="button" >Go back to the main page </button>
    </form>
</div>
</body>
</html>

