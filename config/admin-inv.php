<?php

// admin: add/update inv

include 'connect.php';

session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

$errors=[];

// add inv
if (isset($_POST['add-inv'])){
    $area = $_POST['area'];
    $floor_area = $_POST['floor-area'];
    if (isset($_POST['typeST'])){$type_st = $_POST['typeST'];} else {$type_st=null;}
    if (isset($_POST['typeWT'])){$type_wt = $_POST['typeWT'];} else {$type_wt=null;}
    $status = $_POST['status'];
    if (isset($_POST['qty-st'])){$qty_st = $_POST['qty-st'];} else {$qty_st=null;}
    if (isset($_POST['qty-wt'])){$qty_wt = $_POST['qty-wt'];} else {$qty_wt=null;}
    if (isset($_POST['categoryST'])){$category_st = $_POST['categoryST'];} else {$category_st=null;}
    if (isset($_POST['categoryWT'])){$category_wt = $_POST['categoryWT'];} else {$category_wt=null;}
    $cooling_capacity = $_POST['cooling-capacity'];
    $capacity_rating = $_POST['capacity-rating'];
    if (isset($_POST['energy-ratio-st'])){$energy_st = $_POST['energy-ratio-st'];} else {$energy_st=null;}
    if (isset($_POST['energy-ratio-wt'])){$energy_wt = $_POST['energy-ratio-wt'];} else {$energy_wt=null;}
    if (isset($_POST['year-purchase'])){$year_purchase = $_POST['year-purchase'];} else {$year_purchase=null;}
    $hrs_day = $_POST['hrs-day'];
    $days_week = $_POST['days-week'];


        if (empty($area)) {
            $errors['area'] = "Empty field."; 
        }

        if (empty($floor_area)) {
            $errors['floor_area'] = "Empty field.";
        } 

        if (empty($type_st) && empty($type_wt)) {
                $errors['type'] = "Choose type.";
        }

        if (empty($status)) {
            $errors['status'] = "Empty field."; 
        }

        if (empty($qty_st) && empty($qty_wt)) {
            $errors['quantity'] = "Enter quantity.";
        }

        if (empty($category_st) && empty($category_wt)) {
            $errors['category'] = "Choose category."; 
        }

        if (empty($cooling_capacity)) {
            $errors['cooling'] = "Empty field."; 
        }

        if (empty($capacity_rating)) {
            $errors['rating'] = "Empty field."; 
        }

        if (empty($energy_st) && empty($energy_wt)) {
            $errors['energy'] = "Empty field.";
        }

        if (empty($hrs_day)) {
            $errors['hours'] = "Empty field."; 
        } 

        if (empty($days_week)) {
            $errors['days'] = "Empty field."; 
        } 

    if (count($errors)==0){

        try {
            mysqli_begin_transaction($connect);
        $sql = "INSERT INTO admin_inventory (
            area,
            ac_floor_area,
            type_st,
            type_wt,
            status,
            qty_st,
            qty_wt,
            category_st,
            category_wt,
            cooling_capacity,
            capacity_rating,
            energy_st,
            energy_wt,
            year_purchase,
            operation_hours,
            operation_days
        ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

            $addINV = $connect->prepare($sql);
            $addINV->bind_param("sssssiisssssssss", 
            $area,
            $floor_area,
            $type_st,
            $type_wt,
            $status,
            $qty_st,
            $qty_wt,
            $category_st,
            $category_wt,
            $cooling_capacity,
            $capacity_rating,
            $energy_st,
            $energy_wt,
            $year_purchase,
            $hrs_day,
            $days_week
            );
            $addINV->execute();

            if (!$addINV->errno) {
                mysqli_commit($connect);
                header("Location: ../admin/admin-inventory.php");

                // log
                $logtext = 'Added inventory record.';
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
                            <p class="fw-lighter text-uppercase">Error: ' . $addINV->error . '</p>
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

} else if (isset($_POST['update-inv'])) {
    
    $id =  $_POST['update-id'];
    $area =  $_POST['area'];
    $floor_area =  $_POST['floor-area'];
    if (isset($_POST['typeST'])) { $type_st =  $_POST['typeST'];} else {$type_st=null;}
    if (isset($_POST['typeWT'])) { $type_wt =  $_POST['typeWT'];} else {$type_wt=null;}
    $status =  $_POST['status'];
    if (isset($_POST['qty-st'])){$qty_st = $_POST['qty-st'];} else {$qty_st=null;}
    if (isset($_POST['qty-wt'])){$qty_wt = $_POST['qty-wt'];} else {$qty_wt=null;}
    if (isset($_POST['categoryST'])) { $category_st =  $_POST['categoryST'];} else {$category_st=null;}
    if (isset($_POST['categoryWT'])) { $category_wt =  $_POST['categoryWT'];} else {$category_wt=null;}
    $cooling_capacity =  $_POST['cooling-capacity'];
    $capacity_rating =  $_POST['capacity-rating'];
    if (isset($_POST['energy-ratio-st'])){$energy_st = $_POST['energy-ratio-st'];} else {$energy_st=null;}
    if (isset($_POST['energy-ratio-wt'])){$energy_wt = $_POST['energy-ratio-wt'];} else {$energy_wt=null;}
    if (isset($_POST['year-purchase'])){$year_purchase = $_POST['year-purchase'];} else {$year_purchase=null;}
    $hrs_day =  $_POST['hrs-day'];
    $days_week =  $_POST['days-week'];

    try {
        mysqli_begin_transaction($connect);

        $sql = "UPDATE admin_inventory SET
        area =?,
        ac_floor_area =?,
        type_st = ?,
        type_wt = ?,
        status = ?,
        qty_st = ?,
        qty_wt = ?,
        category_st = ?,
        category_wt = ?,
        cooling_capacity = ?,
        capacity_rating = ?,
        energy_st = ?,
        energy_wt = ?,
        year_purchase = ?,
        operation_hours = ?,
        operation_days = ?
        
        WHERE admin_inv_id = ?";

        $updateINV = $connect->prepare($sql);
        $updateINV->bind_param("sssssiisssssssssi",
                    $area,
                    $floor_area,
                    $type_st,
                    $type_wt,
                    $status,
                    $qty_st,
                    $qty_wt,
                    $category_st,
                    $category_wt,
                    $cooling_capacity,
                    $capacity_rating,
                    $energy_st,
                    $energy_wt,
                    $year_purchase,
                    $hrs_day,
                    $days_week,
                    $id);
        $updateINV->execute();

        if (!$updateINV->errno) {
            mysqli_commit($connect);
            header("Location: ../admin/admin-inventory.php");

            // log
            $logtext = 'Updated inventory record.';
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
                            <p class="fw-lighter text-uppercase">Error: ' . $updateINV->error . '</p>
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