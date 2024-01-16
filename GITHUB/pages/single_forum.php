<?php
session_start();
include "db.php";

Connection();


// get()

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

if (!isset($_SESSION["csrf_token"])) {
    try {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    } catch (Exception $e) {
    }
}



if(isset($_GET["id"]) || isset($_POST["id"])) {
    if(isset($_GET["id"])){

        $idses = $_GET["id"];

    }else if (isset($_POST["id"])){

        $idses = $_POST["id"];
    }

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


?>

<div class="fora_div">
                <?php
                $name_single = mysqli_fetch_assoc(mysqli_query($connection, "SELECT name FROM fora WHERE idfora ='$idses'"))["name"];
                $user_single = mysqli_fetch_assoc(mysqli_query($connection, "SELECT user FROM fora WHERE idfora ='$idses'"))["user"];
                $text_single = mysqli_fetch_assoc(mysqli_query($connection, "SELECT text FROM fora WHERE idfora ='$idses'"))["text"];
                $tim_single = mysqli_fetch_assoc(mysqli_query($connection, "SELECT time FROM fora WHERE idfora ='$idses'"))["time"];
                if(empty($_SESSION["username"])){
                    $_SESSION["username"] = "QWERTZUIOPASDFGHJKL";
                }
                if($_SESSION["username"] === $user_single) {


                    $username = $_SESSION["username"];
//                    onsubmit=" return userKontr();"

                    echo '


                        <form class="fora_div" id="single-fora" action="single_forum.php" method="post">
                        <script>
                        let foradiv = document.getElementById("single-fora");
                        foradiv.addEventListener("submit",function (event) {
                            if (!userKontr()) {
                                event.preventDefault();
                            }
                         });
                        </script>
                      
                       <label><input type="text" id="username" name="name_form" value="'.htmlspecialchars($name_single) .'" placeholder="Name"></label>
                       <p class="kontrola" id="username-error"></p>
                       
                       <label><input type="text" id="text_form"  name="text_form"  value="'.htmlspecialchars($text_single) .'" placeholder="Here you can update your text"></label>
                       <div id="user_time_form">'.htmlspecialchars($user_single) ." " .htmlspecialchars($tim_single) .'</div>
                       <label><input type="hidden" id="id" name="id" value=' . $idses . '></label>
                       <input type="hidden" name="csrf_token" value="' . $_SESSION["csrf_token"] . '">
                       <button type="submit" name="update_for" class="button">Update </button>
                       
                       </form>
                       
                       ';

                    echo '
                       <form method="post" action="single_forum.php">
                       <input type="hidden" name="csrf_token" value="' . $_SESSION["csrf_token"] . '">          
                       <input type="hidden" id="id_form" name="id" value=' . $idses . '>
                       <button type="submit" name="delete_for" class="button last">Delete </button>
                       </form>';


                }else{
                echo '<div class="name_form single h3">'.htmlspecialchars($name_single) .'</div>';
                echo '<div class="text_form single">'.htmlspecialchars($text_single) .'</div>';
                echo '<div id="user_time_form">'.htmlspecialchars($user_single) ." " .htmlspecialchars($tim_single) .'</div>';
                }
            ?>



    <div class="back">
        <button type="submit" id="back" name="submit_form" class="button">Go back</button>
    </div>
</div>




</body>
</html>