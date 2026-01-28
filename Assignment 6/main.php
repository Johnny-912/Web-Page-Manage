<?php
require_once("database.php");

session_start();

if (!isset($_SESSION['username'])){
    header("Location: login.php");
    exit;
}
else {
    $uid = $_SESSION['user_id'];
    $uname = $_SESSION['username'];
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    $email = $_SESSION['email'];
    $dob = $_SESSION['dofb'];
    $avatar_url = $_SESSION['avatar'];
}

try {
    $db = new PDO($attr, $db_user, $db_pwd, $opts);
}
catch (PDOException $e){
    throw new PDOExecption($e->getMessage(), (int)$e->getCode());
}

$query = "SELECT a.asg_id, a.user_id, a.course, a.asgn, a.due_date, a.instructor, a.status, COUNT(f.feedback_id) AS feedback_count FROM Feedback AS f RIGHT JOIN Assignment AS a ON a.asg_id = f.asg_id WHERE a.user_id = '$uid' GROUP BY a.asg_id, a.user_id ORDER BY a.asg_id DESC LIMIT 20;";
$result = $db->query($query);

?>

<!DOCTYPE html>

<html lang="en-US">
    <header>
        <meta charset="utf-8">
        <title>Main Page</title>
        <link rel="stylesheet" type="text/css" href="css/style2.css" />
        <script src="js/eventHandler.js"></script>
    </header>

    <body>
        <div class="container">
            <header class="header"> 
                <img src="img/logo.jpg" alt="Logo of UOFR" />   
                <h1>MAIN PAGE
                    <aside class="user-name"><?= $uname ?></aside>
                </h1>
            </header>

            <main id="main-body-left">
                <section>
                    <div>
                        <button>Filter</button>
                    </div>

                    <?php
                    $_SESSION['username'] = $uname;
                    $_SESSION['user_id'] = $uid;
                    while ($row = $result->fetch()){
                    ?>
                    <div id = "display_main">
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
                    ?> 
                </section>
            </main>

            <main id="main-body-right">
                <aside>
                    <div>
                        <form class="page">
                            <p>
                                <a href="manage_file.php">Assignment Management Page</a>
                            </p>
                        </form>
                    </div>

                    <div>
                        <form action="signup.php" method="post" class="auth-form">
                            <h2>Profile</h2>
                            <p>
                                <img class="image" src="<?= $avatar_url?>" alt="photo of user"/>
                                User name: <?= $uname ?>
                            </p>
                            <p>First name: <?= $fname ?></p>
                            <p>Last name: <?= $lname ?></p>
                            <p>Email: <?= $email ?></p>
                            <p>Date of birth: <?= $dob ?></p>
                            <p>User ID: <?= $uid ?></p>
                            <p class="edit">
                                <input type="submit" value="Edit"/>
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
                <p><a href="https://validator.w3.org/check?uri=http%3A%2F%2Fwww.webdev.cs.uregina.ca%2F%7Enhp892%2FAssignment2%2Fmain.html&amp;charset=%28detect+automatically%29&amp;doctype=XHTML+1.1&amp;group=0&amp;user-agent=W3C_Validator%2F1.3+">XHTML 1.1 Validation</a></p>
                <p>
                    <a href="http://jigsaw.w3.org/css-validator/check/referer">
                        <img class="validation" style="border:0;width:88px;height:31px"
                            src="http://jigsaw.w3.org/css-validator/images/vcss"
                            alt="Valid CSS!" />
                    </a>
                </p>
            </footer>
        </div>
        <script src="js/main2.js"></script>
    </body>

</html>