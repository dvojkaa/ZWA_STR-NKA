<?php
if(isset($_POST["submit"])) {
    LogFunk();
}

if (!isset($_SESSION["csrf_token"])) {
    try {
        $_SESSION["csrf_token"] = bin2hex(random_bytes(32));
    } catch (Exception $e) {
    }
//    echo $_SESSION["csrf_token"];
}


?>


<header>
    <div id="header">
        <div class="wrap">
            <a href="index.php" title="Go to the main page" class="logo"><img src="../images/Icon-black-trans.png" class="logo" alt="Logo"></a>
            <div id="hlavniblok">
                <div class="Search">


                    <form method="post" action="index.php" id="search-form" >
                        <label for="search">
                            <input type="text" placeholder="Search" name="search" onkeyup="showResult(this.value)"></label>
                            <img src="../images/zlustymesic.jpeg" title="Change your theme" alt="Světly režim" id="rezim">
                     </form>
                </div>
                <div id="livesearch">
                </div>
                <ul class="hlavnimenu">

                        <li class="hlavnimenu"><a href="index.php">Home</a></li>
                        <li class=" <?php if (isset($_SESSION["class"])){echo 'hlavnimenu';}else{ echo'hide'; } ?>"><a href="create_forum.php">Create Forum</a></li>
                        <li class=" <?php if (isset($_SESSION["class"])){echo 'hlavnimenu';}else{ echo'hide'; } ?>"><a href="my-account.php">My Account</a></li>
                        <li class=" <?php if(isset($_SESSION["class"])){if ($_SESSION["class"] == "admin"){echo 'hlavnimenu';}}else{ echo'hide'; } ?>"><a href="edit.php">Edit</a></li>

                </ul>
                <form action="logout.php" method="post"> <button type="submit" name="logout" class=" <?php
                if (isset($_SESSION["class"])){
                    echo 'button logout';
                }else{ echo'hide';
                }
                    ?>">Log Out</button> </form>
            </div>
            <div id="login-box" class="active <?php
            if (isset($_SESSION["class"])){
                echo 'hide';
            }
            ?>" >
                <strong class="toggle-login">Log in</strong>
                <form id="login-form" action="index.php" method="post" onsubmit=" return mailKontr();">
                    <div class="input-user"><label for="default">E-amil </label><input type="email" required class="reqa" id="default" placeholder="E-mail" autocapitalize="off"  value="" name="mail"></div>
                    <div class="input-password"><label for="password">Password </label>
                        <input type="password" id="password" autocapitalize="off" placeholder="Password" required class="reqa" value="" name="password">
                    </div>
                    <button type="submit" name="submit" class="button">Log in </button>
                    <div id="toggle-login">
                        <div class="registration">

                            <a href="../pages/resgistrace.php" title="Link to register">Sign up</a>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- / .wrap -->
    </div> <!-- / #header -->
</header>

