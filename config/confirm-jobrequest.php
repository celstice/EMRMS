<?php
// ADMIN: confirm user request 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "../vendor/phpmailer/phpmailer/src/Exception.php";
require "../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "../vendor/phpmailer/phpmailer/src/SMTP.php";

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->SMTPAuth = true;
$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = "tls";
$mail->Port = '587';
$mail->Username = "caps.190867@gmail.com";
$mail->Password = "rvwcmxpdegvzzcad";
$mail->isHTML(true);

include 'connect.php';
// session_start();

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

$user = $_SESSION['user']['userID'];

$errors = [];

if (isset($_POST['confirm'])) {
    mysqli_query($connect, "SET time_zone = '+08:00'");

    $job_id =  $_POST['job-id'];
    $job_number =  $_POST['job-number'];
    $supplies_materials =  $_POST['supplies-materials'];
    $causes =  $_POST['causes'];
    $assigned_personnel =  $_POST['assigned-personnel'];
    $feedback_number =  $_POST['feedback-number'];

    $getReq = $connect->prepare("SELECT * FROM job_request WHERE job_id=?");
    $getReq->bind_param("i", $job_id);
    $getReq->execute();
    $req = $getReq->get_result();
    $fetch = $req->fetch_assoc();

    $account = $fetch['userID'];
    $job_service = $fetch['job_service'];
    $requesting_official = $fetch['requesting_official'];
    $location = $fetch['job_location'];
    $date_requested = $fetch['date_requested'];

    $getUser = $connect->prepare("SELECT * FROM users WHERE userID=?");
    $getUser->bind_param("i", $account);
    $getUser->execute();
    $userinfo = $getUser->get_result();
    $get = $userinfo->fetch_assoc();
    $name = $get['firstname'] . " " . $get['lastname'];
    $email = $get['email'];
    $username = $get['username'];

    try {
        mysqli_begin_transaction($connect);
        $sql = "UPDATE job_request SET
        job_control_number = ?,	
        supplies_materials = ?,
        causes = ?,	
        assigned_personnel = ?,
        feedback_number = ?,
        confirmed=1
        WHERE job_id = ?";

        $confirm = $connect->prepare($sql);
        $confirm->bind_param("sssssi", $job_number,$supplies_materials,$causes,$assigned_personnel,$feedback_number,$job_id);
        $confirm->execute();

        if (!$confirm->errno) {
            mysqli_commit($connect);

            $mail->Subject = "Job Request";
            $mail->Body = '
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
                                <h2 style="text-align: center;">Job Request Confirmed</h2>
                                <p>Good day, ' . $name . ',</p>
                                <p>Your job request is confirmed.</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Kindly wait for the ERMS Personnel(s).</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p>Thank you.</p>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </body>
            </html>
            ';

            $mail->setFrom("caps19.0867@gmail.com", "CLSU-ERMS");
            $mail->addAddress($email);
            $mail->send();

            // notif
            $notiftext = 'Your request is confirmed.';
            $notif = $connect->prepare("INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(?,'Job Request',?,?,'user',CURRENT_TIMESTAMP)");
            $notif->bind_param("iis", $account,$job_id,$notiftext);
            $notif->execute();

            // log
            $logtext = 'Confirm job request.';
            $log = $connect->prepare("INSERT INTO system_logs (userID,action_type,timestamp)VALUES(?,?,CURRENT_TIMESTAMP)");
            $log->bind_param("is", $user, $logtext);
            $log->execute();

        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $confirm->error . '</p>
                        </div>';
            echo '</div>';
        }

    } catch (Exception $e) {
        mysqli_rollback($connect);
        echo '<div class="d-flex justify-content-center w-100 m-0">';
        echo '<div class="position-fixed text-danger bg-dark h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5" style="z-index:1000 !important;">';
        echo '<div class="m-3">
                <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
        </div>';
        echo '<div class="m-3">
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="goBack()">Go back to previous page.</button>
            </div>';
        echo '</div>';
        echo '</div>';
        echo '<script> function goBack() { window.history.back(); } </script>';
    }

}

