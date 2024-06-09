<?php
session_start();

if (isset($_SESSION['user'])) {
    $role = $_SESSION['user']['role'];
    if ($role == "admin") {
        header('Location: admin/admin.php');
    } else if ($role == "user") {
        header('Location: user/user-index.php');
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>index</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/css/index.css" rel="stylesheet">
</head>

<body>
    <header id="">
        <div class="container d-flex justify-content-center align-items-center flex-column mt-5 mb-5">

            <div class="d-flex justify-content-center flex-column m-3">
                <h5 class="text-center text-white">CLSU Equipment Repair and Maintenance Services</h5>
            </div>

            <div class='d-flex justify-content-center flex-column'>
                <div class="d-flex justify-content-center bg-dange m-3">
                    <img src="assets/img/clsu-logo.png" class="home-logo rounded-circle">
                </div>
                <div class="d-flex justify-content-center text-white" id="title">
                    <p class=" fw-bold text-uppercase">Equipment Maintenance Record System</p>
                </div>
            </div>

            <div class="logins d-flex flex-column justify-content-center bg-dange align-items-center mt-3">
                <div class="d-block">
                    <div class="row mt-2">
                        <a href="login.php" class="btn btn-warning btn-block m-1 ps-5 pe-5 pt-2 pb-2">LOGIN</a>
                    </div>
                    <div class="row mt-2">
                        <a href="register.php" class="btn btn-warning btn-block m-1 ps-5 pe-5 pt-2 pb-2">REGISTER</a>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-center flex-column" id="scan">
                <a href="scanQR.php" target="_blank" class="text-decoration-none text-center d-flex justify-content-center align-items-center flex-column">
                    <h2 data-bs-placement="top" title="Scan QR Code" class=""><i class="fa-solid fa-qrcode text-white"></i></h2>
                    <span class="fw-bold text-white">SCAN QR</span>
                </a>
            </div>

        </div>
    </header>

    <script>
        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };
    </script>
</body>

</html>