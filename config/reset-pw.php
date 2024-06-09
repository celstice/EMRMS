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

if (isset($_POST['submit'])) {
    $email = $_POST['email'];

    $getMail = $connect->prepare("SELECT email FROM users WHERE email = ?");
    $getMail->bind_param("s", $email);
    $getMail->execute();
    $result = $getMail->get_result();

    if ($result->num_rows > 0) {
        echo "<script>window.location.href='reset-code.php'</script>";
        $_SESSION['email'] = $email;

        $code = strtoupper(bin2hex(random_bytes(3)));
        $_SESSION['code'] = $code;
        // echo $code;

        $mail->Subject = "Reset Password";
        $mail->Body ='
        
            <div style="width: 700px; height: auto; padding: 10px;">
        <table style="padding: 10px;">
            <tr>
                <td>
                    <h2 style="text-align: center;">Reset password</h2>
                    <p>Verification code to reset password.</p>
                    <h4>' . $code . '</h4>
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
    } else {
        if (!empty($_POST['email'])) {
            $error['email'] = "Email is not registered to the system.";
        } else {
            $error['email'] = "Enter email.";
        }
    }
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

                                <form method="post" action="" onsubmit="loading()">
                                    <label class="mb-3">Enter the email used in your account.</label>
                                    <div class="form-floating mb-3 ">
                                        <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" autofocus value="<?= htmlspecialchars($_POST['email'] ?? ""); ?>" placeholder="">
                                        <?php if (isset($error['email'])) : ?>
                                            <div class="text-danger text-center m-1" id="errortext"><?= $error['email'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></div>
                                        <?php endif; ?>
                                        <label for="floatingInput">Email</label>
                                    </div>

                                    <div class="mb-3 d-flex justify-content-between">
                                        <a href="../login.php" class="btn btn-lg btn-danger btn-login text-uppercase fw-bold mb-2">Cancel</a>
                                        <button type="submit" name="submit" class="btn btn-lg btn-warning btn-login text-uppercase fw-bold mb-2">Submit</button>
                                    </div>
                                </form>
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