<?php
include 'connect.php';

// decline request | admin
// cancel requset | user

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

// decline schedule request
if ($_POST['decline']) {
    $declineID = $_POST['decline'];

    $getUser = $connect->prepare("SELECT userID FROM sched_records WHERE sched_id=?");
    $getUser->bind_param("i", $declineID);
    $getUser->execute();
    $result= $getUser->get_result();
    $fetch = $result->fetch_assoc();
    $userID = $fetch['userID'];
    
    try {
    mysqli_begin_transaction($connect);
    $decline = $connect->prepare("UPDATE sched_records SET sched_status = 2 WHERE sched_id = ?");
    $decline->bind_param("i", $declineID);
    $decline->execute();

        if(!$decline->errno){
            mysqli_commit($connect);
            echo "<script>window.location.href='../admin/admin-records.php'</script>";

            // notif
            $notiftext = 'The schedule is not available. Please reschedule.';
            $notif = $connect->prepare("INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(?,'Declined Schedule',?,?,'user',CURRENT_TIMESTAMP)");
            $notif->bind_param("iis", $userID, $declineID, $notiftext);
            $notif->execute();

        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $decline->error . '</p>
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

// remove declined | removed from system
} else if($_POST['removeDeclined']){
    $removeID = $_POST['removeDeclined'];

    try {
        mysqli_begin_transaction($connect);

        $r_decline = $connect->prepare("DELETE FROM sched_records WHERE sched_id = ?");
        $r_decline->bind_param("i", $removeID);
        $r_decline->execute();

        if (!$r_decline->errno) {
            mysqli_commit($connect);
            echo "<script>window.location.href='../admin/admin-notice.php'</script>";
        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $r_decline->error . '</p>
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

// cancel requested sched
} else if ($_POST['cancel']) {
    $cancelID = $_POST['cancel'];
    
    try {
    mysqli_begin_transaction($connect);

    $cancel = $connect->prepare("UPDATE sched_records SET sched_status = 3 WHERE sched_id = ?");
    $cancel->bind_param("i", $cancelID);
    $cancel->execute();

        if(!$cancel->errno){
            mysqli_commit($connect);
            echo "<script>window.location.href='../user/user-notice.php'</script>";

            // notif
            $notiftext = 'The user has cancelled the schedule.';
            $notif = $connect->prepare("INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(1,'Cancelled Schedule',?,?,'admin',CURRENT_TIMESTAMP)");
            $notif->bind_param("is", $cancelID, $notiftext);
            $notif->execute();
        
        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $cancel->error . '</p>
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