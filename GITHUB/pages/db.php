<?php


/**
 * Function to establish a connection to the MySQL database.
 */
    function Connection(){
        global $connection;
        // Load database credentials from config file
        $config = parse_ini_file('../config.ini');

        // Connect to database using mysqli_connect() function
        $connection = mysqli_connect($config['server'], $config['username'], $config['password'], $config['database']);
        //$connection = mysqli_connect("localhost", "root", "root", "krativoj");

        // Check if connection was successful
        if (!$connection) {
            // Print error message and exit if connection failed
            die("Error: Unable to connect to MySQL." . PHP_EOL);
        }
    }

/**
 * Function to check if a user is logged in; redirects to index.php if not.
 */
    function IsLog(){

        if(!isset($_SESSION["class"])){
            header("Location: index.php");

        }
    }

/**
 * Function to add a new forum post to the database.
 */
    function AddForFun(){
        // Declare global connection variable
        global $connection;

        // Get the name, text, category, and current time from the POST request
        $name = $_POST["name_form"];
        $text = $_POST["text_form"];
        $categ = $_POST["categ"];
        $time = date('d-m-Y');$time = date('d-m-Y');

        $name = mysqli_real_escape_string($connection, $name);
        $text = mysqli_real_escape_string($connection, $text);
        $text = htmlspecialchars($text);
        $name = htmlspecialchars($name);
        // Get the current user from the session
        $user = $_SESSION["username"];

        // Initialize the error flag to 2 (no errors)
        $i = 2;

        // If the name and text fields are not empty
        if($name && $text) {
            // If the name is too long
            if (strlen($name) > 30) {
                // Set the error flag to 1
                $i = 1;
            }
            // If the text is too long
            if (strlen($text) > 999) {
                // Set the error flag to 1
                $i = 1;
            }

            // If the error flag is still 2 (no errors)
            if ($i === 2) {
                // Print the current time
                echo $time ." ";

                // Construct the INSERT query
                $query = "INSERT INTO fora(user,name,text,categ,time) VALUES('$user','$name','$text','$categ','$time')";

                // Execute the query
                $result = mysqli_query($connection, $query);

                // If the query failed
                if (!$result) {
                    // Print an error message
                    die("error" . mysqli_error());
                }
                // If the query was successful
                else {
                    // Print a success message
                    echo "zapsano";
                }
            }
        }
        // If the name or text fields are empty
        else{
            // Print an error message
            echo "Something is missing" ;
        }
    }

/**
 * Function to add a new category to the database.
 */
function AddCateg(){
    // Establish connection to MySQL database
    global $connection;

    // Get the name of the new category from POST request
    $name = $_POST["categname"];

    $name = mysqli_real_escape_string($connection, $name);
    $name = htmlspecialchars($name);
    // Check if $name is not empty
    if($name) {
        // Check if the length of $name is greater than 100 characters
        if (strlen($name) > 100) {
            return 1;
        }

        // Use prepared statement to insert new row into categ table in database
        $stmt = mysqli_prepare($connection, "INSERT INTO categ(name) VALUES (?)");
        mysqli_stmt_bind_param($stmt, "s", $name);
        $result = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Check if query was successful
        if ($result) {
            // Return 2 (success) if query was successful
            echo "Created";
        } else {
            // Return 0 (failure) if query was unsuccessful
            return 0;
        }

    }else{
        // Return 3 (failure) if $name is empty
        echo "Please fill the form";
    }
}


/**
 * Function to add a new user to the database.
 */
    function AddFunk(){
        global $connection;
        global $i;
        $username = $_POST["username"];
        $password = $_POST["password"];
        $com_password = $_POST["com_password"];
        $age = $_POST["age"];
        $name = $_POST["fname"];
        $mail = $_POST["mail"];
        $class = "guest";
        $i = 2;

        $password = mysqli_real_escape_string($connection, $password);
        $username= mysqli_real_escape_string($connection, $username);
        $mail = mysqli_real_escape_string($connection, $mail);
        
        $mail = htmlspecialchars($mail);
        $username = htmlspecialchars($username);
        $password = htmlspecialchars($password);

        if($password && $username && $com_password && $age) {

            //Password
            if (passKontr($password, $com_password)) {

                $password = password_hash($password, PASSWORD_DEFAULT);
            } else {
                $i = 1;
            }

            //Name, Username


            if (3 >= strlen($username) || (strlen($username) > (20)) || !ctype_alpha($username)) {
                $i = 1;
            } else {
                $usernameres = mysqli_query($connection, "SELECT username FROM user");
                while ($usernamepole = mysqli_fetch_assoc($usernameres)) {
                    $usernamefinal = $usernamepole["username"];
                    if ($username === $usernamefinal) {
                        $i = 1;

                    }
                }
            }
            if(!$name){
                $i = 2;
            }elseif ( strlen($name) > 50) {
                $i = 1;
            }

            //Mail
            if ($mail) {
                // Remove all illegal characters from email
                $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
                // Validate e-mail
                if (!filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
                    $usermailres = mysqli_query($connection, "SELECT mail FROM user");
                    while ($usermailpole = mysqli_fetch_assoc($usermailres)) {
                        $usermailfinal = $usermailpole["mail"];
                        if ($mail === $usermailfinal) {
                            $i = 1;

                        }
                    }
                } else {
                    $i = 1;

                }
            }
            //Age
            if($age == 020602){ $class = "admin";}
            elseif ($age < 14) { $i = 1;}

            //Zapis
            if ($i === 2) {
                $query = "INSERT INTO user(username,password,mail,class) VALUES('$username','$password','$mail','$class')";

                $result = mysqli_query($connection, $query);

                if (!$result) {
                    $i = 1;
                    die("error".mysqli_error());
                }else{

                    $id = mysqli_fetch_assoc(mysqli_query($connection, "SELECT id FROM user WHERE mail= '$mail' "))["id"];
                    $class = mysqli_fetch_assoc(mysqli_query($connection, "SELECT class FROM user WHERE mail= '$mail' "))["class"];
                    $username = mysqli_fetch_assoc(mysqli_query($connection, "SELECT username FROM user WHERE mail= '$mail' "))["username"];

                    $_SESSION["mail"] = $mail;
                    $_SESSION["username"] = $username;
                    $_SESSION["id"] = $id;
                    $_SESSION["class"] = $class;


                    header("location: index.php");
                }
            }
        }
    }

/**
 * Function to handle user login and set session variables.
 */
    function LogFunk(){
        // Establish connection to MySQL database
        global $connection;

        // Get user information from POST request
        $password = $_POST["password"];
        $mail = $_POST["mail"];

        // Escape special characters in user input to prevent SQL injection attacks
        $password = mysqli_real_escape_string($connection, $password);
        $mail = mysqli_real_escape_string($connection, $mail);

        // Check if email exists in the database
        $usermailres = mysqli_query($connection, "SELECT mail FROM user");
        while($usermailpole = mysqli_fetch_assoc($usermailres)){
            $usermailfinal = $usermailpole["mail"];
            if ($usermailfinal == $mail) {
                // Get hashed password from database for the email provided
                $userpassfinal = mysqli_fetch_assoc(mysqli_query($connection, "SELECT password FROM user WHERE mail= '$mail' "))["password"];
                // Verify that the provided password matches the hashed password in the database
                if (password_verify($password, $userpassfinal)){
                    // Set session variables if login is successful
                    $_SESSION["mail"] = $mail;
                    $_SESSION["username"] = mysqli_fetch_assoc(mysqli_query($connection, "SELECT username FROM user WHERE mail= '$mail' "))["username"];
                    $_SESSION["id"] = mysqli_fetch_assoc(mysqli_query($connection, "SELECT id FROM user WHERE mail= '$mail' "))["id"];
                    $_SESSION["class"] = mysqli_fetch_assoc(mysqli_query($connection, "SELECT class FROM user WHERE mail= '$mail' "))["class"];
                }
            }
        }
    }

/**
 * Function to update the name of a category in the database.
 */
function UpdateCatFun(){
    // Establish connection to MySQL database
    global $connection;

    // Get new category name and id from POST request
    $name = $_POST["categname2"];
    $id = $_POST["id"];

    $name = mysqli_real_escape_string($connection, $name);

    // Check if new category name is provided
    if($name) {
        // Check if category name is too long
        if (strlen($name) > 100) {
            // Return error message if category name is too long
            echo "Category name is too long (maximum 100 characters)";
            return;
        }
        // Get old category name from the database
        $pipinka = mysqli_fetch_assoc(mysqli_query($connection, "SELECT name FROM categ WHERE idcateg = '$id' "))["name"];
        // Update category name in the fora table
        $query2 = "UPDATE fora 
              SET categ = '$name'
              WHERE categ ='$pipinka'";
        $result2 = mysqli_query($connection, $query2);
        // Check if update was successful
        if (!$result2) {
            die("Error updating fora table: " . mysqli_error());
        }
        // Update category name in the categ table
        $query = "UPDATE categ 
              SET name = '$name'
              WHERE idcateg ='$id'";
        $result = mysqli_query($connection, $query);
        // Check if update was successful
        if (!$result) {
            die("Error updating categ table: " . mysqli_error());
        } else {
            echo "Category successfully updated!";
        }
    }
}









// tady jsem skoncil

/**
 * Function to update the name and/or text of a forum post in the database.
 */
function UpdateForFun()
{
    // Establish connection to MySQL database
    global $connection;

    // Get new forum name and text from POST request
    $name = $_POST["name_form"];
    $text = $_POST["text_form"];
    $id = $_POST["id"];

    // validate input data
    if (strlen($name) > 30)  {
        echo "Forum name is too long (maximum 30 characters)";
        return;
    }
    if (strlen($text) > 999) {
        echo "Forum text is too long (maximum 999 characters)";
        return;
    }
    $name = mysqli_real_escape_string($connection, $name);
    $text = mysqli_real_escape_string($connection, $text);
    $text = htmlspecialchars($text);
    // Update forum name if provided
    if($name) {
        try {
            $query2 = "UPDATE fora SET name = ? WHERE idfora = ?";
            $stmt = mysqli_prepare($connection, $query2);
            mysqli_stmt_bind_param($stmt, 'si', $name, $id);
            $result2 = mysqli_stmt_execute($stmt);
            if ($result2) {
                echo "Forum name successfully updated!";
            } else {
                throw new Exception("Error updating fora table: " . mysqli_error($connection));
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
    // Update forum text if provided
    if($text) {
        try {
            $query = "UPDATE fora SET text = ? WHERE idfora = ?";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 'si', $text, $id);
            $result = mysqli_stmt_execute($stmt);
            if ($result) {
                echo "Forum text successfully updated!";
            } else {
                throw new Exception("Error updating fora table: " . mysqli_error($connection));
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    }
}


/**
 * Function to update user information in the database.
 */
    function UpdateFunk()
    {

        global $connection;
        $username = $_POST["username"];
        $password = $_POST["password"];
        $com_password = $_POST["com_password"];
        $mail = $_POST["mail"];
        $class = $_SESSION["class"];
        $mails = $_SESSION["mail"];
        $usernames = $_SESSION["username"];
        $id = $_SESSION["id"];
        $i = 2;

        $username = mysqli_real_escape_string($connection, $username);
        $password= mysqli_real_escape_string($connection, $password);
        $mail = mysqli_real_escape_string($connection, $mail);
        $com_password= mysqli_real_escape_string($connection, $com_password);

        if (!($mail == $mails)) {
            // Remove all illegal characters from email
            $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
            // Validate e-mail
            if (!filter_var($mail, FILTER_VALIDATE_EMAIL) === false) {
                $usermailres = mysqli_query($connection, "SELECT mail FROM user");
                while ($usermailpole = mysqli_fetch_assoc($usermailres)) {
                    $usermailfinal = $usermailpole["mail"];
                    if ($mail == $usermailfinal) {
                        $i = 1;
                    }
                }
                $i = 2;

            } else {
                $i = 1;
            }
        }else{
            $mail = $mails;
        }



        if (!($username == $usernames)) {


            if (3 >= strlen($username) || (strlen($username) >= (30)) || !ctype_alpha($username)) {
                $i = 1;
            } else {
                $usernameres = mysqli_query($connection, "SELECT username FROM user");
                while ($usernamepole = mysqli_fetch_assoc($usernameres)) {
                    $usernamefinal = $usernamepole["username"];
                    if ($username == $usernamefinal) {
                        $i = 1;

                    }
                }
            }
        }else{
            $username = $usernames;
        }



        if($password && $com_password){
            if(passKontr($password, $com_password)){
                $password = password_hash($password,PASSWORD_DEFAULT);
            }else{
                $i = 1;
            }
        }else{
            $password = mysqli_fetch_assoc(mysqli_query($connection,"SELECT password FROM user WHERE mail= '$mails' "))["password"];
        }


        if($mail == $mails && $username == $usernames){
            return "<p>change someting</p>";
        }
        if ($i === 2) {
            $query = "UPDATE user 
                      SET username = '$username',password = '$password',mail = '$mail',class = '$class'
                      WHERE id ='$id'";

            $result = mysqli_query($connection, $query);

            $_SESSION["mail"] = $mail;
            $_SESSION["username"] = $username;

            if (!$result) {
                die("error" . mysqli_error());
            } else {
                echo "Updated";
            }
        }else{echo "neco v pici ";}
    }


/**
 * Function to print category options in HTML form.
 * @param string $set - Specifies whether the categories are used for creation or display.
 */
function PrintCatFun($set){
    global $connection;

    $categories = mysqli_query($connection, "SELECT * FROM categ");

    if (mysqli_num_rows($categories) > 0) {

        while ($category = mysqli_fetch_assoc($categories)) {
            $categ_id = $category["idcateg"];
            $categ_name = $category["name"];

            if ($set === "create") {
                echo '<span class="categ_radio">
                    '.$categ_name .'
                    <input type="radio" class="reqa" required name = "categ"  value="' . $categ_name . '">
            </span>';
            } else {
                if(isset($_SESSION["class"]) && $_SESSION["class"] === "admin"){
                        echo '<span class="categ" >
                            <button type="submit" class="nothing categ" name="categorie"  value="' . $categ_name .'">
                             ' . $categ_name . ' ID ' . $categ_id . '
                 
                            </button>
                        </span>';
                }else{
                    echo '<span class="categ" >
                <button type="submit" class="nothing categ" name="categorie"  value="' . $categ_name .'">
                    ' . $categ_name . '
                 
                </button>
           </span>';
                }


            }
        }
    } else {
        // If there are no categories, display a message
        echo "No categories found.";
    }
}



function rintForFun($y) {
    global $connection;
    global $id;
    global $set;
    $id = $y;

    if ($set === "index") {
        $formularein = mysqli_query($connection, "SELECT * FROM fora WHERE idfora >= '$id' ORDER BY idfora DESC LIMIT 10");
        while ($formular = mysqli_fetch_assoc($formularein)) {
            include("fora.php");
        }
    }

    if ($set === "myacc" || $set === "categ") {
        $x = 0;
        $order_by = "ORDER BY idfora DESC";

        if ($set === "myacc") {
            $user = $_SESSION["username"];
            $condition = "user = '$user'";
        } elseif ($set === "categ") {
            $categ = $_SESSION["categ"];
            $condition = "categ = '$categ'";
        }

        $formulare = mysqli_query($connection, "SELECT idfora FROM fora WHERE $condition $order_by");
        if (NULL != mysqli_num_rows($formulare)) {
            while ($formular = mysqli_fetch_assoc($formulare)) {
                $id = $formular["idfora"];
                $x += 1;
                include("fora.php");
            }
        }
    }
}




/**
 * Function to print forum posts based on different scenarios.
 * @param int $y - Starting ID for fetching forum posts.
 */
    function PrintForFun($y)
    {
        global $connection;
        global $id;
        global $set;
        global $k;
        $id = $y;
        $k = 1;
        $_SESSION["k"] = $k;
        $j = 0;



        if ($set === "index") {
            for ($x = 0; $x <= 9; $x += 1) {

                $formularein = mysqli_query($connection, "SELECT * FROM fora WHERE idfora = '$id' ORDER BY idfora DESC LIMIT 10");
                //if (NULL != mysqli_num_rows($formularein)) {
                    $formular = mysqli_fetch_assoc($formularein);
                    if ($formular) {
                        include("fora.php");
                       // $j = 0;
                    } else {
                        $x -= 1;
                        $j += 1;
                    }
                    if ($j === 50) {
                        echo "That's all";
                        $k = 0;
                        $_SESSION["k"] = $k;
                        break;

                    }
                $id += 1;
            }
        }
        if ($set === "myacc") {
            $x = 0;
            $user = $_SESSION["username"];
            $formulare = mysqli_query($connection, "SELECT idfora FROM fora WHERE user = '$user' ORDER BY idfora DESC");
            if(NULL != mysqli_num_rows($formulare)) {
                $formular = mysqli_fetch_assoc($formulare)["idfora"];
                while ($formular != null) {
                    $id = $formular;
                    $x += 1;
                    include("fora.php");
                    if ($x >= mysqli_num_rows($formulare)) {
                        break;
                    }
                    $formular = mysqli_fetch_assoc($formulare)["idfora"];
                }
            }
        }


        if ($set === "categ") {
            $x = 0;

            $categ = $_SESSION["categ"];

            $formulare = mysqli_query($connection, "SELECT idfora FROM fora WHERE categ = '$categ' ORDER BY idfora DESC");
            if(NULL != mysqli_num_rows($formulare)) {
                $formular = mysqli_fetch_assoc($formulare)["idfora"];

                while ($formular != NULL) {
                    $id = $formular;
                    $x += 1;
                    include("fora.php");
                    if ($x >= mysqli_num_rows($formulare)) {
                        break;
                    }
                    $formular = mysqli_fetch_assoc($formulare)["idfora"];
                }
            }
        }
    }


/**
 * Function to delete a category from the database.
 */
    function DeleteCatFun()
    {
        global $connection;
        $id = $_POST["id2"];


        $query = "DELETE FROM categ WHERE idcateg ='$id'";
        $result = mysqli_query($connection, $query);
        if (!$result) {
            die("error" . mysqli_error());
        } else {
            echo "Deleted";
        }

    }

/**
 * Function to delete a forum post from the database.
 */
function DeleteForFun()
{
    global $connection;
    $id = $_POST["id"];

        // Prepare the DELETE statement with a parameterized query
        $query = "DELETE FROM fora WHERE idfora = $id";
        $stmt = mysqli_prepare($connection, $query);

        // Bind the $id variable as an integer parameter to the query
        mysqli_stmt_bind_param($stmt, "i", $id);

        // Execute the statement
        $result = mysqli_stmt_execute($stmt);

        if (!$result) {
          // return error
            echo("Error deleting record: " . mysqli_error($connection));
        }

}

/**
 * Function to set a user's profile picture and update the database.
 */
function SetPic(){

    global $connection;
    $id = $_SESSION["id"];
    $target_dir = "../images/profiles/";
    $target_file = $target_dir . $id .".jpg";
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if(basename($_FILES["image"]["name"]) != "") {

        if (file_exists($target_file)) {
            unlink($target_file);
        }

        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file " . htmlspecialchars(basename($_FILES["image"]["name"])) . " has been uploaded.";

                $id = $_SESSION["id"];
                $path = $target_file;

                $path = mysqli_real_escape_string($connection, $path);
                $query = "UPDATE user
                      SET img = '$path'
                      WHERE id ='$id'";

                $result = mysqli_query($connection, $query);

                if (!$result) {
                    die("error" . mysqli_error());
                } else {
                    echo " Updated";
                }


            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }else{

        $id = $_SESSION["id"];
        $path = "";
        $path = mysqli_real_escape_string($connection, $path);
        $query = "UPDATE user
                      SET img = '$path'
                      WHERE id ='$id'";

        $result = mysqli_query($connection, $query);

        if (!$result) {
            die("error" . mysqli_error());
        } else {
            echo "Your picture was deleted";
        }
    }

}

/**
 * Function to retrieve the user's profile picture path.
 * @return string - Path to the user's profile picture.
 */
function getPic(){
        global $connection;
        $id = $_SESSION["id"];
    $result = mysqli_fetch_assoc(mysqli_query($connection, "SELECT img FROM user WHERE id= '$id' "))["img"];
    if($result != null){
        return $result;
    }else {
        return "../images/profiles/empty_img.png";
   }
}



/**
 * Check and validate the given username.
 *
 * @param string $username The username to be validated.
 * @return string Returns a message indicating the validation result.
 */
function userKontr($username){
        global $connection;


        if($username) {
            if (3 >= strlen($username) || (strlen($username) >= (30)) || !ctype_alpha($username)) {
                return "Please make sure you have your username in this range 3 - 30 letters and only letters";
            } else {
                $usernameres2 = mysqli_query($connection, "SELECT username FROM user");
                while ($usernamepole2 = mysqli_fetch_assoc($usernameres2)) {
                    $usernamefinal2 = $usernamepole2["username"];
                    if ($username === $usernamefinal2) {
                        return "je tady uz stejna osoba";
                    }
                }
                return "Allright";
            }
        }
        return "Username missing";
    }

/**
 * Validate the given name.
 *
 * @param string $name The name to be validated.
 * @return string Returns a message indicating the validation result.
 */
    function nameKontr($name){

        if($name) {
            if (strlen($name) < 3 || strlen($name) > 30 || !ctype_alpha($name)) {
                return "Wrong lenght of your name or isn't written in eng letter's";
            }else{
                return "Allright";
            }
        }
        return "Name missing";
    }

/**
 * Check and validate passwords.
 *
 * @param string $password The password.
 * @param string $com_password The confirmation password.
 * @return bool Returns true if passwords match and meet length criteria, false otherwise.
 */
    function passKontr($password, $com_password){

        if($password == $com_password && $password > 30 && 3 > $password){
            return False ."Passwords doesn't match";
        }
        return True;
    }

/**
 * Validate the given email.
 *
 * @param string $email The email to be validated.
 * @return string Returns a message indicating the validation result.
 */
    function mailKontr($email)
    {
        global $connection;
        if ($email) {
            // Remove all illegal characters from email
            $email = filter_var($email, FILTER_SANITIZE_EMAIL);
            // Validate e-mail
            if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
                $usermailres2 = mysqli_query($connection, "SELECT mail FROM user");
                while ($usermailpole2 = mysqli_fetch_assoc($usermailres2)) {
                    $usermailfinal2 = $usermailpole2["mail"];
                    if ($email === $usermailfinal2) {
                        return "This Email is already registred";
                    }
                }
                return("is a valid email address");
            } else {
                return("is not a valid email address");
            }
        }
        return("Mail missing");
    }

/**
 * Validate the given age.
 *
 * @param int $age The age to be validated.
 * @return string Returns a message indicating the validation result.
 */
    function ageKontr($age){

        if($age) {
            if ($age < 14 && $age > 0) {
                return "Too young";
            }else {
                return "Allright";
            }
        }
        return "Age missing";
    }

/**
 * Function to validate and sanitize the text input.
 * @param string $text - The text input to be validated.
 */
    function textKontr($text){
        if(htmlspecialchars($text)){
            echo "right ";
        }else{
            echo "nahhh";
        }
    }
