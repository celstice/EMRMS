<?php
include "../config/connect.php";

session_start();
$user = $_SESSION['user']['userID'];

$count = array();

$countNotif = mysqli_query($connect, "SELECT COUNT(*) as notif_count FROM notifications WHERE userID='$user' AND viewed=0");
$notif = mysqli_fetch_assoc($countNotif);

$count = $notif['notif_count'];
echo json_encode($count);
?>