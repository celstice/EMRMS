<?php
include 'config/connect.php';
session_start();

$user = $_SESSION['user']['userID'];
$result = mysqli_query($connect, "SELECT * FROM users WHERE userID = '$user'");
$row = mysqli_fetch_array($result);
$text = ucfirst($row['role']) . ' logout.';
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");
mysqli_query($connect, "INSERT INTO system_logs (userID,action_type,timestamp)VALUES('$user','$text',CURRENT_TIMESTAMP)");
session_unset();
session_destroy();
header('location:index.php');

?>