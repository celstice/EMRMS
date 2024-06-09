<?php 
// USER: UPDATE INV
include '../config/connect.php';
require_once('../config/user-inv.php');

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
} else if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['verified'] == 0) {
        header('location:../verify.php');
    }
}

$user = $_SESSION['user']['userID'];
if (isset($_GET['id'])) {
    $update = $_GET['id'];
    $sql = mysqli_query($connect, "SELECT * FROM user_inventory WHERE inv_id = $update");
}
$row = mysqli_fetch_array($sql);
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
                    <a href="user-records.php" class="list-group-item  py-2 ripple">
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
            <div id="content" class="content mt-5">
                
                <a href="user-inventory.php" id="back" class="fst-italic ms-3 text-decoration-none text-dark">
                    <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to previous page</span>
                </a>
                <div class="container-fluid overflow-auto pb-5">

                    <div class="content-title d-flex justify-content-center m-">
                        <h2>Update inventory record</h2>
                    </div>

                    <div class="container ps-5 pe-5 pb-5">

                        <form method="post" action="" onsubmit="updateInv()">
                            <?php if (isset($errors['error'])) : ?>
                                <div class="mt-3 bg-danger bg-opacity-25 text-danger text-center rounded" id="errortext"><?= $errors['error'] ?></div>
                            <?php endif; ?>
                            <div class="row mb-3">
                                <input hidden name="update-id" value="<?php echo $row['inv_id']; ?>">
                                <div class="col-md mb-3">
                                    <label for="update-item">Item:</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control me- shadow-sm" name="update-item" id="update-item" value="<?php echo $row['inv_item']; ?>" placeholder="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="update-pnumber">Property Number:</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control me- shadow-sm" name="update-pnumber" id="update-pnumber" value="<?php echo $row['property_number']; ?>" placeholder="" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="update-quantity">Quantity:</label>
                                    <div class="d-flex">
                                        <input type="number" class="form-control m-1 shadow-sm" name="update-quantity" value="<?php echo $row['quantity']; ?>" id="update-quantity" required>
                                    </div>
                                </div>

                                <div class="col-md mb-3">
                                    <label for="update-unit">Unit:</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control m-1 shadow-sm" name="update-unit" value="<?php echo $row['unit']; ?>" id="update-unit" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="update-price">Price:</label>
                                    <div class="d-flex">
                                        <input type="number" class="form-control m-1 shadow-sm" step=".01" name="update-price" id="update-price" value="<?php echo $row['price']; ?>" required>
                                    </div>
                                </div>

                                <div class="col-md mb-3">
                                    <label for="update-total">Total:</label>
                                    <div class="d-flex">
                                        <input type="number" class="form-control m-1 shadow-sm" step=".01" name="update-total" id="update-total" value="<?php echo $row['total']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="update-date">Date Acquired:</label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control m-1 shadow-sm" name="update-date" id="update-date" value="<?php echo $row['date_acquired']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="update-location">Location:</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control m-1 shadow-sm" name="update-location" id="update-location" value="<?php echo $row['area_location']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="update-person">Person Responsible for the Equipment:</label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control m-1 shadow-sm" name="update-person" id="update-person" value="<?php echo $row['person']; ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="update-description">Descrition:</label>
                                    <div class="d-flex">
                                        <textarea rows="2" type="text" class="form-control shadow-sm" name="update-description" required><?php echo $row['description']; ?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="update-remarks">Remarks:</label>
                                    <div class="d-flex">
                                        <textarea rows="2" type="text" class="form-control shadow-sm" name="update-remarks"><?php echo $row['remarks']; ?></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md mb-2 d-flex justify-content-center">
                                    <button type="submit" name="update-inv" id="update-inv" class="btn btn-warning fsz">Update Inventory Record</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <script>
        function updateInv() {
            Swal.fire({
                title: 'Updating inventory...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.updateInv();
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