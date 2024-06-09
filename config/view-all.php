<?php
include 'connect.php';
session_start();

$user = $_SESSION['user']['userID'];

 if ($_POST['read-all']) {

    $notif = $connect->prepare("UPDATE notifications SET viewed=1 WHERE userID=? AND viewed=0");
    $notif->bind_param("i",$user);
    $notif->execute();
}
