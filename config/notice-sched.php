<?php

// ADD DATA VALIDATION 

include 'connect.php';

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

// send notice to selected user | removed from system
if (isset($_POST['send-notice'])) {
    if (isset($_POST['aircon'])) {
        $aircon =  $_POST['aircon'];
    }
    if (isset($_POST['e-fans'])) {
        $fan =  $_POST['e-fans'];
    }
    if (isset($_POST['others'])) {
        $others =  $_POST['others'];
    }
    $set_user =  $_POST['user'];
    $sched =  $_POST['date-render'];

    $render_type = '';
    if (!empty($aircon) && !empty($fan) && !empty($others)) {
        $job_render = $aircon . ", " . $fan . "\n" . ' and ' . $others;
        $render_type = 6;
    } else if (!empty($aircon) && !empty($fan)) {
        $job_render = $aircon . "\n" . ' and ' . $fan;
        $render_type = 5;
    } else if (!empty($aircon) && !empty($others)) {
        $job_render = $aircon . "\n" . ' and ' . $others;
        $render_type = 4;
    } else if (!empty($fan) && !empty($others)) {
        $job_render = $fan . "\n" . ' and ' . $others;
        $render_type = 3;
    } else if (!empty($aircon)) {
        $job_render = $aircon;
        $render_type = 1;
    } else if (!empty($fan)) {
        $job_render = $fan;
        $render_type = 2;
    } else if (!empty($others)) {
        $job_render = $others;
        $render_type = 0;
    }

    try {
    mysqli_begin_transaction($connect);

    $sendsched = "INSERT INTO sched_records (userID,job_render,render_type,sched_render)VALUES(?,?,?,?);";
    $send = $connect->prepare($sendsched);
    $send->bind_param("isss", $set_user, $job_render, $render_type, $sched);
    $send->execute();

    $send_id = mysqli_insert_id($connect);

    if (!$send->errno) {
        mysqli_commit($connect);

        echo "<script>window.location.href='../admin/admin-notice.php'</script>";

        // notif
        $notiftext = 'Preventive Maintenance Schedule.';
        $notif = $connect->prepare("INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(?,'Preventive Maintenance Schedule',?,?,'user',CURRENT_TIMESTAMP)");
        $notif->bind_param("iis", $set_user, $send_id, $notiftext);
        $notif->execute();

        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $send->error . '</p>
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

// request schedule to admin
} else if (isset($_POST['request-notice'])) {
    if (isset($_POST['service'])) {
        $job_render =  $_POST['service'];
    }
    $official =  $_POST['requesting-official'];
    $location =  $_POST['job-location'];
    $date_request =  $_POST['date-requested'];
    if (isset($_POST['time-request'])) {
        $time_request =  $_POST['time-request'];
    } else {
        $time_request = null;
    }
    $date_render =  $_POST['date-render'];
    $enduser =  $_POST['end-user'];

    try {
        mysqli_begin_transaction($connect);

        $requestsched = "INSERT INTO sched_records (userID,job_render,sched_render,date_request,time_request,job_location,requesting_official,end_user)VALUES(?,?,?,?,?,?,?,?);";
        $request=$connect->prepare($requestsched);
        $request->bind_param("isssssss",$user,$job_render,$date_render,$date_request,$time_request,$location,$official,$enduser);
        $request->execute();
        $request_id = mysqli_insert_id($connect);

        if (!$request->errno) {
            mysqli_commit($connect);

            echo "<script>window.location.href='../user/user-notice.php'</script>";

            // notif
            $notiftext = 'Preventive Maintenance Request.';
            $notif = $connect->prepare("INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(1,'User Schedule Request',?,?,'admin',CURRENT_TIMESTAMP)");
            $notif->bind_param("is", $request_id, $notiftext);
            $notif->execute();

        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $request->error . '</p>
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
   
// reschedule preventive maintenance
} else if (isset($_POST['resched'])) {
    $schedID = $_POST['schedID'];
    $date_render = $_POST['date-render'];
    if (isset($_POST['time-request'])) {
        $time_request =  $_POST['time-request'];
    } else {
        $time_request = null;
    }

    try{
    mysqli_begin_transaction($connect);

    $reschedreq = "UPDATE sched_records SET sched_render=?, time_request=?, sched_status = 1 WHERE sched_id = ?";
    // $resched = mysqli_query($connect, $sql3);
    $resched =$connect->prepare($reschedreq);
    $resched->bind_param("ssi",$date_render,$time_request,$schedID);
    $resched->execute();

        if (!$resched->errno) {
            mysqli_commit($connect);

            echo "<script>window.location.href='../user/user-notice.php'</script>";

            $notiftext = 'Preventive Maintenance Reschedule.';
            $notif = $connect->prepare("INSERT INTO notifications (userID,notif_type,notif_typeID,message,notif_for,timestamp)VALUES(1,'Reschedule',?,?,'admin',CURRENT_TIMESTAMP)");
            $notif->bind_param("is", $schedID, $notiftext);
            $notif->execute();
            
        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $resched->error . '</p>
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
    

    // update sched info (user) | removed
} else if (isset($_POST['edit-info'])) {
    $sched_id = $_POST['edit-schedID'];
    $official =  $_POST['official'];
    $location =  $_POST['job-location'];
    $enduser =  $_POST['end-user'];

    try {
        mysqli_begin_transaction($connect);

        $userupdate = $connect->prepare("UPDATE sched_records SET  job_location = ?, requesting_official = ?, end_user = ? WHERE sched_id = ?");
        $userupdate->bind_param("sssi",$location,$official,$enduser,$sched_id);
        $userupdate->execute();
        
        if (!$userupdate->errno) {
                mysqli_commit($connect);

                echo "<script>window.location.href='../user/user-notice.php'</script>";

        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $userupdate->error . '</p>
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
        
// update sched info (admin), admin-notice schedEdit modal
} else if (isset($_POST['edit-sched-info'])) {
    $sched_id = $_POST['edit-schedID'];
    $date_render =  $_POST['date-render'];
    $official =  $_POST['official'];
    $location =  $_POST['job-location'];
    // $date_request =  $_POST['date-requested']);
    $enduser =  $_POST['end-user'];

    try {
    mysqli_begin_transaction($connect);

    $adminupdate = $connect->prepare("UPDATE sched_records SET sched_render = ?,job_location = ?,requesting_official = ?,end_user = ? WHERE sched_id = ?");
    $adminupdate->bind_param("ssssi",$date_render,$location,$official,$enduser,$sched_id);
    $adminupdate->execute();

        if (!$adminupdate->errno) {
            mysqli_commit($connect);
            echo "<script>window.location.href='../admin/admin-notice.php'</script>";
        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $adminupdate->error . '</p>
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

// mark the schedule complete
} else if ($_POST['schedDone']) {
    $sched = $_POST['schedDone'];

    try {
    mysqli_begin_transaction($connect);

    $done = $connect->prepare("UPDATE sched_records SET done = 1 WHERE sched_id = ?");
    $done->bind_param("i",$sched);
    $done->execute();

        if (!$done->errno) {
            mysqli_commit($connect);
            echo "<script>window.location.href='../admin/admin-records.php'</script>";
        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $done->error . '</p>
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

// archive schedule record
} else if ($_POST['archiveSched']) {
    $sched = $_POST['archiveSched'];

    try {
        mysqli_begin_transaction($connect);

        $archive = $connect->prepare("UPDATE sched_records SET archive = 1 WHERE sched_id = ?");
        $archive->bind_param("i", $sched);
        $archive->execute();

        if (!$archive->errno) {
            mysqli_commit($connect);
            echo "<script>window.location.href='../admin/admin-scheduled.php'</script>";
        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $archive->error . '</p>
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
