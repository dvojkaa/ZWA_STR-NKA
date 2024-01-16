<?php
session_start();
include "db.php";

Connection();
IsLog();


if (isset($_POST["update"])) {
    if ($_POST["csrf_token"] == $_SESSION["csrf_token"]) {
        UpdateFunk();
        unset($_SESSION["csrf_token"]);
    }
}

if (isset($_POST["pic"])) {
    if ($_POST["csrf_token"] == $_SESSION["csrf_token"]) {
        SetPic();
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
include("header.php");


?>
<div>
    <?php echo '<img src=';
    if (getPic() != "") {
        echo getPic();
    } else {
        echo "../images/profiles/empty_img.png";
    }
    echo ' alt="This is your profile pic" id="profil">'; ?>
</div>
<form action="my-account.php" method="post" enctype="multipart/form-data">
    <table>
        <tr>
            <td>
                <label for="image"></label>
                <input type="file" name="image" id="image" alt="Profil pic">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                <button type="submit" name="pic" class="button">Upload pic</button>
            </td>
        </tr>

    </table>
</form>


<form class="form" id="myacc" action="my-account.php" method="post">
<!--    onsubmit="validateForm()"-->
    <script>
        let resform = document.getElementById("myacc");
        resform.addEventListener("submit", function (event) {
            if (!validateFormm()) {
                event.preventDefault();
            }
        });
    </script>
    <table class="registrace">
        <tr>
            <td id="neco">Username <label for="fname">
                    <input type="text" name="username" id="fname" autocapitalize="on"
                    <?php  $name = htmlspecialchars($_SESSION["username"]);
                    echo 'value="' .$name .'"'; ?> autofocus placeholder="First name">
                </label></td>
            <td>E-Mail <label for="mail"></label><input type="email" id="mail" name="mail" autocapitalize="off"
                                                        value="<?php $mail = htmlspecialchars($_SESSION["mail"]);
                                                        echo $mail; ?>" placeholder="E-Mail"></td>
        </tr>
        <tr class="kontrola">
            <td><p class="kontrola" id="username-error"></p>
                <p class="kontrola"><?php if (isset($_POST["update"])) {
                        $username = $_POST["username"];
                        echo userKontr($username);
                    } ?></p></td>
            <td><p class="kontrola" id="email-error"></p>
                <p class="kontrola"><?php if (isset($_POST["update"])) {
                        $mail = $_POST["mail"];
                        echo mailKontr($mail);
                    } ?></p></td>
        </tr>
        <tr>
            <td>New Password <label>
                    <input type="password" autocapitalize="off" name="password" placeholder="Password">
                </label></td>
            <td>Confirm password <label>
                    <input type="password" autocapitalize="off" name="com_password" placeholder="Password">
                </label></td>
        </tr>
        <tr class="kontrola">
            <td><p class="kontrola"><?php if (isset($_POST["update"])) {
                        $password = $_POST["password"];
                        $com_password = $_POST["com_password"];
                        if (!passKontr($password, $com_password)) {
                            echo "Please make sure your passwords are 30 - 3 letters long and same";
                        }
                    } ?></p></td>
            <td><p class="kontrola" id="password-error"></p></td>
        </tr>
        <tr>
            <td></td>
            <td id="last">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION["csrf_token"]; ?>">
                <button type="submit" name="update" class="button">Submit</button>
            </td>
        </tr>
    </table>
</form>
<div class="main-text">
    <fieldset>
        <?php
        PrintForFun("myacc");

        ?>
    </fieldset>
</div>
</body>
</html>



