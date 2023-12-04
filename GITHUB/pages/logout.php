<?php
session_start();
session_unset();
session_destroy();
session_start();
setcookie("PHPSESSID", "", time()-3600);
header("location:./index.php");
?>