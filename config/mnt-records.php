<?php

// manage completed job request records

include 'connect.php';

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

// add other details to repair record
if (isset($_POST['save-repair'])) {
    $jobID = $_POST['job-id'];
    $userID = $_POST['user-id'];
    $job_number = $_POST['job-number'];
    $job_location = $_POST['job-location'];
    $unit = $_POST['unit'];
    $equipment = $_POST['equipment'];
    $job_render = $_POST['job-render'];
    if (isset($_POST['start-time'])){$start_time = $_POST['start-time'];} else{ $start_time='';}
    if (isset($_POST['finish-time'])){$finish_time = $_POST['finish-time'];} else{ $finish_time='';}
    $date_start = $_POST['dateStart'];
    $date_finish = $_POST['dateFinish'];

    // repair types 
    // #1 Aircon Cleaning
    // #2 Aircon Repair
    // #3 Aircon installation
    // #4 Electric Fan Cleaning / Repair
    // #5 Electric Fan installation
    // #6 Other Equipment Repair
    // #7 Computer Repair & Troubleshoot
    // #8 Hauling Services
    try {
    mysqli_begin_transaction($connect);
    $details = "INSERT INTO repair_records(
        userID,
        job_id,

        job_number,
        repair_location,
        
        repair_unit,
        equipment_device,
        repair_type,

        start_time,
        finish_time,
        date_start,
        date_finish
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?)";

    $jobdetails=$connect->prepare($details);
    $jobdetails->bind_param("iisssssssss",
                                $userID,
                                $jobID,
                                $job_number,
                                $job_location,
                                $unit,
                                $equipment,
                                $job_render,
                                $start_time,
                                $finish_time,
                                $date_start,
                                $date_finish);
    $jobdetails->execute();

    $repairID = mysqli_insert_id($connect);

        if (!$jobdetails->errno){
            mysqli_commit($connect);

            $jobdone = $connect->prepare("UPDATE job_request SET done = 1 WHERE job_id=?");
            $jobdone->bind_param("i", $jobID);
            $jobdone->execute();

            $scheddone = $connect->prepare("UPDATE sched_records SET done = 1 WHERE job_id=?");
            $scheddone->bind_param("i", $jobID);
            $scheddone->execute();

            $repairdone = $connect->prepare("UPDATE repair_records SET done = 1 WHERE repair_id=?");
            $repairdone->bind_param("i", $repairID);
            $repairdone->execute();
            
            echo "<script>window.location.href='../admin/admin-jobrequest.php'</script>";

            // log
            $logtext = 'Added repair record.';
            $log = $connect->prepare("INSERT INTO system_logs (userID,action_type,timestamp)VALUES(?,?,CURRENT_TIMESTAMP)");
            $log->bind_param("is", $user, $logtext);
            $log->execute();

        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $jobdetails->error . '</p>
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

// update completed repair record
} else if (isset($_POST['edit-repair'])){
    $update_id = $_POST['repair-id'];
    $job_number = $_POST['job-number'];
    $job_location = $_POST['job-location'];
    $unit = $_POST['unit'];
    $equipment_device = $_POST['equipment-device'];
    $job_render = $_POST['job-render'];
    $start_time = $_POST['start-time'];
    $finish_time = $_POST['finish-time'];
    $date_start = $_POST['dateStart'];
    $date_finish = $_POST['dateFinish'];

    try{
    mysqli_begin_transaction($connect);

    $update = "UPDATE repair_records SET 
    job_number = ?,
    repair_location = ?,
    repair_unit = ?,
    equipment_device = ?,
    repair_type = ?,
    start_time = ?,
    finish_time = ?,
    date_start = ?,
    date_finish = ?,
    done=1
    WHERE repair_id = ?
    ";

    $updatedetails = $connect->prepare($update);
    $updatedetails->bind_param("sssssssssi",
                            $job_number,
                            $job_location, 
                            $unit,
                            $equipment_device,
                            $job_render,
                            $start_time,
                            $finish_time,
                            $date_start,
                            $date_finish,
                            $update_id
                        );
    $updatedetails->execute();

        if (!$updatedetails->errno){
            mysqli_commit($connect);
            echo "<script>window.location.href='../admin/admin-records.php'</script>";

            // log
            $logtext = 'edited repair record.';
            // mysqli_query($connect, "INSERT INTO system_logs (userID,action_type,timestamp)VALUES('$user','$text',CURRENT_TIMESTAMP)");
            $log = $connect->prepare("INSERT INTO system_logs (userID,action_type,timestamp)VALUES(?,?,CURRENT_TIMESTAMP)");
            $log->bind_param("is", $user, $logtext);
            $log->execute();

        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $updatedetails->error . '</p>
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
// else {echo "<script>alert('Error. Go bck');</script>";}

?>