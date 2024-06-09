<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "emrms_db";

try{
$connect = mysqli_connect($server, $user, $password, $db);
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

if (!$connect) {
    die('Database connection failed: ' . mysqli_connect_error());
}

} catch (Exception $e){
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
?>