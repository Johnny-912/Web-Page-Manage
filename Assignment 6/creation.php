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
    exit;
}
else {
    $uname = $_SESSION['username'];
    $uid = $_SESSION['user_id'];
}

$errors = array();
$asgn = "";
$course = "";
$due_date = "";
$instructor = "";
$status = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $valid = TRUE;
    $asgn = test_input($_POST["asgn"]);
    $course = test_input($_POST["course"]);
    $due_date = test_input($_POST["due"]);
    $status = test_input($_POST["status"]);
    $instructor = test_input($_POST["instructor"]);

    $nameRegex = "/^.{2,50}$/";
    $statusRegex = "/^[A-Z]{1,2}$/";
    $dueRegex = "/^\d{4}[-]\d{2}[-]\d{2}$/";

    if (!preg_match($nameRegex, $asgn)) {
        $errors["asgn"] = "Invalid Assignment Name";
        $valid = FALSE;
    }
    if (!preg_match($nameRegex, $course)) {
        $errors["course"] = "Invalid Course Name";
        $valid = FALSE;
    }
    if (!preg_match($statusRegex, $status)) {
        $errors["status"] = "Invalid Status";
        $valid = FALSE;
    }
    if (!preg_match($nameRegex, $instructor)) {
        $errors["instructor"] = "Invalid Instructor Name";
        $valid = FALSE;
    }
    if (!preg_match($dueRegex, $due_date)) {
        $errors["due_date"] = "Invalid Due Date";
        $valid = FALSE;
    }

    try {
        $db = new PDO($attr, $db_user, $db_pwd, $opts);
    }
    catch (PDOException $e) {
        throw new PDOExecption($e->getMessage(), (int)$e->getCode());
    }

    $query = "SELECT user_id FROM Assignment WHERE asgn = '$asgn' AND user_id = '$uid';";
    $result = $db->query($query);
    $match = $result->fetch();

    if ($match){
        $errors['Existed'] = "This assignment is already existed!";
    }
    else {
        $query = "INSERT INTO Assignment (user_id, course, asgn, due_date, instructor, status) VALUES ('$uid', '$course', '$asgn', '$due_date 23:59:00', '$instructor', '$status');";
        $result = $db->query($query);
        $asg_id = $db->lastInsertID();

        if(!$result) {
            $errors['Insertion Failed'] = "Sorry, there was an error inserting the Assignment!";
        }
        else {
            if (!$valid) {
                $query = "DELETE FROM Assignment WHERE asg_id = '$asg_id';";
                $result = $db->exec($query);
                if (!$result){
                    $errors['Deletion Failed'] = "There was an error deleting information!";
                }
                $db = null;
            }
            else {
                $_SESSION['username'] = $uname;
                $_SESSION['user_id'] = $uid;
                $db = null;
                header("Location: main.php");
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
        <title>Assignment Creation Page</title>
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
        <script src="js/eventHandler.js"></script>
    </header>

    <body>
        <div class="container">
            <header class="header"> 
               <img src="img/logo.jpg" alt="Logo of UOFR" />   
                <h1>ASSIGNMENT CREATION PAGE
                    <aside class="user-name"><?= $uname ?></aside>
                </h1>
            </header>

            <main id="main-body-left">
                <section>
                    <form class="form-fill" id="creation-form" action="" method="post">
                        <h2>Assignment Creation Form</h2>

                        <p class="input-field">
                            <label for="asgn">Assignment</label>
                            <input type="text" id="asgn" name="asgn" value="<?= $asgn ?>"/>
                            <p id="error-asgn" class="error-mess <?= isset($errors['asgn'])?'':'hidden' ?>">Assignment is invalid. (e.g. Assignment 1)</p>
                        </p>

                        <p class="input-field">
                            <label for="course">Course</label>
                            <input type="text" id="course" name="course" value="<?= $course ?>"/>
                            <p id="error-course" class="error-mess <?= isset($errors['course'])?'':'hidden' ?>">Course name is invalid. (e.g. CS215 - Web and Database Programming)</p>
                        </p>

                        <p class="input-field">
                            <label for="instructor">Instructor</label>
                            <input type="text" id="instructor" name="instructor" value="<?= $instructor ?>"/>
                            <p id="error-instructor" class="error-mess <?= isset($errors['instructor'])?'':'hidden' ?>">Instructor name is invalid.</p>
                        </p>

                        <p class="input-field">
                            <label for="due">Due date</label>
                            <input type="date" id="due" name="due" value="<?= $due_date ?>"/>
                            <p id="error-due" class="error-mess <?= isset($errors['due_date'])?'':'hidden' ?>">Due date is invalid.</p>
                        </p>

                        <p class="input-field">
                            <label for="status">Status (S: Submitted or NS: Not Submitted)</label>
                            <input type="text" id="status" name="status" value="<?= $status ?>"/>
                            <p id="error-status" class="error-mess <?= isset($errors['status'])?'':'hidden' ?>">Status must be written such as NS (for Not Submitted) or S (for Submitted).</p>
                        </p>

                        <p class="input-field">
                            <input type="submit" class="form-submit" value="Submit"/>
                        </p>
                    </form>

                    <form class="form-fill" id="feedback-creation-form" action="">
                        <p class="feedback-box">
                            <label for="feedback">Comment:</label>
                            <input type="text" id="feedback" name="feedback"/>
                        </p>
                        <p id="limit" class="feedback-exceed"><br>0/1500<br>
                            Remaining Characters:1500
                        </p>
                        <p id="error-feedback" class="error-mess hidden">Feedback must contain less than 1500 characters and not be empty.</p>
                        <p class="input-field">
                            <input type="reset" class="form-submit" value="Clear"/>
                            <input type="submit" class="form-submit" value="Submit"/>
                        </p>
                    </form>

                </section>
            </main>

            <main id="main-body-right">
                <aside>
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
                                <a href="manage_file.php">Assignment Management Page</a>
                            </p>
                        </form>
                    </div>

                    <div>
                        <form class="page">
                            <p>
                                <a href="detail_form.php">Assignment Detail Page</a>
                            </p>
                        </form>
                    </div>

                    <div>
                        <form class="auth-form">
                            <h2>Assignments</h2>
                            <?php
                            try {
                                $db = new PDO($attr, $db_user, $db_pwd, $opts);
                            }
                            catch (PDOException $e) {
                                throw new PDOExecption($e->getMessage(), (int)$e->getCode());
                            }
                            $query = "SELECT asg_id, asgn, course FROM Assignment WHERE user_id = '$uid' ORDER BY due_date DESC;";
                            $result = $db->query($query);
                            while ($row = $result->fetch()){
                            ?>
                            <p><a href="detail_form.php"><?= $row['asgn']?> (<?= $row['course']?>)</p>
                            <?php }
                            $db = null;
                            ?>
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
                <p><a href="https://validator.w3.org/check?uri=http%3A%2F%2Fwww.webdev.cs.uregina.ca%2F%7Enhp892%2FAssignment2%2Fcreation.html&amp;charset=%28detect+automatically%29&amp;doctype=XHTML+1.1&amp;group=0&amp;user-agent=W3C_Validator%2F1.3+">XHTML 1.1 Validation</a></p>
                <p>
                    <a href="http://jigsaw.w3.org/css-validator/check/referer">
                        <img class="validation" style="border:0;width:88px;height:31px"
                            src="http://jigsaw.w3.org/css-validator/images/vcss"
                            alt="Valid CSS!" />
                    </a>
                </p>
            </footer>
        </div>
        <script src="js/creationRegister.js"></script>
    </body>

</html>

<?php
?>