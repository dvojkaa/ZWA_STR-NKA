

<?php
global $connection;
global $id;

    $form_user = mysqli_fetch_assoc(mysqli_query($connection, "SELECT user FROM fora WHERE idfora = '$id' "))["user"];
    $form_name = mysqli_fetch_assoc(mysqli_query($connection, "SELECT name FROM fora WHERE idfora = '$id' "))["name"];
    $form_text = mysqli_fetch_assoc(mysqli_query($connection, "SELECT text FROM fora WHERE idfora = '$id' "))["text"];
    $form_time = mysqli_fetch_assoc(mysqli_query($connection, "SELECT time FROM fora WHERE idfora = '$id' "))["time"];

?>
<form class="fora" method="post" action="single_forum.php">
    <button type="submit" class="nothing" name="button_forum">
    <span class="fora_div h3"><?php echo $form_name;?> </span>
    <span class="fora_div"> <?php if(strlen($form_text) >= 20){echo"Text is too long please click";}else{echo $form_text;}?></span><br>
    <span class="fora_div"><?php echo $form_user ;?> </span>
        <span class="fora_div"><?php echo $form_time;?> </span>
        <?php echo '<input type="hidden" name = "idd"  value="' .$id . '" />'  ?>
    </button>

</form>



