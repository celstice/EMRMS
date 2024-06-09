<?php
// include 'connect.php';
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

function notifLink($type, $typeID,$connect)
{
    include 'connect.php';
    $user = $_SESSION['user']['userID'];
    
    if ($type === "User Job Request") {
        echo "admin-jobrequest.php";
    } else if ($type === "User Feedback") {
        echo "admin-feedbacks.php";
    } else if ($type === "Job Request") {
        echo "user-jobrequest.php";
    } else if ($type === "Maintenance") {
        echo "equipment-record.php?id=" . $typeID;
    } else if ($type === "Schedule Request") {
        echo "user-jobrequest.php";
    } else if ($type === "Preventive Maintenance") {
        echo "user-notice.php";
    } else if ($type === "User Schedule Request" || $type === "Reschedule") {
        echo "admin-notice.php";
    } 

}
?>