<?php
require_once("database.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = array();
$firstName = "";
$lastName = "";
$username = "";
$password = "";
$dob = "";
$email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = test_input($_POST["fname"]);
    $lastName = test_input($_POST["lname"]);
    $username = test_input($_POST["uname"]);
    $password = test_input($_POST["pass"]);
    $dob = test_input($_POST["DofB"]);
    $email = test_input($_POST["email"]);

    $nameRegex = "/^[a-zA-Z]+$/";
    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $passwordRegex = "/^.{8}$/";
    $dobRegex = "/^\d{4}[-]\d{2}[-]\d{2}$/";
    $emailRegex = "/^[^\s@]+@[^\s@]+\.[^\s@]+$/";

    if (!preg_match($nameRegex, $firstName)) {
        $errors["fname"] = "Invalid First Name";
    }
    if (!preg_match($nameRegex, $lastName)) {
        $errors["lname"] = "Invalid Last Name";
    }
    if (!preg_match($unameRegex, $username)) {
        $errors["uname"] = "Invalid Username";
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors["pass"] = "Invalid Password";
    }
    if (!preg_match($dobRegex, $dob)) {
        $errors["DofB"] = "Invalid DOB";
    }
    if (!preg_match($emailRegex, $email)) {
        $errors["email"] = "Invalid Email Address";
    }

    $target_file = "";

    try {
        $db = new PDO($attr, $db_user, $db_pwd, $opts);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }

    $query = "SELECT username FROM User WHERE username = '$username';";
    $result = $db->query($query);
    $match = $result->fetch();

    if ($match){
        $errors['accountExisted'] = "Sorry, Account is already existed.";
    }
    else {
        $query = "INSERT INTO User (username, first_name, last_name, email, password, date_of_birth, avatar_url) VALUES ('$username', '$firstName', '$lastName', '$email', '$password', '$dob', 'avatar_empty');";
        $result = $db->exec($query);

        if (!$result) {
            $errors['Insert Failed'] = "There was an error inserting your information!";
        }
        else {
            $target_dir = "uploads/";
            $uploadStatus = TRUE;

            $imageFileType = strtolower(pathinfo($_FILES["avatar"]["name"],PATHINFO_EXTENSION));
            $user_id = $db->lastInsertID();
            $target_file = $target_dir . $user_id . "." . $imageFileType;

            if (file_exists($target_file)) {
                $errors['avatar'] = "Sorry, file already exists.";
                $uploadStatus = FALSE;
            }
            if ($_FILES["avatar"]["size"] > 1000000) {
                $errors['avatar'] = "File is too large. Maximum 1MB. ";
                $uploadStatus = FALSE;
            }
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
                $errors['avatar'] = "Bad image type. Only JPG, JPEG, PNG & GIF files are allowed. ";
                $uploadStatus = FALSE;
            }

            if ($uploadStatus){
                $moveStatus = move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file);
                if (!$moveStatus){
                    $errors['avatar'] = "Sorry, there was an error uploading your profile images.";
                    $uploadStatus = FALSE;
                }
            }

            if (!$uploadStatus)
            {
                $query = "DELETE FROM User WHERE user_id = '$user_id';";
                $result = $db->exec($query);
                if (!$result) {
                    $errors["Database Error"] = "could not delete user when avatar upload failed";
                }
                $db = null;
            } 
            else {
                $query =  "UPDATE User SET avatar_url = '$target_file' WHERE user_id = '$user_id';";
                $result = $db->exec($query);
                if (!$result) {
                    $errors["Database Error:"] = "could not update avatar_url";
                } else {
                    $db = null;
                    header("Location: login.php");
                    exit;
                }
            } 
        }
    } 

    if (!empty($errors)) {
        foreach($errors as $type => $message) {
            print("$type: $message \n<br />");
        }
    }

}

?>

<!DOCTYPE html>

<html lang="en-US">
    <header>
        <meta charset="utf-8">
        <title>Sign Up Page</title>
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
        <script src="js/eventHandler.js"></script>
    </header>

    <body>
        <div class="container">
            <header class="header"> 
                <img src="img/logo.jpg" alt="Logo of UOFR" />   
                <h1>SIGN UP PAGE</h1>
            </header>

            <main id="main-body-left">
                <section>
                    <h2>SIGN UP</h2>
        
                    <form action="" method="POST" class="auth-form" id="signup-form" enctype="multipart/form-data">
                        <p class="input-field">
                            <label for="fname">First Name</label>
                            <input type="text" id="fname" name="fname" value="<?= $firstName ?>"/>
                            <p id="error-fname" class="error-mess <?= isset($errors['fname'])?'':'hidden' ?>">First name is invalid.</p>
                        </p>

                        <p class="input-field">
                            <label for="lname">Last Name</label>
                            <input type="text" id="lname" name="lname" value="<?= $lastName ?>"/>
                            <p id="error-lname" class="error-mess <?= isset($errors['lname'])?'':'hidden' ?>">Last name is invalid.</p>
                        </p>

                        <p class="input-field">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value= <?= $email ?>/>
                            <p id="error-email" class="error-mess <?= isset($errors['email'])?'':'hidden' ?>">Email must contain '@' and '.'.</p>
                        </p>

                        <p class="input-field">
                            <label for="uname">User Name</label>
                            <input type="text" id="uname" name="uname" value="<?= $username ?>" />
                            <p id="error-uname" class="error-mess <?= isset($errors['uname'])?'':'hidden' ?>">User name must not be empty and have space.</p>
                        </p>

                        <p class="input-field">
                            <label for="pass">Password</label>
                            <input type="password" id="pass" name="pass" value= "<?= $password ?>"/>
                            <p id="error-pass" class="error-mess <?= isset($errors['pass'])?'':'hidden' ?>">Password must have 8 characters.</p>
                        </p>

                        <p class="input-field">
                            <label for="repass">Confirmed password</label>
                            <input type="password" id="repass" name="repass"/>
                        </p>

                        <p class="input-field">
                            <label for="DofB">Date of Birth</label>
                            <input type="date" id="DofB" name="DofB" value= "<?= $dob ?>"/>
                            <p id="error-dofb" class="error-mess <?= isset($errors['DofB'])?'':'hidden' ?>">Date of birth is invalid.</p>
                        </p>

                        <p class="input-field">
                            <label for="avatar">Profile Image</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*"/>
                            <p id="error-avatar" class="error-mess <?= isset($errors['avatar'])?'':'hidden' ?>">Profile photo must be non-empty.</p>
                        </p>

                        <p class="input-field">
                            <input type="submit" class="form-submit" value="Sign up"/>
                        </p>
                    </form>       

                </section>
            </main>

            <main id="main-body-right">
                <aside>
                    <h2>GET HELP?</h2>
                    <form class="auth-form">
                        <p>UR Course</p>
                        <p>UR Service</p>
                        <p>UR Mail</p>
                        <p>UR Phone Number</p>
                        <p>Already have an account?
                            <a href="login.php">Log In</a>
                        </p>
                    </form>
                </aside>
            </main>

            <footer class="footer-auth">
                <p> CS 215 - ASSIGNMENT MANAGEMENT APPLICATION</p>
                <p><a href="https://validator.w3.org/check?uri=http%3A%2F%2Fwww.webdev.cs.uregina.ca%2F%7Enhp892%2FAssignment2%2Fsignup.html&amp;charset=%28detect+automatically%29&amp;doctype=XHTML+1.1&amp;group=0&amp;user-agent=W3C_Validator%2F1.3+">XHTML 1.1 Validation</a></p>
                <p>
                    <a href="http://jigsaw.w3.org/css-validator/check/referer">
                        <img class="validation" style="border:0;width:88px;height:31px"
                            src="http://jigsaw.w3.org/css-validator/images/vcss"
                            alt="Valid CSS!" />
                    </a>
                </p>
            </footer>
        </div>
        <script src="js/signupRegister.js"></script>
    </body>

</html>