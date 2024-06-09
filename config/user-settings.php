<?php
include 'connect.php';
session_start();
$user = $_SESSION['user']['userID'];
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");
$errors = [];

function checkEmail($email)
{
    include 'connect.php';
    $check = $connect->prepare("SELECT email FROM users WHERE email LIKE ?");
    $emailLike = "%$email%";
    $check->bind_param("s", $emailLike);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        return 1;
    } else {
        return 0;
    }
}

if (isset($_POST['update-profile'])){
    
    $fn =  $_POST['fn'];
    $ln =  $_POST['ln'];
    $email =  $_POST['email'];
    $location =  $_POST['location'];
    $username =  $_POST['username'];
    
    // firstname
    if (!empty($fn)) {
        if (!preg_match('/^[A-Za-z\s\-ñ]{3,}$/', $fn)) {
            $errors['firstname'] = "Enter a valid name.";
        }
    } else {
        $errors['firstname'] = "This field is required.";
    }
    //lastname
    if (!empty($ln)) {
        if (!preg_match('/^[A-Za-z\s\-ñ]{2,}$/', $ln)) {
            $errors['lastname'] = "Enter a valid lastname.";
        }
    } else {
        $errors['lastname'] = "This field is required.";
    }

    //email
    // if (!empty($email)) {
    //     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //         $errors['email'] = "Invalid email.";
    //     }
    //     $registered = checkEmail($email);

    //     if ($registered == "1") {
    //         $errors['email'] = "This email is already registered.";
    //     }
    // } else {
    //     $errors['email'] = "This field is required.";
    // }

    // location
    if (empty($location)) {
        $errors['location'] = "This field is required.";
    } elseif (strlen($location) > 25) {
        $errors['location'] = "Character limit is 25 characters.";
    }

    //username
    if (empty($username)) {
        $errors['username'] = "This field is required.";
    } elseif (!preg_match('/^[A-Za-z0-9_-]{1,15}$/', $username)) {
        $errors['username'] = "Only letters, numbers, underscores, and hyphens are allowed, and the character limit is 15.";
    }
    if (count($errors) <= 0) {
    try {
        mysqli_begin_transaction($connect);
        $sql = "UPDATE users SET firstname=?,lastname=?,email=?,username=?,user_location=? WHERE userID=?";
        $info=$connect->prepare($sql);
        $info->bind_param("sssssi",$fn,$ln,$email,$username,$location,$user);
        $info->execute();

        if (!$info->errno) {
            $role = $_SESSION['user']['role'];

            mysqli_commit($connect);
            // echo $sql;
            session_reset();
            if ($role === "admin"){
                header("Location: ../admin/admin-profile.php");
            } else if ($role === "user"){
                header("Location: ../user/user-profile.php");
            }

        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $info->error . '</p>
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
