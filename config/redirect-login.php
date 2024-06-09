<?php
include 'connect.php';

session_start();

$errors = [];
$code = "";

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

if (isset($_POST['redirect-login'])) {
    $userID = $_POST['userID'];
    $getUser = $connect->prepare("SELECT * FROM users WHERE userID=?");
    $getUser->bind_param("i", $userID);
    $getUser->execute();
    $result = $getUser->get_result();

    if ($result->num_rows == 1) {
        $account = $result->fetch_assoc();
        $acc_password = $account['password'];
        $_SESSION['user'] = $account;
        $role = $account['role'];
        $userID = $account['userID'];
        $verify = $account['verified'];
        $logtext = ucfirst($account['role']) . ' login.';

        if ($role === "admin") {
            if ($verify == 1) {
                $_SESSION['user'] = $account;
                header('Location: ../admin/admin.php');
                mysqli_query($connect, "SET time_zone = '+08:00'");
                
                // log
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
                header('Location: ../user/user-index.php');
                mysqli_query($connect, "SET time_zone = '+08:00'");
                
                // log
                $log = $connect->prepare("INSERT INTO system_logs (userID,action_type,timestamp)VALUES(?,?,CURRENT_TIMESTAMP)");
                $log->bind_param("is", $userID, $logtext);
                $log->execute();
                exit;
            } else {
                $_SESSION['code'] = $code;
                header('Location: ../verify.php');
            }
        }
    }
}
