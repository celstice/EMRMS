<?php
//ADMIN: update job request
include 'connect.php';
session_start();
$user = $_SESSION['user']['userID'];
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");
if(isset($_POST['updatejob'])){
    $id = $_POST['update-id'];
    $job_number = $_POST['job-number'];
    $supplies_materials = $_POST['supplies-materials'];
    $causes =  $_POST['causes'];
    $assigned_personnel = $_POST['assigned-personnel'];
    $feedback_number = $_POST['feedback-number'];
    $job_service = $_POST['job-service'];
    $requesting_official = $_POST['requesting-official'];
    $location = $_POST['location'];
    $date_requested = $_POST['date-requested'];

    try{
        mysqli_begin_transaction($connect);

        $sql = "UPDATE job_request SET 
        job_control_number=?,
        supplies_materials=?,
        causes = ?,
        assigned_personnel=?,
        feedback_number=?,
        job_service=?,
        requesting_official=?,
        job_location=?,
        date_requested=? 
        WHERE job_id=?
        ";

        $update = $connect->prepare($sql);
        $update->bind_param("sssssssssi",
                            $job_number,
                            $supplies_materials,
                            $causes,
                            $assigned_personnel,
                            $feedback_number,
                            $job_service,
                            $requesting_official,
                            $location,
                            $date_requested,
                            $id);
        $update->execute();

        if (!$update->errno){   
            mysqli_commit($connect);
            echo "<script>window.location.href='../admin/admin-jobrequest.php'</script>";

            // logs
            $logtext = 'Update job request.';
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
                            <p class="fw-lighter text-uppercase">Error: ' . $update->error . '</p>
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
?>
