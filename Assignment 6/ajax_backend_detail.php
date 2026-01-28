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
    $uid = $_SESSION['user_id'];
    $asg_id = $_SESSION['asg_id'];
    try {
        $db = new PDO($attr, $db_user, $db_pwd, $opts);
        $query = "SELECT feedback_id, comment, time_stamp FROM Feedback WHERE asg_id = '$asg_id' AND user_id = '$uid' ORDER BY feedback_id DESC;";
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