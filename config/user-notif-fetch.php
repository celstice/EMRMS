<?php
include "../config/connect.php";
include "../config/notif-link.php";

session_start();
$user = $_SESSION['user']['userID'];

$data = array();
$sql = mysqli_query($connect, "SELECT * FROM notifications WHERE userID='$user' ORDER BY timestamp DESC");

if (mysqli_num_rows($sql) > 0) {
    while ($notif = mysqli_fetch_assoc($sql)) {
        $notifID = $notif['notif_id'];
        $type = $notif['notif_type'];
        $typeID = $notif['notif_typeID'];
        $message = $notif['message'];
        $timestamp = strtotime($notif['timestamp']);
        $date = date("F d, Y", $timestamp);
        $time = date("h.i A", $timestamp);
        $viewed = $notif['viewed'];

        $data[] = array(
            'notifID' => $notifID,
            'type' => $type,
            'typeID' => $typeID,
            'message' => $message,
            'date' => $date,
            'time' => $time,
            'timestamp'=>$timestamp,
            'viewed' => $viewed,
            'link' => '',
        );
    }
}

// Output data as JSON
echo json_encode($data);
?>