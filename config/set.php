<?php
include 'connect.php';

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

// set maintenance from add schedule
if (isset($_POST['set'])){
    $equip_id = $_POST['equip-id'];
    $next = $_POST['next'];
    $description = $_POST['description'];
    $by = $_POST['by'];
    $notes = $_POST['notes'];

    try{
    mysqli_begin_transaction($connect);

        $sqlset = "INSERT INTO maintenance_records (userID,equipment_id,next_mnt,mnt_description,maintained_by,notes_remarks)
        VALUES (?,?,?,?,?,?) ";

        $set = $connect->prepare($sqlset);
        $set->bind_param("iissss", $user, $equip_id, $next, $description, $by, $notes);
        $set->execute();
    
        if (!$set->errno) {
            mysqli_commit($connect);

            echo "<script>window.location.href='../user/user-schedule.php'</script>";

            $sched = $connect->prepare("UPDATE equipments SET mnt_sched=1 WHERE equipment_id = ?");
            $sched->bind_param("i",$equip_id);
            $sched->execute();

            $logtext = 'Set maintenance schedule for equipment.';
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
                            <p class="fw-lighter text-uppercase">Error: ' . $set->error . '</p>
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

//  set maintenance from equipment record
} else if (isset($_POST['set-mnt'])) {
    $equip_id =  $_POST['equip-id'];
    $next =  $_POST['next'];
    $description =  $_POST['description'];
    $by =  $_POST['by'];
    $notes =  $_POST['notes'];

    try {
        mysqli_begin_transaction($connect);

        $sqlset = "INSERT INTO maintenance_records (userID,equipment_id,next_mnt,mnt_description,maintained_by,notes_remarks)
        VALUES (?,?,?,?,?,?) ";

        $setEQ = $connect->prepare($sqlset);
        $setEQ->bind_param("iissss", $user, $equip_id, $next, $description, $by, $notes);
        $setEQ->execute();

        if (!$setEQ->errno) {
            mysqli_commit($connect);

            echo "<script>window.location.href='../user/user-schedule.php'</script>";

            $schedEQ = $connect->prepare("UPDATE equipments SET mnt_sched=1 WHERE equipment_id = ?");
            $schedEQ->bind_param("i", $equip_id);
            $schedEQ->execute();

            // log 
            $logtext = 'Set maintenance schedule for equipment.';
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
                            <p class="fw-lighter text-uppercase">Error: ' . $setEQ->error . '</p>
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

// ======================================================================
// Edit Button

} else if (isset($_POST['edit-set'])) {
    $mnt_id = $_POST['edit-set-id'];
    $next = $_POST['edit-next'];
    $description = $_POST['edit-description'];
    $by = $_POST['edit-by'];
    $notes = $_POST['edit-notes'];

    try {
    
    mysqli_begin_transaction($connect);
    
    $sqlupdate = "UPDATE maintenance_records SET next_mnt=?, mnt_description=?, maintained_by=?, notes_remarks=? WHERE mnt_id=?";
    $update=$connect->prepare($sqlupdate);
    $update->bind_param("ssssi",$next,$description,$by,$notes,$mnt_id);
    $update->execute();

        if (!$update->errno) {
            mysqli_commit($connect);

            echo "<script>window.location.href='../user/user-schedule.php'</script>";

            // log
            $logtext = 'Edit maintenance schedule of equipment.';
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

} else if (isset($_POST['add-last'])) {
	$id =  $_POST['eq-id'];
	$last =  $_POST['last'];

    try{
    mysqli_begin_transaction($connect);

	$addlast = $connect->prepare("UPDATE maintenance_records SET last_mnt=? WHERE equipment_id=?");
    $addlast->bind_param("si",$last,$id);
    $addlast->execute();

        if (!$addlast->errno) {
            mysqli_commit($connect);
            echo "<script>window.location.href='../user/equipment-record.php?id=" . $id . "';</script>";
        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $addlast->error . '</p>
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

} else if ($_POST['done']) {

    $ID = $_POST['done'];
    $record = array();
    try {

    mysqli_begin_transaction($connect);

    $selectEQid = $connect->prepare("SELECT * FROM maintenance_records WHERE mnt_id=?");
    $selectEQid->bind_param("i",$ID);
    $selectEQid->execute();
    $EQid=$selectEQid->get_result();
    $fetch = $EQid->fetch_assoc();
    $equip_id = $fetch['equipment_id'];

    $mntdone = $connect->prepare("UPDATE maintenance_records SET last_mnt = next_mnt, next_mnt=null, done=1 WHERE mnt_id = ?");
    $mntdone->bind_param("i",$ID);
    $mntdone->execute();

        if (!$mntdone->errno) {
            mysqli_commit($connect);
            
            echo "<script>window.location.href='../user/user-schedule.php'</script>";
            
            $equipment = $connect->prepare("UPDATE equipments SET mnt_sched=0 WHERE equipment_id = ?");
            $equipment->bind_param("i",$equip_id);
            $equipment->execute();

        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                            <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
                        </div>';
            echo '<div class="m-3">
                            <p class="fw-lighter text-uppercase">Error: ' . $mntdone->error . '</p>
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