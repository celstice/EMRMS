<?php 

// Archive/Restore admin records

include 'connect.php';

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

// archive repair record
if (isset($_POST['archiveRepair'])){
    $archiveRepair = $_POST['repair'];
    $archiveJob = $_POST['request'];
    try {
        mysqli_begin_transaction($connect);

        $archiverepair = $connect->prepare("UPDATE repair_records SET archive = 1 WHERE repair_id = ?");
        $archiverepair->bind_param("i", $archiveRepair);
        $archiverepair->execute();

        if (!$archiverepair->errno) {
            mysqli_commit($connect);
            header("Location: ../admin/admin-records.php");

            // log
            $logtext = 'Archived repair record.';
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
                <p class="fw-lighter text-uppercase">Error: ' . $archiverepair->error . '</p>
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

// restore repair record
} else if (isset($_POST['restoreRepair'])){
    $restoreRepair = $_POST['repair'];
    $restoreJob = $_POST['request'];
    try {
        mysqli_begin_transaction($connect);

        $restorerepair = $connect->prepare("UPDATE repair_records SET archive = 0 WHERE repair_id = ?");
        $restorerepair->bind_param("i", $restoreRepair);
        $restorerepair->execute();

        if (!$restorerepair->errno) {
            mysqli_commit($connect);
            header("Location: ../admin/admin-archives.php");

            // log
            $logtext = 'Restored repair record.';
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
                <p class="fw-lighter text-uppercase">Error: ' . $restorerepair->error . '</p>
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


// delete repair record
} else if (isset($_POST['deleteRepair'])){
    $deleteRepair = $_POST['deleterepair'];
    $deleteJob = $_POST['deleterequest'];
    try {
        mysqli_begin_transaction($connect);
        
        $deleterepair = $connect->prepare("DELETE FROM repair_records WHERE repair_id = ?");
        $deleterepair->bind_param("i", $deleteRepair);
        $deleterepair->execute();

        if (!$deleterepair->errno) {
            mysqli_commit($connect);
            header("Location: ../admin/admin-archives.php");

            // log
            $logtext = 'Deleted repair record.';
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
                <p class="fw-lighter text-uppercase">Error: ' . $deleterepair->error . '</p>
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

// archive inv
} else if ($_POST['adminINV']) {
    $archiveINV = $_POST['adminINV'];
    try {
        mysqli_begin_transaction($connect);
        
        $archiveinv = $connect->prepare("UPDATE admin_inventory SET archive=1 WHERE admin_inv_id = ?");
        $archiveinv->bind_param("i", $archiveINV);
        $archiveinv->execute();

        if (!$archiveinv->errno) {
            mysqli_commit($connect);
            header("Location: ../admin/admin-archives.php");

            // log
            $logtext = 'Archived inventory record.';
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
                <p class="fw-lighter text-uppercase">Error: ' . $archiveinv->error . '</p>
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
    
//  restore inv
} else if ($_POST['restoreINV']) {
    $restoreINV = $_POST['restoreINV'];
    try {
        mysqli_begin_transaction($connect);
        
        $restoreinv = $connect->prepare("UPDATE admin_inventory SET archive=0 WHERE admin_inv_id = ?");
        $restoreinv->bind_param("i", $restoreINV);
        $restoreinv->execute();

        if (!$restoreinv->errno) {
            mysqli_commit($connect);
            header("Location: ../admin/admin-archives-inv.php");

            // log
            $logtext = 'Restored inventory record.';
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
                <p class="fw-lighter text-uppercase">Error: ' . $restoreinv->error . '</p>
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
    
//  delete inv
} else if ($_POST['deleteINV']) {
    $deleteINV = $_POST['deleteINV'];
    try {
        mysqli_begin_transaction($connect);
        
        $deleteinv = $connect->prepare("DELETE FROM admin_inventory WHERE admin_inv_id = ?");
        $deleteinv->bind_param("i", $deleteINV);
        $deleteinv->execute();

        if (!$deleteinv->errno) {
            mysqli_commit($connect);
            header("Location: ../admin/admin-archives-inv.php");
            // log
            $logtext = 'Deleted inventory record.';
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
                <p class="fw-lighter text-uppercase">Error: ' . $deleteinv->error . '</p>
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

