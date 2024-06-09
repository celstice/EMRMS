<?php
// FOR CRON / TASK #1
// Send email notfi for equipment maintenance schedule

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

function send_email($user_id,$equipment){
$mail = new PHPMailer(true);
$alert = '';

$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = "tls";
$mail->Port = '587';

$mail->Username = "caps.190867@gmail.com";
$mail->Password = "rvwcmxpdegvzzcad";
$mail->isHTML(true);

    $server = "localhost";
    $user = "root";
    $password = "";
    $db = "emrms_db";

    $connect = mysqli_connect($server, $user, $password, $db);
    date_default_timezone_set('Asia/Manila');
    mysqli_query($connect, "SET time_zone = '+08:00'");

    $message =
    '<!DOCTYPE html>
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
                                <h2 style="text-align: center;">Maintenance Notice</h2>
                                <p>Maintenance of ' . $equipment . ' is scheduled for today.</p>
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
        $mail->Subject = "Maintenance Schedule Reminder";
        $mail->Body = $message;
        $mail->setFrom("caps19.0867@gmail.com", "CLSU-ERMS");
        $mail->Subject = "Maintenance Schedule Reminder";
        $mail->Body = $message;

            $mail->clearAllRecipients();
            $mail->addAddress($emails);
            $mail->send();
        }
        catch (Exception $e) {
        echo "Error.".$e->getMessage();
        }

    }
}

date_default_timezone_set('Asia/Manila');
$currentDate = date('Y-m-d');

// task #1

$getScheds = mysqli_query($connect,"SELECT * FROM maintenance_records WHERE DATE(next_mnt) ='$currentDate'");
while ($scheds = mysqli_fetch_assoc($getScheds)){
    $maintenance = $scheds['next_mnt'];

    if ($maintenance === $currentDate) {
        $userID = $scheds['userID'];
        $equip_id = $scheds['equipment_id'];
        
        $getEQ = mysqli_query($connect,"SELECT * FROM equipments WHERE equipment_id = '$equip_id'");
        $eq = mysqli_fetch_assoc($getEQ);
        $equipment = $eq['equip_name'];

        send_email($userID,$equipment);
        
        $text = 'Scheduled maintenance of an equipment.';
        mysqli_query($connect, "SET time_zone = '+08:00'");
        mysqli_query($connect, "INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES('$userID','Maintenance','$equip_id','$text','user',CURRENT_TIMESTAMP)");

    } else {
        echo "Error. ". mysqli_error($connect);
    }

}
?>