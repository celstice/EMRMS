<?php

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

if ($_POST['codex']) {
    $encode = $_POST['codex'];

    $getMail = $connect->prepare("SELECT * FROM users WHERE userID = ?");
    $getMail->bind_param("i", $user);
    $getMail->execute();
    $result = $getMail->get_result();
    $row = $result->fetch_assoc();
    $email = $row['email'];

    try {

        $mail->Subject = "Verification Code";
        $mail->Body =
            '<!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            @media screen and (max-width: 600px) {
                p {font-size: 35px !important;}
                h2 {font-size:40px !important;}
                h1 {font-size: 50px !important;}
            }
        </style>
        </head>
        <body>
            <div style="width: 700px; height: auto; padding: 10px; text-align:center !important;">
            <table style="padding: 10px; text-align:center !important;">
                <tr>
                    <td style="text-align:center !important;">
                        <h2 style="text-align: center;">Verify account</h2>
                        <p>Verification code for ' . $email . '.</p>
                        <h1>' . $encode . '</h1>
                    </td>
                </tr>
                <tr>
                    <td>
                        
                    </td>
                </tr>
                <tr>
                    <td>
                        <p style="color:red;">Enter the code within <b>5 minutes</b>. Thank you.</p>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>
        </body>
        </html>';

        $mail->setFrom("caps19.0867@gmail.com", "CLSU-ERMS");
        $mail->addAddress($email);
        $mail->send();

        $_SESSION['code_timestamp'] = time();

    } catch (Exception $e) {
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