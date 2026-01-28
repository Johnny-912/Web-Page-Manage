<?php
require_once("database.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = array();
$username = "";
$password = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dataOK = TRUE;

    $username = test_input($_POST["uname"]);
    $password = test_input($_POST["pass"]);

    $unameRegex = "/^[a-zA-Z0-9_]+$/";
    $passwordRegex = "/^.{8}$/";

    if (!preg_match($unameRegex, $username)) {
        $errors["Username"] = "Invalid Username";
        $dataOK = FALSE;
    }
    if (!preg_match($passwordRegex, $password)) {
        $errors["Password"] = "Invalid Password";
        $dataOK = FALSE;
    }
    
    if (!$dataOK) {
        $errors['Login Failed'] = "PLEASE FOLLOW THE INSTRUCTION TO FILL OUT THE FIELDS!";
    }
    else {
        try {
            $db = new PDO($attr, $db_user, $db_pwd, $opts);
        }
        catch (PDOException $e){
            throw new PDOExecption($e->getMessage(), (int)$e->getCode());
        }

        $query = "SELECT user_id, username, first_name, last_name, email, date_of_birth, avatar_url FROM User WHERE username = '$username' AND password = '$password';";
        $result = $db->query($query);

        if (!$result) {
            $errors['Retrival'] = "Sorry, there was an error retrieving your information!";
        }
        else if ($row = $result->fetch()) {
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['fname'] = $row['first_name'];
            $_SESSION['lname'] = $row['last_name'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['dofb'] = $row['date_of_birth'];
            $_SESSION['avatar'] = $row['avatar_url'];
            
            $db = null;
            header("Location: main.php");
        }
        else {
            $errors['Login Failed'] = "Sorry, the username or password is not correct!";
        }

        $db = null;
    }

    if (!empty($errors)){
        foreach($errors as $type => $message) {
            echo "$type: $message <br />\n";
        }
    }
}

?>

<!DOCTYPE html>

<html lang="en-US">
    <header>
        <meta charset="utf-8">
        <title>Log In Page</title>
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
        <script src="js/eventHandler.js"></script>
    </header>

    <body>
        <div class="container">
            <header class="header"> 
                <img src="img/logo.jpg" alt="Logo of UOFR"/>   
                <h1>LOG IN PAGE</h1>
            </header>

            <main id="main-body-left">
                <section>
                <?php
                try {
                    $db = new PDO($attr, $db_user, $db_pwd, $opts);
                }
                catch (PDOException $e){
                    throw new PDOExecption($e->getMessage(), (int)$e->getCode());
                }
                $query = "SELECT a.asg_id, a.user_id, a.course, a.asgn, a.due_date, a.instructor, a.status, COUNT(f.feedback_id) AS feedback_count FROM Feedback AS f RIGHT JOIN Assignment AS a ON a.asg_id = f.asg_id GROUP BY a.asg_id, a.user_id ORDER BY a.asg_id DESC LIMIT 5;";
                $result = $db->query($query);
                while ($row = $result->fetch()){
                    ?>
                    <div id = "display_login">
                        <article>
                            <p>
                                <strong><?= $row['asgn'] ?></strong>
                                <button class="status">
                                    <a href="detail_form.php">View</a>
                                </button>
                            </p>
                            <p><?= $row['due_date'] ?></p>
                            <p><?= $row['instructor'] ?> || <?= $row['course'] ?></p>
                            <p>Total feedbacks: <?= $row['feedback_count'] ?></p>
                            <p>Assignment ID: <?= $row['asg_id'] ?></p>
                            <p class="status"><?= $row['status'] ?></p>

                        </article>
                    </div> 
                    <?php
                    }
                    $db = null;
                    ?> 
                </section>
            </main>

            <main id="main-body-right">
                <aside>
                    <h2>Login</h2>
                    <form action="" method="post" class="auth-form" id="login-form">  
                        <p class="input-field">
                            <label for="uname">Username</label>
                            <input type="text" id="uname" name="uname" value= "<?= $username ?>"/>
                            <p id="error-uname" class="error-mess <?= isset($errors['Username'])?'':'hidden' ?>">Username is invalid.</p>
                        </p>
                
                        <p class="input-field"> 
                            <label for="pass">Password</label>
                            <input type="password" id="pass" name="pass" value= "<?= $password ?>"/>
                            <p id="error-pass" class="error-mess <?= isset($errors['Password'])?'':'hidden' ?>">Password must contain 8 characters and no-space.</p>
                        </p>
                
                        <p class="input-field">
                            <input type="submit" class="form-submit" value="Log in"/>
                        </p>
                    </form>
                
                    <div>
                        <p class="sign-up-mess">Don't have an account?
                            <a href="signup.php">Sign up</a>
                        </p>
                    </div>

                    <div>
                        <form class="page" action="">
                            <p>
                                <a href="manage.php">Assignment Management Page</a>
                            </p>
                        </form>
                    </div>

                    <div>
                        <form class="page" action="">
                            <p>
                                <a href="creation.php">Assignment Creation Page</a>
                            </p>
                        </form>
                    </div>
            
                </aside>
            </main>

            <footer class="footer-auth">
                <p> CS 215 - ASSIGNMENT MANAGEMENT APPLICATION</p>
                <p><a href="https://validator.w3.org/check?uri=http%3A%2F%2Fwww.webdev.cs.uregina.ca%2F%7Enhp892%2FAssignment2%2Flogin.html&amp;charset=%28detect+automatically%29&amp;doctype=XHTML+1.1&amp;group=0&amp;user-agent=W3C_Validator%2F1.3+">XHTML 1.1 Validation</a></p>
                <p>
                    <a href="http://jigsaw.w3.org/css-validator/check/referer">
                        <img class="validation" style="border:0;width:88px;height:31px"
                            src="http://jigsaw.w3.org/css-validator/images/vcss"
                            alt="Valid CSS!" />
                    </a>
                </p>
            </footer>
        </div>
    <script src="js/loginRegister.js"></script>
    </body>

</html>