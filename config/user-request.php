<?php

//USER: add new request

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "../vendor/phpmailer/phpmailer/src/Exception.php";
require "../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "../vendor/phpmailer/phpmailer/src/SMTP.php";

$mail = new PHPMailer(true);
$alert = '';

// $mail->AddEmbeddedImage("img/xs-black.png", "logo");
$mail->isSMTP();
$mail->SMTPAuth = true;

$mail->Host = "smtp.gmail.com";
$mail->SMTPSecure = "tls";
$mail->Port = '587';

$mail->Username = "caps.190867@gmail.com";
$mail->Password = "rvwcmxpdegvzzcad";
$mail->isHTML(true);

include 'connect.php';

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

if (isset($_POST['user-request'])) {
    $job_service = $_POST['job-service'];
    $requesting_official = $_POST['requesting-official'];
    $location = $_POST['job-location'];
    $date_requested = $_POST['date-requested'];

    $getMail = $connect->prepare("SELECT * FROM users WHERE userID = ?");
    $getMail->bind_param("i", $user);
    $getMail->execute();
    $result = $getMail->get_result();
    $account = $result->fetch_assoc();

    $username = $account['username'];
    $name = $account['firstname']." ".$account['lastname'];
    $email = $account['email'];

    try {        
        mysqli_begin_transaction($connect);
        $insert = "INSERT INTO job_request(userID,job_service,requesting_official,job_location,date_requested) VALUES (?,?,?,?,?)";
        
        $request=$connect->prepare($insert);
        $request->bind_param("issss", $user, $job_service, $requesting_official, $location, $date_requested);
        $request->execute();
        
        $request_id = mysqli_insert_id($connect);

        if (!$request->errno) {
            mysqli_commit($connect);
            echo "<script>window.location.href='../user/user-jobrequest.php'</script>";

            $mail->Subject = "Job Request Notification";
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
                            <h2 style="text-align: center;">New Job Request</h2>
                            <h4>Job request from ' . $name . ',</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>Location:&nbsp; ' . $location . '</p>
                            <p>Job service requested:&nbsp; ' . $job_service . '</p>
                            <p>Requesting Official:&nbsp; ' . $requesting_official . '</p>
                            <p>Date Requested:&nbsp; ' . $date_requested . '</p>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </body>
            </html>
                    ';

            $mail->setFrom($email);
            $mail->FromName = "CLSU-ERMS";
            $mail->addAddress("caps19.0867@gmail.com");
            $mail->send();

            $notiftext = 'New job request from a user';
            $notif = $connect->prepare("INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(1,'User Job Request',?,?,'admin',CURRENT_TIMESTAMP)");
            $notif->bind_param("is",$request_id, $notiftext);
            $notif->execute();
            // mysqli_query($connect, "INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(1,'User Job Request','$insert_id','$text','admin',CURRENT_TIMESTAMP)");
            
            $logtext = 'User job request.';
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
                            <p class="fw-lighter text-uppercase">Error: ' . $request->error . '</p>
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

?>