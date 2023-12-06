<!DOCTYPE html>
<html lang="en">

<?php
session_start();
include "db.php";

Connection();

//if(isset($_POST["submitreg"])) {
//    AddFunk();
//}


if(isset($_POST["submitreg"])){
    if($_POST["csrf_token"] == $_SESSION["csrf_token"]){
        AddFunk();
        unset($_SESSION["csrf_token"]);
    }
}

?>
<head>

    <?php include("head.php") ?>

</head>
<body>


<?php  include("header.php");

?>

<br>
    <fieldset>
        <div class="registrace">
            <form class="form" id="registrationForm" action="resgistrace.php" method="post">
<!--                onsubmit="return validateForm();"-->
                <script>
                    let resform = document.getElementById("registrationForm");
                    resform.addEventListener("submit", function (event) {
                        if (!validateForm()) {
                            event.preventDefault();
                        }
                    });
                </script>
                <table class="registrace">
                <tr>
                    <td id="neco">Name <label for="Firstname"></label><input type="text" id="Firstname" name="fname" value="<?php if(isset($_POST["submitreg"])){  $name = htmlspecialchars($_POST["fname"]); echo $name;} ?>" autocapitalize="on" autofocus placeholder="First name"></td>
                    <td>Username <label for="username"></label><input type="text" class="reqa" id="username" required name="username" value="<?php if(isset($_POST["submitreg"])){ $username = htmlspecialchars($_POST["username"]); echo $username;} ?>"  autocapitalize="on" placeholder="Username"></td>
                </tr>
                <tr class="kontrola">
                    <td><p class="kontrola" id="name-error"></p>
                        <p class="kontrola" ><?php if(isset($_POST["submitreg"])){$name = $_POST["fname"];  echo nameKontr($name);} ?></p></td>
                    <td><p class="kontrola" id="username-error"></p>
                        <p class="kontrola" ><?php if(isset($_POST["submitreg"])){$username = $_POST["username"]; echo userKontr($username);} ?></p></td>
                </tr>
                <tr>
                    <td>E-Mail <label for="mail"></label><input type="email" class="reqa" id="mail" required name="mail" value="<?php if(isset($_POST["submitreg"])){$mail = htmlspecialchars($_POST["mail"]);  echo $mail;} ?>" autocapitalize="off" placeholder="E-Mail" >
                    </td>
                    <td>Age <label for="age"></label><input type="number" class="reqa" id="age" name="age" required autocapitalize="off" value="<?php if(isset($_POST["submitreg"])){$age = htmlspecialchars($_POST["age"]); echo $age;} ?>" placeholder="Age if you want to be admin (020602) "></td>
                </tr>
                <tr class="kontrola">
                    <td><p class="kontrola" id="email-error"></p>
                        <p class="kontrola" ><?php if(isset($_POST["submitreg"])){$mail = $_POST["mail"];  echo mailKontr($mail);} ?></p></td>
                    <td><p class="kontrola" id="age-error"></p>
                        <p class="kontrola" ><?php if(isset($_POST["submitreg"])){$age = $_POST["age"];  echo ageKontr($age); }?></p></td>
                </tr>
                <tr>
                    <td>Password <label>
                        <input  type="password" class="reqa" autocapitalize="off" id="password_reg" required name="password" placeholder="Password">
                    </label></td>
                    <td>Confirm password <label>
                        <input type="password" class="reqa" autocapitalize="off" id="cam_password_reg" required name="com_password" placeholder="Password">
                    </label></td>
                </tr>
                <tr class="kontrola">
                    <td><p class="kontrola" id="password-error"></p>
                        <p class="kontrola" >
                            <?php if(isset($_POST["submitreg"])){$password = $_POST["password"]; $com_password = $_POST["com_password"];if(!passKontr($password, $com_password)){echo "Please make sure your passwords are 30 - 3 letters long and same";}} ?>
                        </p></td>

                </tr>
                <tr><td>Red borders are required!</td>
                    <td id="last">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                        <button type="submit" name="submitreg" class="button">Submit </button>
                    </td>
                </tr>
            </table>
            </form>
        </div>
    </fieldset>
</body>
</html>