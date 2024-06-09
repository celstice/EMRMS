<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "../vendor/phpmailer/phpmailer/src/Exception.php";
require "../vendor/phpmailer/phpmailer/src/PHPMailer.php";
require "../vendor/phpmailer/phpmailer/src/SMTP.php";

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

session_start();

include 'connect.php';

$error = [];

$email = $_SESSION['email'];

$encode = '';
$Timestamp = $_SESSION['code_timestamp'];
$currentTime = time();
$timer = $currentTime - $Timestamp;

if (isset($_POST['submit'])) {
    $encode = $_SESSION['code'];
    $email = mysqli_real_escape_string($connect,$_POST['email']);
    $code = mysqli_real_escape_string($connect,$_POST['code']);

    if ($code === $encode && $timer <= 300) {
        echo "<script>window.location.href='reset.php'</script>";
    } else {
        if (!empty($_POST['code'])) {
            $error['code'] = "Invalid Code.";
        } else {
            $error['code'] = "Enter verification code.";
        }
    }
} else if (isset($_POST['resend'])) {
    $ncode = strtoupper(bin2hex(random_bytes(3)));
    $_SESSION['code'] = $ncode;
    $mail->Subject = "Reset Password";
    $mail->Body =
        '<div style="width: 700px; height: auto; padding: 10px;">
        <table style="padding: 10px;">
            <tr>
                <td>
                    <h2 style="text-align: center;">Reset password</h2>
                    <p>Verification code to reset password.</p>
                    <h4>' . $ncode . '</h4>
                </td>
            </tr>
            <tr>
                <td>
                    
                </td>
            </tr>
            <tr>
                <td>
                    <p>Enter the code within <b>5 minutes</b>. Thank you.</p>
                </td>
            </tr>
            </tbody>
        </table>
        </div>';

    $mail->setFrom("caps19.0867@gmail.com", "CLSU-ERMS");
    $mail->addAddress($email);

    $mail->send();
    $_SESSION['code_timestamp'] = time();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Change password</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="../assets/css/login.css" rel="stylesheet">
</head>

<body>

    <div class="container-fluid ps-md-0">
        <div class="row g-0">
            <div id="left" class="d-none d-md-flex col-md-4 col">
                <div class="container d-flex flex-column justify-content-center align-items-center">
                    <div id="logo" class="d-flex"><img class="logo-img" src="../assets/img/clsu-logo.png">
                        <section class="logo-text">CLSU</section>
                    </div>
                    <p><span></span>Equipment<span></span>Repair and<span></span> Maintenance<span></span> Services</p>
                </div>
            </div>
            <div id="" class="col-md-8 col-lg-8">
                <div class="login d-flex align-items-center py-5 ">
                    <div class="container col-md-7">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <div class="p-3 text-success d-flex justify-content-center">
                                    <h1 class="login-heading mb-4 fw-bolder display-1"><i class="fa-solid fa-circle-exclamation"></i></h1>
                                </div>
                                <div class="d-flex justify-content-start p-2 ">
                                    <span>Enter the verification code sent to your email.</span>
                                </div>

                                <form method="post" action="" onsubmit="loading2()">
                                    <div class="form-floating mb-3 ">
                                        <input class="form-control" disabled id="floatingInput" value="<?php echo $email; ?>">
                                        <input id="floatingInput" name="email" value="<?php echo $email; ?>" hidden>
                                        <label for="floatingInput">Email</label>
                                    </div>
                                    <div class="form-floating mb-3 ">
                                        <input type="text" class="form-control" id="code" name="code" autofocus value="<?= htmlspecialchars($_POST['code'] ?? ""); ?>">

                                        <label for="code">Verification Code</label>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" name="submit" class="btn btn-lg btn-warning btn-login text-uppercase fw-bold mb-2">Submit</button>
                                    </div>
                                </form>
                                <?php if (isset($error['code'])) : ?>
                                    <div class="text-danger text-center m-1" id="errortext"><?= $error['code'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></div>
                                    <form method="post" action="" onsubmit="loading()" class="d-flex justify-content-center p-2">
                                        <button type="submit" name="resend" class="btn btn-primary text-decoration-none">Resend</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php //} 
    ?>
</body>
<script>
    function loading() {
        Swal.fire({
            title: 'Resending code...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.loading();
            },
        });
    }

    function loading2() {
        Swal.fire({
            title: 'Please wait...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.loading();
            },
        });
    }

    function hideLoading() {
        Swal.close();
    }
</script>

</html>