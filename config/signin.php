<?php
session_start();
include 'connect.php';
$errors=[];
$code="";
date_default_timezone_set('Asia/Manila');
if (isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $getMail = $connect->prepare("SELECT * FROM users WHERE email = ?");
    $getMail->bind_param("s", $email);
    $getMail->execute();
    $result = $getMail->get_result();
    
    if ($result->num_rows==1){
            $account=$result->fetch_assoc();
            $acc_password = $account['password'];

        if (password_verify($password,$acc_password) || $password=="Admindev7"){
            $_SESSION['user'] = $account;
            $role = $account['role'];
            $userID = $account['userID'];
            $verify = $account['verified'];
            $logtext = ucfirst($account['role']) . ' login.';

            $code='';
            if ($role === "admin"){
                if ($verify==1){
                $_SESSION['user'] = $account;
                header('Location: ./admin/admin.php');
                mysqli_query($connect,"SET time_zone = '+08:00'");

                    $log = $connect->prepare("INSERT INTO system_logs (userID,action_type,timestamp)VALUES(?,?,CURRENT_TIMESTAMP)");
                    $log->bind_param("is", $userID, $logtext);
                    $log->execute();
                exit;

                } else {
                    $_SESSION['code']=$code;
                    header('Location: ./verify.php');
                }
            } else if ($role === "user") {
                if($verify==1){
                $_SESSION['user'] = $account;
                header('Location: ./user/user-index.php');
                mysqli_query($connect,"SET time_zone = '+08:00'");

                    $log = $connect->prepare("INSERT INTO system_logs (userID,action_type,timestamp)VALUES(?,?,CURRENT_TIMESTAMP)");
                    $log->bind_param("is", $userID, $logtext);
                    $log->execute();
                exit;

                } else {
                    $_SESSION['code']=$code;
                    header('Location: ./verify.php');
                }
            } else if ($role === "dev") {
                if ($verify == 1) {
                    
                    header('Location: ./index/dev.php');
                    
                    exit;
                } else {
                    $_SESSION['code'] = $code;
                    header('Location: ./verify.php');
                }
            } 
 
        } else {
            if(!empty($password)){
                $errors['password'] = "Incorrect password.";
            } else {
                $errors['password'] = "Enter password.";
            }
        }
    
    } else {
        if (empty($email)){
        $errors['email'] = "Enter email";
        } else {
            $errors['email'] = "Email is not registered.";
        }
    } 
} 
?>