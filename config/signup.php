<?php

include 'connect.php';
$errors = [];

function checkEmail($email)
{
    include 'connect.php';
    $check = $connect->prepare("SELECT email FROM users WHERE email LIKE ?");
    $check->bind_param("s", $emailLike);
    $emailLike = '%' . $email . '%'; 
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        return 1;
    } else {
        return 0;
    }
}

if (isset($_POST['register'])) {
    $fn =  $_POST['firstname'];
    $ln =  $_POST['lastname'];
    $email =  $_POST['email'];
    $location =  $_POST['location'];
    $username =  $_POST['username'];
    $pass =  $_POST['password'];
    $cpass =  $_POST['cpass'];

    //firstname
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
    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Invalid email.";
        }
        $registered = checkEmail($email);

        if ($registered == "1") {
            $errors['email'] = "This email is already registered.";
        }
    } else {
        $errors['email'] = "This field is required.";
    }

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

    //password
    if (!empty($pass)) {
        if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*[-~`!@#$%^&*()_+={[}\]|:;"\'<,>.?\/]).{8,}$/', $pass)) {
            $errors['password'] = "Password must be more than 8 characters that contains uppercase letters, lowercase letters, number and special characters.";
        }
    } else {
        $errors['password'] = "This field is required.";
    }

    //cpass
    if (!empty($cpass)) {
        if ($pass != $cpass) {
            $errors['cpass'] = "Password not matched.";
        }
    } else {
        $errors['cpass'] = "This field is required.";
    }

    //terms
    if (!isset($_POST['terms'])){
        $errors['terms'] = "You must agree to the terms and conditions.";
    }

    if (count($errors) <= 0) {

        $password = password_hash($pass, PASSWORD_DEFAULT);

        try {
        mysqli_begin_transaction($connect);
        $signup = "INSERT INTO users (firstname,lastname,email,username,password,user_location) VALUES (?,?,?,?,?,?)";
        $register = $connect->prepare($signup);
        $register->bind_param("ssssss", $fn, $ln, $email, $username, $password, $location);
        $register->execute();

            if (!$register->errno) {
            mysqli_commit($connect);

                $getMail = $connect->prepare("SELECT * FROM users WHERE email = ?");
                $getMail->bind_param("s", $email);
                $getMail->execute();
                $result = $getMail->get_result();

                if ($result->num_rows == 1) {

                    $account = mysqli_fetch_array($result);
                    $acc_password = $account['password'];
                    session_start();
                    $_SESSION['user'] = $account;
                    $role = $account['role'];
                    $userID = $account['userID'];
                    $verify = $account['verified'];
                    $logtext = 'Register.';

                    $code = '';
                    if ($role === "admin") {
                        if ($verify == 1) {
                            $_SESSION['user'] = $account;
                            header('Location: ./admin/admin.php');
                            mysqli_query($connect, "SET time_zone = '+08:00'");
                            $log = $connect->prepare("INSERT INTO system_logs (userID,action_type,timestamp)VALUES(?,?,CURRENT_TIMESTAMP)");
                            $log->bind_param("is", $userID, $logtext);
                            $log->execute();                            
                            exit;
                        } else {
                            $_SESSION['code'] = $code;
                            header('Location: ./verify.php');
                        }
                    } else if ($role === "user") {
                        if ($verify == 1) {
                            $_SESSION['user'] = $account;
                            header('Location: ./user/user-index.php');
                            mysqli_query($connect, "SET time_zone = '+08:00'");
                            $log = $connect->prepare("INSERT INTO system_logs (userID,action_type,timestamp)VALUES(?,?,CURRENT_TIMESTAMP)");
                            $log->bind_param("is", $userID, $logtext);
                            $log->execute();                            
                            exit;
                        } else {
                            $_SESSION['code'] = $code;
                            header('Location: ./verify.php');
                        }
                    }
                }
            } else {
                mysqli_rollback($connect);
                echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
                echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
                echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $register->error . '</p>
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
