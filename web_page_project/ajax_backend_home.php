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
    $uid = $_SESSION["user_id"];
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $opts);

        $query = "SELECT a.asg_id, a.asgn, a.course, a.due_date, a.instructor, a.status, COUNT(f.comment) AS feedback_count FROM Assignment AS a LEFT JOIN Feedback AS f ON f.asg_id = a.asg_id WHERE a.user_id = '$uid' GROUP BY a.asg_id, a.asgn, a.course, a.due_date, a.instructor, a.status ORDER BY a.asg_id DESC;";
        $result = $db->query($query);

        $jsonArray = array();

        while ($row = $result->fetch()){
            $jsonArray[] = $row;
        }

        echo json_encode($jsonArray);
        $db = null;
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
?>
