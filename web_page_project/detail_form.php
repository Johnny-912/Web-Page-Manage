<?php
require_once("database.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

session_start();
if (!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
else {
    $uname = $_SESSION['username'];
    $uid = $_SESSION['user_id'];
}

$errors = array();
$user_id = "";
$asg_id = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dataOK = TRUE;

    $user_id = test_input($_POST["user_id"]);
    $asg_id = test_input($_POST["asg_id"]);

    $IDRegex = "/^[0-9]{1,}$/";

    if (!preg_match($IDRegex, $user_id)) {
        $errors["User ID"] = "User ID is not correct!";
        $dataOK = FALSE;
    }
    if (!preg_match($IDRegex, $asg_id)) {
        $errors["Assignment ID"] = "Please choose assignment ID in the list below!";
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

        $query = "SELECT user_id FROM Assignment WHERE user_id = '$user_id' AND asg_id = '$asg_id';";
        $result = $db->query($query);
        $match = $result->fetch();

        if (!$match) {
            $errors['Login Failed'] = "Sorry, the user ID or assignment ID is not correct!";
        }
        else {
            $_SESSION['username'] = $uname;
            $_SESSION['user_id'] = $user_id;
            $_SESSION['asg_id'] = $asg_id;
            
            $db = null;
            header("Location: detail_file.php");
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
        <title>Assignment Detail Form Page</title>
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
        <script src="js/eventHandler.js"></script>
    </header>

    <body>
        <div class="container">
            <header class="header"> 
                <img src="img/logo.jpg" alt="Logo of UOFR"/>   
                <h1>ASSIGNMENT DETAIL FORM PAGE</h1>
            </header>

            <main id="main-body-left">
                <section>
                    <h2>List Of All Assignments</h2>
                    <?php
                    try {
                        $db = new PDO($attr, $db_user, $db_pwd, $opts);
                    }
                    catch (PDOException $e){
                        throw new PDOExecption($e->getMessage(), (int)$e->getCode());
                    }
            
                    $query = "SELECT a.asg_id, a.user_id, a.course, a.asgn, a.due_date, a.instructor, a.status, COUNT(f.feedback_id) AS feedback_count FROM Feedback AS f RIGHT JOIN Assignment AS a ON a.asg_id = f.asg_id WHERE a.user_id = '$uid' GROUP BY a.asg_id, a.user_id ORDER BY a.due_date DESC;";
                    $result = $db->query($query);
                    $_SESSION['user_id'] = $uid;
                    while ($row = $result->fetch()){
                    ?>
                    <div>
                        <article>
                            <p><strong><?= $row['asgn'] ?></strong></p>
                            <p><?= $row['due_date'] ?></p>
                            <p><?= $row['instructor'] ?> || <?= $row['course'] ?></p>
                            <p>Total feedbacks: <?= $row['feedback_count'] ?></p>
                            <p>Assignment ID: <?= $row['asg_id'] ?></p>
                            <p class="status"><?= $row['status'] ?></p>

                        </article>
                    </div> 
                    <?php
                    }
                    ?>

                </section>
            </main>

            <main id="main-body-right">
                <aside>
                    <h2>SELECT ASSIGNMENT</h2>
                    <form action="" method="post" class="auth-form" id="login-form">  
                        <p class="input-field">
                            <label for="user_id">User ID</label>
                            <input type="text" id="user_id" name="user_id" value= "<?= $user_id ?>"/>
                            <p id="error-user-id" class="error-mess <?= isset($errors['User ID'])?'':'hidden' ?>">User ID is not correct. (Please check the ID in HOME PAGE)</p>
                        </p>
                
                        <p class="input-field"> 
                            <label for="asg-id">Assignment ID</label>
                            <input type="text" id="asg_id" name="asg_id" value= "<?= $asg_id ?>"/>
                            <p id="error-asg-id" class="error-mess <?= isset($errors['Assignment ID'])?'':'hidden' ?>">Assignment does not exist. (Please use the ID beside)</p>
                        </p>
                
                        <p class="input-field">
                            <input type="submit" class="form-submit" value="SEARCH"/>
                        </p>
                    </form>

                    <div>
                        <form class="page">
                            <p>
                                <a href="main.php">Home Page</a>
                            </p>
                        </form>
                    </div>

                    <div>
                        <form class="page">
                            <p>
                                <a href="logout.php">LOG OUT</a>
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