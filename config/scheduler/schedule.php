<?php
// FOR CRON / TASK #2
// Send email notif for schedule of cleaning/repair

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "../../vendor/phpmailer/phpmailer/src/Exception.php";
require "../../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "../../vendor/phpmailer/phpmailer/src/SMTP.php";

$server = "localhost";
$user = "root";
$password = "";
$db = "emrms_db";

$connect = mysqli_connect($server, $user, $password, $db);
if (!$connect) {
    die('Database connection failed: ' . mysqli_connect_error());
}

function send_email($user_id,$sched){

$mail = new PHPMailer(true);
$alert = '';

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = "tls";
$mail->Port = '587';

$mail->Username = "caps.190867@gmail.com";
$mail->Password = "rvwcmxpdegvzzcad";;
$mail->isHTML(true);

    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "emrms_db";

    $connect = mysqli_connect($server, $user, $password, $db);
    date_default_timezone_set('Asia/Manila');
    mysqli_query($connect, "SET time_zone = '+08:00'");

    $getName = mysqli_query($connect,"SELECT firstname,lastname FROM users WHERE userID='$user_id'");
    $n = mysqli_fetch_assoc($getName);
    $fn = $n['firstname'];
    $ln = $n['lastname'];
    $name = $fn." ".$ln;
    
    $message =
    '
    <!DOCTYPE html>
                <html>
                <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1">
                <style>
                    @media screen and (max-width: 600px) {
                        p {font-size: 35px !important;}
                        h2 {font-size:45px !important;}
                        h4 {font-size: 35px !important;}
                    }
                </style>
                </head>
                <body>
                    <div style="width: 700px; height: auto; padding: 10px;">
                        <table style="padding: 10px;">
                            <tr>
                                <td>
                                    <h2 style="text-align: center;">Schedule Reminder</h2>
                                    <p>Good day '.$name. ',</p>
                                    <p>You requested a preventive maintenance schedule on ' . date("F j, Y",strtotime($sched)) . '. If the schedule is not available, kindly log in to the system and <span style="font-weight:500 !important;">Reschedule</span>.</p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>If there are no changes in the schedule, just ignore this message.</p>
                                    <br>
                                    <p>Thank you.</p>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </body>
                </html>
    ';
        
    $select_users = mysqli_query($connect, "SELECT * FROM users WHERE userID = '$user_id'");

    while ($users = mysqli_fetch_assoc($select_users)) {
    $emails = $users['email'];

        try {
        $mail->Subject = "Preventive Maintenance Schedule Reminder";
        $mail->Body = $message;
        $mail->setFrom("caps19.0867@gmail.com", "CLSU-ERMS");
        $mail->Subject = "Preventive Maintenance Schedule Reminder";
        $mail->Body = $message;

            $mail->clearAllRecipients();
            $mail->addAddress($emails);
            $mail->send();
        }
        catch (Exception $e) {
        $alert = "<script>alert('Error sending email.');</script>";
        }
    }
}

date_default_timezone_set('Asia/Manila');
$currentDate = date('Y-m-d');

// task #2

$select = mysqli_query($connect,"SELECT * FROM sched_records WHERE done=0");
while($record = mysqli_fetch_assoc($select)){
    $sched=$record['sched_render'];
    $notifySched5 = date('Y-m-d', strtotime('-5 days', strtotime($sched)));
    $notifySched4 = date('Y-m-d', strtotime('-4 days', strtotime($sched)));
    $notifySched3 = date('Y-m-d', strtotime('-3 days', strtotime($sched)));
    $notifySched2 = date('Y-m-d', strtotime('-2 days', strtotime($sched)));
    $notifySched1 = date('Y-m-d', strtotime('-1 days', strtotime($sched)));
    $notifySched = date('Y-m-d', strtotime($sched));

    $user_id=$record['userID'];
    $sched_id = $record['sched_id'];
    
    if ($notifySched5 === $currentDate){
        send_email($user_id,$sched);

        // notif 5 days before
        $text = "Preventive Maintenance Schedule";
        mysqli_query($connect,"SET time_zone = '+08:00'");
        mysqli_query($connect, "INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES('$user_id','Preventive Maintenance Schedule','$sched_id','$text','user',CURRENT_TIMESTAMP)");
    
    } else if ($notifySched4 === $currentDate){
        // notif 4 days before
        send_email($user_id, $sched);

        $text = "Preventive Maintenance Schedule";
        mysqli_query($connect, "SET time_zone = '+08:00'");
        mysqli_query($connect, "INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES('$user_id','Preventive Maintenance Schedule','$sched_id','$text','user',CURRENT_TIMESTAMP)");
    
    } else if ($notifySched3 === $currentDate) {
        send_email($user_id, $sched);

        // notif 3 days before
        $text = "Preventive Maintenance Schedule";
        mysqli_query($connect, "SET time_zone = '+08:00'");
        mysqli_query($connect, "INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES('$user_id','Preventive Maintenance Schedule','$sched_id','$text','user',CURRENT_TIMESTAMP)");
    } else if ($notifySched2 === $currentDate) {
        send_email($user_id, $sched);

        // notif 2 days before
        $text = "Preventive Maintenance Schedule";
        mysqli_query($connect, "SET time_zone = '+08:00'");
        mysqli_query($connect, "INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES('$user_id','Preventive Maintenance Schedule','$sched_id','$text','user',CURRENT_TIMESTAMP)");
    } else if ($notifySched1 === $currentDate) {
        send_email($user_id, $sched);

        // notif 1 day before
        $text = "Preventive Maintenance Schedule";
        mysqli_query($connect, "SET time_zone = '+08:00'");
        mysqli_query($connect, "INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES('$user_id','Preventive Maintenance Schedule','$sched_id','$text','user',CURRENT_TIMESTAMP)");
    }else if ($notifySched === $currentDate) {
        send_email($user_id, $sched);

        // notif on the sched date
        $text = "Preventive Maintenance Schedule";
        mysqli_query($connect, "SET time_zone = '+08:00'");
        mysqli_query($connect, "INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES('$user_id','Preventive Maintenance Schedule','$sched_id','$text','user',CURRENT_TIMESTAMP)");

    } else {
        echo "Error. " . mysqli_error($connect);
        echo $notifySched;
    }
}
?>