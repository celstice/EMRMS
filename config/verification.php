<?php

include 'connect.php';
session_start();
$user = $_SESSION['user']['userID'];
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

if (isset($_POST['encode']) && isset($_POST['vcode'])) {
    $code = $_POST['vcode'];
    $encode = $_POST['encode'];

    $Timestamp = $_SESSION['code_timestamp'];

    $currentTime = time();
    $timer = $currentTime - $Timestamp;

    if ($encode == $code && $timer <= 300) {

        try{
        mysqli_begin_transaction($connect);
        $activate = $connect->prepare("UPDATE users SET verified=1 WHERE userID=?");
        $activate->bind_param("i",$user);
        $activate->execute();

        if (!$activate->errno){
            mysqli_commit($connect);
            } else {
                mysqli_rollback($connect);
                echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
                echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
                echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $activate->error . '</p>
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