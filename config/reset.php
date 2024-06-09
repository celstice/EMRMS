<?php
session_start();
include 'connect.php';
$email = $_SESSION['email'];

$getID = $connect->prepare("SELECT * FROM users WHERE email = ?");
$getID->bind_param("s", $email);
$getID->execute();
$result = $getID->get_result();
$ID = $result->fetch_assoc();
$userID = $ID['userID'];

$errors = [];
if (isset($_POST['reset'])) {
    $npass = mysqli_real_escape_string($connect,$_POST['npass']);
    $cpass = mysqli_real_escape_string($connect,$_POST['cpass']);

    //password
    if (!empty($npass)) {
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[-~`!@#$%^&*()_+={[}\]|:;"\'<,>.?\/]).{8,}$/', $npass)) {
            $errors['npass'] = "Password must be more than 8 characters that contains uppercase letters, lowercase letters, number and special characters.";
        }
    } else {
        $errors['npass'] = "This field is required.";
    }

    //cpass
    if (!empty($cpass)) {
        if ($npass != $cpass) {
            $errors['cpass'] = "Password not matched.";
        }
    } else {
        $errors['cpass'] = "This field is required.";
    }

    if (count($errors) <= 0) {
        $password = password_hash($npass, PASSWORD_DEFAULT);

        try {
            mysqli_begin_transaction($connect);

        $change = $connect->prepare("UPDATE users SET password=? WHERE userID = ?");
        $change->bind_param("si",$password,$userID);
        $change->execute();

            if (!$change->errno) {
                mysqli_commit($connect);
                session_destroy();
                echo '<script>window.location.href="../login.php"</script>';
            } else {
                mysqli_rollback($connect);
                echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
                echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
                echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $change->error . '</p>
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
                                    <div class="d-flex flex-column">
                                        <div class="form-floating mb-3 ">
                                            <input type="password" class="form-control" id="npass" name="npass" autofocus value="<?= htmlspecialchars($_POST['npass'] ?? "") ?>">
                                            <?php if (isset($errors['npass'])) : ?>
                                                <div class="text-danger text-center m-1" id="errortext"><?= $errors['npass'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></div>
                                            <?php endif; ?>
                                            <label for="n-pass">New Password</label>
                                        </div>

                                        <div class="form-floating mb-3 ">
                                            <input type="password" class="form-control" id="cpass" name="cpass" autofocus value="<?= htmlspecialchars($_POST['cpass'] ?? "") ?>">
                                            <?php if (isset($errors['cpass'])) : ?>
                                                <div class="text-danger text-center m-1" id="errortext"><?= $errors['cpass'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></div>
                                            <?php endif; ?>
                                            <label for="cpass">Confirm Password</label>
                                        </div>
                                        <div class="mb-3 d-flex justify-content-end">
                                            <button type="submit" name="reset" class="d-flex btn text-truncate btn-warning  text-uppercase mb-2">Reset password</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
<script>
    function loading() {
        Swal.fire({
            title: 'Password changed.',
            icon: 'success',
            allowOutsideClick: false,
            showConfirmButton: false,
            timer: 3000,
            didOpen: () => {
                Swal.loading();
            },
        });
    }

    function hideLoading() {
        Swal.close();
    }

    document.getElementById('reset').addEventListener('click', function() {
        loading();
        document.querySelector('form').submit();
    });
</script>

</html>