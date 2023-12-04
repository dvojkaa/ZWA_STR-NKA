<?php
    session_start();
include "db.php";
Connection();
//echo "jsem tu";
//exit();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php") ?>
</head>
<body>


<?php  include("header.php"); ?>



<div class="main-text">
    <form method="post" action="categ.php" class="categ_form">


        <?php
        PrintCatFun(0)
        ?>
    </form>
<!---->
<!--    <fieldset>-->
<!--        --><?php
//        global $set;
//        global $k;
//        $set = "index";
//        PrintForFun(0);
//        ?>
<!--    </fieldset>-->


    <fieldset>
        <?php
        global $set;
        global $k;
        $set = "index";

//        if(isset($_POST["submit_add"])) {
//
//        }elseif(isset($_POST["submit_minus"])) {
//
//        }else{
//
//        }



        if(isset($_POST["submit_add"])) {
            $tmp = $_SESSION["tmp"];
            $k = $_SESSION["k"] ;
            if($k === 1){
                $tmp += 10;
                PrintForFun($tmp);
            }elseif($k === 0){
                PrintForFun($tmp);
            }
            $_SESSION["tmp"] = $tmp;
        }
        elseif(isset($_POST["submit_minus"])) {

            $tmp = $_SESSION["tmp"];
            $tmp -= 10;
            if($tmp < 10){
                $tmp = 0;
            }
            $k = 1;
            $_SESSION["k"] = $k;
            PrintForFun($tmp);
            $_SESSION["tmp"] = $tmp;

        }
        else{
            PrintForFun(0);
            $tmp = $_SESSION["tmp"] = 0;
            $k = 1;
            $_SESSION["k"] = $k;
        }




        ?>
    </fieldset>

    <form method="post" action="index.php">
    <button type="submit" name="submit_add" class="button addten">Next </button>
        <button type="submit" name="submit_minus" class="button addten">Prev </button>
    </form>
</div>
</body>
</html>



