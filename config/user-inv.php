<?php
include 'connect.php';

session_start();
$user = $_SESSION['user']['userID'];
date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");
$errors=[]; 
if (isset($_POST['add-inv'])){
    $item = $_POST['inv-item'];
    $p_number = $_POST['property-number'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $total = $_POST['total'];
    $unit = $_POST['unit'];
    $location =  $_POST['location'];
    $date = $_POST['date-acquired'];
    $person = $_POST['person'];
    $description = $_POST['description'];
    $remarks = $_POST['remarks'];

    if (empty($item)) {
        $errors['item'] = "This field is required.";
    }

    if (empty($p_number)) {
        $errors['pnumber'] = "This field is required.";
    }

    if (empty($quantity)) {
        $errors['qty'] = "This field is required.";
    }

    if (empty($unit)) {
        $errors['unit'] = "This field is required.";
    }

    if (empty($price)) {
        $errors['price'] = "This field is required.";
    }

    if (empty($total)) {
        $errors['total'] = "This field is required.";
    }

    if (empty($date)) {
        $errors['dateacquired'] = "This field is required.";
    }

    if (empty($location)) {
        $errors['location'] = "This field is required.";
    }

    if (empty($person)) {
        $errors['person'] = "This field is required.";
    }

    if (empty($description)) {
        $errors['desc'] = "This field is required.";
    }

    if (count($errors) <= 0) {
    
        try {
            mysqli_begin_transaction($connect);
        
            $insert = "INSERT INTO user_inventory (userID,inv_item,property_number,quantity,price,total,unit,area_location,person,description,remarks,date_acquired) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

            $add = $connect->prepare($insert);
            $add->bind_param("ississssssss", $user, $item, $p_number, $quantity, $price, $total, $unit, $location, $person, $description, $remarks, $date);
            $add->execute();

            if (!$add->errno) {
                mysqli_commit($connect);
                echo "<script>window.location.href='../user/user-inventory.php'</script>";

                // log
                $logtext = 'Add inventory record.';
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
                            <p class="fw-lighter text-uppercase">Error: ' . $add->error . '</p>
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
    } else {
        $errors['error'] = "Please answer all the fields.";;
    }

}

else if (isset($_POST['update-inv'])){
    $id = $_POST['update-id'];
    $update_item = $_POST['update-item'];
    $update_pnumber = $_POST['update-pnumber'];
    $update_quantity = $_POST['update-quantity'];
    $update_price = $_POST['update-price'];
    $update_total = $_POST['update-total'];
    $update_unit = $_POST['update-unit'];
    $update_location = $_POST['update-location'];
    $update_date = $_POST['update-date'];
    $update_person = $_POST['update-person'];
    $update_description = $_POST['update-description'];
    $update_remarks = $_POST['update-remarks'];

    try{
        mysqli_begin_transaction($connect);
            $edit = "UPDATE user_inventory SET 
            inv_item = ?,
            property_number=?, 
            quantity = ?,
            price = ?,
            total = ?,
            unit = ?,
            area_location = ?,
            person = ?,
            description = ?,
            remarks = ?,
            date_acquired = ?
            WHERE inv_id = ?";

        // $update = mysqli_query($connect,$edit);
        $update = $connect->prepare($edit);
        $update->bind_param("ssissssssssi", 
                            $update_item,
                            $update_pnumber, 
                            $update_quantity,
                            $update_price,
                            $update_total,
                            $update_unit,
                            $update_location,
                            $update_person,
                            $update_description,
                            $update_remarks,
                            $update_date,
                            $id);
        $update->execute();
    
        if (!$update->errno) {
            mysqli_commit($connect);

            echo "<script>window.location.href='../user/user-inventory.php'</script>";

            $logtext = 'Update inventory record.';
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
