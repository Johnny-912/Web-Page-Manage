<?php
require_once("database.php");

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
else {
    $uid = $_SESSION['user_id'];
    $asg_id = $_SESSION['asg_id'];
    $uname = $_SESSION['username'];
}

$errors = array();
$feedback = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $feedback = test_input($_POST['feedback']);
    $fbRegex = "/^.{0,1500}$/";
    $dataOK = TRUE;

    if (!preg_match($fbRegex, $feedback)) {
        $errors["Feedback"] = "Invalid Feedback!";
        $dataOK = FALSE;
    }

    if (!$dataOK){
        $errors['Retrival'] = "There was an error storing feedback!";
    }
    else {
        try {
            $db = new PDO($attr, $db_user, $db_pwd, $opts);
        }
        catch (PDOExecption $e) {
            throw new PDOExecption($e->getMessage(), (int)$e->getCode());
        }

        $query = "INSERT INTO Feedback (user_id, asg_id, comment, time_stamp) VALUES ('$uid', '$asg_id', '$feedback', NOW());";
        $result = $db->exec($query);
        if (!$result) {
            $errors['Insertion'] = "There was an error inserting the feedback!";
            $fb_id = $db->lastInsertID();
            $query = "DELETE FROM Feedback WHERE feedback_id = '$fb_id';";
            $result = $db->exec($query);
            if (!$result){
                $errors['Deletion'] = "There was an error deleting the feedback";
            }
        }
        else {
            $_SESSION['username'] = $uname;
            $_SESSION['user_id'] = $uid;
            $db = null;
            header("Location: detail.php");
        }
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
        <title>Assignment Detail Page</title>
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
        <script src="js/eventHandler.js"></script>
    </header>

    <body>
        <div class="container">
            <header class="header"> 
                <img src="img/logo.jpg" alt="Logo of UOFR" />   
                <h1>ASSIGNMENT DETAIL PAGE
                    <aside class="user-name"><?= $uname ?></aside>
                </h1>
            </header>

        <main id="main-body-left">
            <section>
                <?php
                    try {
                        $db = new PDO($attr, $db_user, $db_pwd, $opts);
                    }
                    catch (PDOExecption $e) {
                        throw new PDOExecption($e->getMessage(), (int)$e->getCode());
                    }
                    
                    $query = "SELECT asgn, course, due_date, status, instructor FROM Assignment WHERE asg_id = '$asg_id' AND user_id = '$uid';";
                    $result = $db->query($query);
                    $row = $result->fetch();
                ?>
                <article>
                    <h2><?= $row['asgn'] ?></h2>
                    <p class="course"><?= $row['instructor'] ?> || <?= $row['course'] ?></p>
                </article>

                <form action="" method="post" class="form-fill" id="creation">
                    <p class="input-field">
                        <label for="asg-id">Assginment ID</label>
                        <input type="submit" value="<?= $asg_id ?>"/>
                    </p>

                    <p class="input-field">
                        <label for="due">Due date</label>
                        <input type="submit" value="<?= $row['due_date'] ?>"/>
                    </p>

                    <p class="input-field">
                        <label for="status">Status</label>
                        <input type="submit" value="<?= $row['status'] ?>"/>
                    </p>
                </form>
                
                <form class="form-fill" id="feedback-detail-form" method="post" action="">
                    <p class="feedback-box">
                        <label for="feedback">Comment:</label>
                        <input type="text" id="feedback" name="feedback"/>
                    </p>
                    <p id="limit" class="feedback-exceed feedback-box">0/1500<br />
                        Remaining Characters:1500
                    </p>
                    <p id="error-feedback" class="error-mess hidden">Feedback must contain less than 1500 characters and not be empty.</p>
                    <p class="input-field">
                        <input type="reset" class="form-submit" value="Clear"/>
                        <input type="submit" class="form-submit" value="Submit"/>
                    </p>

                    <p>Previous comment: </p>
                    <?php
                    try {
                        $db = new PDO($attr, $db_user, $db_pwd, $opts);
                    }
                    catch (PDOExecption $e) {
                        throw new PDOExecption($e->getMessage(), (int)$e->getCode());
                    }
                    
                    $query = "SELECT comment, time_stamp FROM Feedback WHERE asg_id = '$asg_id' AND user_id = '$uid';";
                    $result = $db->query($query);
                    while ($row = $result->fetch()){
                ?>
                    <p id="feedback_box">- <?= $row['time_stamp'] ?>: <?= $row['comment'] ?></p>
                    <?php
                    }
                    ?>
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
                            <a href="creation_file.php">Assignment Creation Page</a>
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
            <p><a href="https://validator.w3.org/check?uri=http%3A%2F%2Fwww.webdev.cs.uregina.ca%2F%7Enhp892%2FAssignment2%2Fdetail.html&amp;charset=%28detect+automatically%29&amp;doctype=XHTML+1.1&amp;group=0&amp;user-agent=W3C_Validator%2F1.3+">XHTML 1.1 Validation</a></p>
            <p>
                <a href="http://jigsaw.w3.org/css-validator/check/referer">
                    <img class="validation" style="border:0;width:88px;height:31px"
                        src="http://jigsaw.w3.org/css-validator/images/vcss"
                        alt="Valid CSS!" />
                </a>
            </p>
        </footer>    
    </div>
    <script src="js/detailRegister.js"></script>
    </body>

</html>