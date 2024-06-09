<?php

// feedback

include 'connect.php';

session_start();
//employee
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

if (isset($_POST['feedback'])){

$job_id = mysqli_real_escape_string($connect,$_POST['job-id']);
$job_ctrl = mysqli_real_escape_string($connect,$_POST['job-ctrl']);
$feedback_number = mysqli_real_escape_string($connect,$_POST['feedback-number']);
$transaction = mysqli_real_escape_string($connect,$_POST['transaction']);
$date = mysqli_real_escape_string($connect,$_POST['date']);
$office = mysqli_real_escape_string($connect,$_POST['office-rated']);

$responsive1 = mysqli_real_escape_string($connect,$_POST['responsive1']);
$responsive2 = mysqli_real_escape_string($connect,$_POST['responsive2']);
$reliability1 = mysqli_real_escape_string($connect,$_POST['reliability1']);
$reliability2 = mysqli_real_escape_string($connect,$_POST['reliability2']);
$facility = mysqli_real_escape_string($connect,$_POST['facility']);
$access = mysqli_real_escape_string($connect,$_POST['access']);
$communication1 = mysqli_real_escape_string($connect,$_POST['communication1']);
$communication2 = mysqli_real_escape_string($connect,$_POST['communication2']);

$cost1 = isset($_POST['cost1']) ? mysqli_real_escape_string($connect, $_POST['cost1']) : null;
$cost2 = isset($_POST['cost2']) ? mysqli_real_escape_string($connect, $_POST['cost2']) : null;

$integrity = mysqli_real_escape_string($connect,$_POST['integrity']);
$assurance = mysqli_real_escape_string($connect,$_POST['assurance']);
$outcome = mysqli_real_escape_string($connect,$_POST['outcome']);
$comments = mysqli_real_escape_string($connect,$_POST['comments']);
    
}
try {
mysqli_begin_transaction($connect);
$sql = "INSERT INTO feedbacks (
    userID,
    job_id,
    job_ctrl,
    feedback_number,
    job_service,
    feedback_date,
    office,
    responsive1,
    responsive2,
    reliability1,
    reliability2,
    facility,
    access,
    communication1,
    communication2,
    cost1,
    cost2,
    integrity,
    assurance,
    outcome,
    comments
) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$feedback = $connect->prepare($sql);
$feedback->bind_param("iisssssiiiiiiiiiiiiis",
                        $user,
                        $job_id,
                        $job_ctrl,
                        $feedback_number,
                        $transaction,
                        $date,
                        $office,
                        $responsive1,
                        $responsive2,
                        $reliability1,
                        $reliability2,
                        $facility,
                        $access,
                        $communication1,
                        $communication2,
                        $cost1,
                        $cost2,
                        $integrity,
                        $assurance,
                        $outcome,
                        $comments);
$feedback->execute();

$feedback_id = mysqli_insert_id($connect);
if (!$feedback->errno) {
    mysqli_commit($connect);
    echo "<script>window.location.href='../user/user-jobrequest.php'</script>";

    $stat = $connect->prepare("UPDATE feedbacks SET done=1 WHERE feedback_id=?");
    $stat->bind_param("i",$feedback_id);
    $stat->execute();

    // notif
    $notiftext = 'Feedback from a user.';
    $notif = $connect->prepare("INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(1,'User Feedback',?,?,'admin',CURRENT_TIMESTAMP)");
    $notif->bind_param("is", $feedback_id, $notiftext);
    $notif->execute();
        
    // log
    $logtext = 'Submit feedback.';
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
                            <p class="fw-lighter text-uppercase">Error: ' . $feedback->error . '</p>
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
?>