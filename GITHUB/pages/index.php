<?php
    session_start();
include "db.php";
Connection();
//echo "jsem tu";
//exit();

//
//if (!isset($_SESSION["csrf_token"])) {
//    try {
//        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
//    } catch (Exception $e) {
//    }
//}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include("head.php") ?>
</head>
<body>


<?php  include("header.php"); ?>



<div class="main-text">
    <form method="get" action="categ.php" class="categ_form">


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
//        global $set;
//        global $k;
//        $set = "index";
//
//
//
//
//
//
//
//            if(isset($_POST["submit_add"])) {
//                $_SESSION["place"] += 10;
//                PrintForFun();
//            }
//            elseif(isset($_POST["submit_minus"])) {
//                $_SESSION["place"] -= 10;
//                PrintForFun();
//            }else{
//                $_SESSION["place"] = 0;
//                PrintForFun();
//            }
//
//









            if (isset($_GET["submit_add"])) {
                $_SESSION["place"] += 10;
                PrintForFun("index");
            } elseif (isset($_GET["submit_minus"])) {
                $_SESSION["place"] -= 10;
                PrintForFun("index");
            } else {
                $_SESSION["place"] = 0;
                PrintForFun("index");
            }






        //        if(isset($_POST["submit_add"])) {
//
//        }elseif(isset($_POST["submit_minus"])) {
//
//        }else{
//
//        }

//
//
//        if(isset($_GET["submit_add"])) {
//            $tmp = $_SESSION["tmp"];
//            $k = $_SESSION["k"] ;
//            if($k === 1){
//                $tmp += 10;
//                PrintForFun($tmp);
//            }elseif($k === 0){
//                PrintForFun($tmp);
//            }
//            $_SESSION["tmp"] = $tmp;
//        }
//        elseif(isset($_GET["submit_minus"])) {
//
//            $tmp = $_SESSION["tmp"];
//            $tmp -= 10;
//            if($tmp < 10){
//                $tmp = 0;
//            }
//            $k = 1;
//            $_SESSION["k"] = $k;
//            PrintForFun($tmp);
//            $_SESSION["tmp"] = $tmp;
//
//        }
//        else{
//            PrintForFun(0);
//            $tmp = $_SESSION["tmp"] = 0;
//            $k = 1;
//            $_SESSION["k"] = $k;
//        }
//



        ?>
    </fieldset>

    <form method="get" action="index.php">
        <button type="submit" name="submit_add" class="button addten">Next </button>
        <button type="submit" name="submit_minus" class="button addten">Prev </button>
<!--       <input type="hidden" name="csrf_token" value="--><?php //echo $_SESSION['csrf_token']; ?><!--">-->
    </form>
</div>
</body>
</html>



