<?php
include 'connect.php';

// session_start();
$user = $_SESSION['user']['userID'];

date_default_timezone_set('Asia/Manila');
mysqli_query($connect, "SET time_zone = '+08:00'");

$errors=[];

// add equipment record
if (isset($_POST['add-equipment'])){
    
    $name = $_POST['name'];
    $model = $_POST['model'];
    $brand_label = $_POST['brand-label'];
    $property_number = $_POST['property-number'];
    $location = $_POST['location'];
    $date_service = $_POST['date-service'];
    $assigned = $_POST['assigned'];
    $date_purchased = $_POST['date-purchased'];
    $price = $_POST['price'];
    $remarks = $_POST['remarks'];

    //equipment name
    if (empty($name)) {
        $errors['equipname'] = "This field is required.";
    }

    //equipment category
    if (empty($_POST['selectCategory'])) {
        $errors['category'] = "Select category";
    } else {
        $category =  $_POST['selectCategory'];
    }

    //equipment model
    if (empty($model)) {
        $errors['equipmodel'] = "This field is required.";
    }

    //equipment brand
    if (empty($brand_label)) {
        $errors['equipbrand'] = "This field is required.";
    }

    //property number
    if (empty($property_number)) {
        $errors['pnumber'] = "This field is required.";
    }

    //location
    if (empty($location)) {
        $errors['location'] = "This field is required.";
    }

    //equipment status
    if (empty($_POST['status'])) {
        $errors['status'] = "Select status";
    } else {
        $status =  $_POST['status'];
    }

    //date service
    if (empty($date_service)) {
        $errors['dateservice'] = "This field is required.";
    }

    //assigned person
    if (empty($assigned)) {
        $errors['person'] = "This field is required.";
    }

    //date purchased
    if (empty($date_purchased)) {
        $errors['datepurchase'] = "This field is required.";
    }

    //price
    if (empty($price)) {
        $errors['price'] = "This field is required.";
    }

    if (count($errors) <= 0) {
    
    try{
    mysqli_begin_transaction($connect);
        $sqladd = "INSERT INTO equipments (
            userID,
            equip_name,
            category,
            equip_model,
            brand_label,
            property_number,
            equip_location,
            equip_status,
            date_service,
            assigned_person,
            date_purchased,
            price,
            notes_remarks

            ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $add = $connect->prepare($sqladd);
    $add->bind_param("issssssssssss",$user,$name,$category,$model,$brand_label,$property_number,$location,$status,$date_service,$assigned,$date_purchased,$price,$remarks);
    $add->execute();
    $insert_id = mysqli_insert_id($connect);
    
        if (!$add->errno){
            mysqli_commit($connect);
            echo "<script>window.location.href='../user/user-records.php'</script>";

            // log
            $logtext = 'Add equipment record.';
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
        $errors['error'] = "Please answer all the fields.";
    }

// update equipment record
} else if (isset($_POST['update-equipment'])){
    $update_id = $_POST['update-id'];
    $name = $_POST['name'];
    $category = $_POST['category'];
    $model = $_POST['model'];
    $brand_label = $_POST['brand-label'];
    $property_number = $_POST['property-number'];
    $location = $_POST['location'];
    $status = $_POST['status'];
    $date_service = $_POST['date-service'];
    $assigned = $_POST['assigned'];
    $date_purchased = $_POST['date-purchased'];
    $price = $_POST['price'];
    $remarks =  $_POST['remarks'];

    try{
        mysqli_begin_transaction($connect);

        $sqlupdate = "UPDATE equipments SET 
        equip_name = ?,
        category = ?,
        equip_model = ?,
        brand_label = ?,
        property_number = ?,
        equip_location = ?,
        equip_status = ?,
        date_service = ?,
        assigned_person = ?,
        date_purchased = ?,
        price = ?,
        notes_remarks = ?
        WHERE equipment_id =?";

        $update = $connect->prepare($sqlupdate);
        $update->bind_param("ssssssssssssi", 
                            $name, 
                            $category, 
                            $model, 
                            $brand_label, 
                            $property_number, 
                            $location, 
                            $status, 
                            $date_service, 
                            $assigned, 
                            $date_purchased, 
                            $price, 
                            $remarks,
                            $update_id);
        $update->execute();

        if (!$update->errno) {
            mysqli_commit($connect);
            echo "<script>window.location.href='../user/equipment-record.php?id=" . $update_id . "'</script>";

            // log
            $logtext = 'Update equipment record.';
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

// add last maintenance date
// equipment-record.php line 204-240
} else if(isset($_POST['add-last'])){
    session_start();
    $id =  $_POST['eq-id'];
    $last =  $_POST['last'];

    try {
        mysqli_begin_transaction($connect);
        $addlast=$connect->prepare("UPDATE maintenance_records SET last_mnt=? WHERE equipment_id=?");
        $addlast->bind_param("si",$last,$id);
        $addlast->execute();

        if (!$addlast->errno) {
            mysqli_commit($connect);
            echo "<script>window.location.href='../user/equipment-record.php?id=" . $id . "'</script>";
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

}
?>
