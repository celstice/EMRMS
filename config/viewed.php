<?php
include 'connect.php';
session_start();

$user = $_SESSION['user']['userID'];

 if ($_POST['notifViewed']){
    $notifID = $_POST['notifViewed'];
    $notif = $connect->prepare("UPDATE notifications SET viewed=1 WHERE notif_id=?");
    $notif->bind_param("i", $notifID);
    $notif->execute();
}
?>