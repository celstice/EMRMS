<?php

// Add schedule | Preventive maintenance program

include 'connect.php';

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

if (isset($_POST['scheduled'])){
    $quarter = $_POST['quarter'];
    $sched_location = $_POST['sched-location'];
    $rac_window = $_POST['rac-window'];
    $rac_split = $_POST['rac-split'];
    $ref_freezer = $_POST['ref-freezer'];
    $car_aircon = $_POST['car-aircon'];
    $electric_fan = $_POST['electric-fan'];
    $computer_unit = $_POST['computer-unit'];
    $type_writer = $_POST['type-writer'];
    $dispenser = $_POST['dispenser'];
    $lab_equipment = $_POST['lab-equipment'];
    $others = $_POST['others'];

    try{
    mysqli_begin_transaction($connect);
$sql = "INSERT INTO scheduled (
    quarter,
    sched_location,
    rac_window_type,
    rac_split_type,
    ref_freezer,
    car_aircon,
    electric_fan,
    computer_unit,
    type_writer,
    dispenser,
    lab_equipment,
    others
    ) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("isiiiiiiiiii", 
            $quarter, 
            $sched_location,
            $rac_window,
            $rac_split,
            $ref_freezer,
            $car_aircon,
            $electric_fan,
            $computer_unit,
            $type_writer,
            $dispenser,
            $lab_equipment,
            $others
        );
        $stmt->execute();
        
        if (!$stmt->errno) {
            mysqli_commit($connect);
            header("Location: ../admin/admin-scheduled.php");
        } else {
            mysqli_rollback($connect);
            echo '<div class="container h-100 w-100 d-flex flex-column justify-content-center align-items-center p-5">';
            echo '<div class="m-3">
                <h5 class="fw-lighter text-uppercase">An error occurred. Please try again later or contact support.</h5>
            </div>';
            echo '<div class="m-3">
                <p class="fw-lighter text-uppercase">Error: ' . $stmt->error . '</p>
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