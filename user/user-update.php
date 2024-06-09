<?php  
// UPDATE EQUIPMENT RECORD
include '../config/connect.php';
session_start();
require_once('../config/e-records.php');

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
} else if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['verified'] == 0) {
        header('location:../verify.php');
    }
}

$user = $_SESSION['user']['userID'];

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = mysqli_query($connect, "SELECT * FROM equipments WHERE equipment_id = $id");
}
$data = mysqli_fetch_array($sql);

?>

<!DOCTYPE HTML>

<html>

<?php
include '../include/head.php';
include '../include/header.php';
?>

<body class="is-preloadd">
    <?php  ?>

    <!-- Header -->
    <div id="header">
        <?php include '../include/profile.php'; ?>
        <hr class="text-dark w-75 m-auto">
        <div class="top">
            <!-- Nav -->
            <nav id="nav" class="menu">
                <div class="list-group list-group-flush mx-3 mt-3">
                    <a href="user-index.php" class="list-group-item  py-2 ripple">
                        <i class='bx bxs-dashboard icon'></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                    <a href="user-jobrequest.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-toolbox icon"></i>
                        <span class="nav-text">Job Request</span>
                    </a>
                    <a href="user-records.php" class="list-group-item  py-2 ripple active-btn">
                        <i class="fa-solid fa-folder icon"></i>
                        <span class="nav-text">Equipment Records</span>
                    </a>
                    <a href="user-notice.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-snowflake icon"></i>
                        <span class="nav-text">Aircon Maintenance</span>
                    </a>
                    <a href="user-inventory.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-box-open icon"></i>
                        <span class="nav-text">Inventory</span>
                    </a>
                    <a href="user-archives.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-box-archive icon"></i>
                        <span class="nav-text">Archives</span>
                    </a>
                    <a href="user-logs.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-clock-rotate-left icon"></i>
                        <span class="nav-text">Logs</span>
                    </a>
                </div>
            </nav>
        </div>

        <?php include '../include/logout-div.php'; ?>

    </div>


    <!-- Main -->
    <div id="main">
        <section id="" class="">
            <div id="content" class="content mt-5 mb-5">
                
                <a href="user-records.php" id="back" class="fst-italic ms-3 text-decoration-none text-dark">
                    <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to previous page</span>
                </a>
                
                <div class="container overflow-auto pt-3 pb-5">
                    <div class="container ps-3 pe-3">
                        <h5 class="mb-4 text-uppercase fw-bold">Edit Equipment Information</h5>
                        <form method="post" action="" onsubmit="updating()">
                            <?php if (isset($errors['error'])) : ?>
                                <div class="mt-2 mb-2 bg-danger bg-opacity-25 text-danger text-center rounded" id="errortext"><?= $errors['error'] ?></div>
                            <?php endif; ?>
                            <input hidden type="text" name="update-id" class="form-control" value="<?php echo $data['equipment_id']; ?>">

                            <table class=" mb-5 border">
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Name of equipment / device:</td>
                                    <td><input type="text" name="name" class="form-control" value="<?php echo $data['equip_name']; ?>" required></td>
                                </tr>
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Category:</td>
                                    <td>
                                        <select name="category" id="category" class="form-select selectCategory" value="" required>
                                            <option selected><?php echo $data['category']; ?></option>
                                            <?php
                                            $sql = mysqli_query($connect, "SELECT * FROM category");
                                            while ($row = mysqli_fetch_assoc($sql)) { ?>
                                                <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option><br>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Equipment Model:</td>
                                    <td><input type="text" name="model" class="form-control" value="<?php echo $data['equip_model']; ?>" required></td>
                                </tr>
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Brand / Label:</td>
                                    <td><input type="text" name="brand-label" class="form-control" value="<?php echo $data['brand_label']; ?>" required></td>
                                </tr>
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Property Number:</td>
                                    <td><input type="text" name="property-number" class="form-control" value="<?php echo $data['property_number']; ?>" required></td>
                                </tr>
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Location:</td>
                                    <td><input type="text" name="location" class="form-control" value="<?php echo $data['equip_location']; ?>" required></td>
                                </tr>
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Status:</td>
                                    <td>
                                        <select name="status" id="status" class="form-select selectCategory" value="" required>
                                            <option selected><?php echo $data['equip_status']; ?></option>
                                            <option value="Operational">Operational</option>
                                            <option value="Non-Operational">Non-Operational</option>
                                            <option value="For Repair">For Repair</option>
                                            <option value="Condemn">Condemn</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Date put into Service:</td>
                                    <td><input type="date" name="date-service" class="form-control" value="<?php echo $data['date_service']; ?>" required></td>
                                </tr>
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Person Responsible for the Equipment:</td>
                                    <td><input type="text" name="assigned" class="form-control" value="<?php echo $data['assigned_person']; ?>" required></td>
                                </tr>
                            </table>

                            <h5 class="mb-3">Purchase Details</h5>
                            <table class="mb-5 border">
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Date Purchased:</td>
                                    <td><input type="date" name="date-purchased" class="form-control" value="<?php echo $data['date_purchased']; ?>" required></td>
                                </tr>
                                <tr class="border">
                                    <td scope="col" class="col-5 border">Price:</td>
                                    <td><input type="number" name="price" class="form-control" value="<?php echo $data['price']; ?>" required></td>
                                </tr>
                            </table>

                            <div class="row mb-3">
                                <label for="remarks" class="fst-italic">Remarks:</label>
                                <div class="d-flex">
                                    <textarea rows="2" name="remarks" id="remarks" class="form-control me-1 shadow-sm" value=""><?php echo $data['notes_remarks']; ?></textarea>
                                </div>
                            </div>

                            <div class="d-flex justify-content-center pb-5">
                                <button type="submit" name="update-equipment" id="update-equipment" class="btn btn-primary fsz">Save</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </section>
    </div>

    <script>
        function updating() {
            Swal.fire({
                title: 'Updating Equipment...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.updating();
                },
            });
        }

        function hideLoading() {
            Swal.close();
        }
    </script>

    <?php include '../include/scripts.php'; ?>

</body>

</html>