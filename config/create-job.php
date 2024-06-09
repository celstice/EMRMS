<?php

// create job request for schedule request | admin

include 'connect.php';

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

$_POST['jobComplete'];

$userID =  $_POST['userID'];
$schedID =  $_POST['schedID'];

$job_service =  $_POST['jobservice'];
$requesting_official =  $_POST['rqofficial'];
$job_location =  $_POST['joblocation'];
$date_requested =  $_POST['daterequested'];

$job_number =  $_POST['jobnumber'];
$supplies_materials =  $_POST['supplies'];
$causes =  $_POST['causes'];
$assigned_personnel =  $_POST['personnel'];
$feedback_number =  $_POST['feedbacknumber'];

echo "data: ".$userID;
try {
    mysqli_begin_transaction($connect);
    
    $create = "INSERT INTO job_request (
                userID, 
                job_control_number,	
                supplies_materials,
                causes,	
                assigned_personnel,
                feedback_number,
                job_service,
                requesting_official,
                job_location,
                date_requested
                ) VALUES( ?,?,?,?,?,?,?,?,?,?)";
    
    // $jobRequest = mysqli_query($connect, $create);
    $jobRequest = $connect->prepare($create);
    $jobRequest->bind_param("isssssssss", 
                            $userID, 
                            $job_number, 
                            $supplies_materials, 
                            $causes, 
                            $assigned_personnel, 
                            $feedback_number, 
                            $job_service,
                            $requesting_official,
                            $job_location,
                            $date_requested
                        );
    $jobRequest->execute();
    $jobID = mysqli_insert_id($connect);

    if (!$jobRequest->errno) {
        mysqli_commit($connect);

        $request=$connect->prepare("UPDATE sched_records SET job_id = ?, job_request = 1 WHERE sched_id=?");
        $request->bind_param("ii", $jobID,$schedID);
        $request->execute();

        $confirmed = $connect->prepare("UPDATE job_request SET confirmed = 1 WHERE job_id=?");
        $confirmed->bind_param("i", $jobID);
        $confirmed->execute();
        
        $notiftext = 'Your requested schedule is confirmed.';
        $notif = $connect->prepare("INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(?,'Schedule Request',?,?,'user',CURRENT_TIMESTAMP)");
        $notif->bind_param("iis", $userID, $schedID, $notiftext);
        $notif->execute();

        echo "<script>window.location.href='../admin/admin-notice.php'</script>";

    } else {
        mysqli_rollback($connect);
        echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
        echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
        echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $jobRequest->error . '</p>
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

