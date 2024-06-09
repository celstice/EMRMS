<?php 
// ADMIN: UPDATE INV RECORD interface
include '../config/connect.php';
require_once('../config/admin-inv.php');

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
} else if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['verified'] == 0) {
        header('location:../verify.php');
    }
}

if (isset($_GET['id'])) {
    $update = $_GET['id'];
    $sql = mysqli_query($connect, "SELECT * FROM admin_inventory WHERE admin_inv_id = $update");
}
$data = mysqli_fetch_array($sql);
?>

<!DOCTYPE HTML>

<html>

<?php
include '../include/head.php';
include '../include/header.php';
?>

<body class="is-preload">
    <?php  ?>

    <!-- Header -->
    <div id="header">
        <?php include '../include/profile.php'; ?>
        <hr class="text-dark w-75 m-auto">
        <div class="top">
            <!-- Nav -->
            <nav id="nav" class="menu">
                <div class="list-group list-group-flush mx-3 mt-3 mb-3">
                    <a href="admin.php" class="list-group-item py-2 ripple">
                        <i class='bx bxs-dashboard icon'></i>
                        <span class="text nav-text">Dashboard</span>
                    </a>
                    <a href="admin-jobrequest.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-toolbox icon"></i>
                        <span class="nav-text">Job Request</span>
                    </a>
                    <a href="admin-records.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-screwdriver-wrench icon"></i>
                        <span class="nav-text">Maintenance Records</span>
                    </a>
                    <a href="admin-scheduled.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-calendar icon"></i>
                        <span class="nav-text">Preventive Maintenance</span>
                    </a>
                    <a href="admin-feedbacks.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-comment-dots icon"></i>
                        <span class="nav-text">Feedbacks</span>
                    </a>
                    <a href="admin-inventory.php" class="list-group-item  py-2 ripple active-btn">
                        <i class="fa-solid fa-box-open icon"></i>
                        <span class="nav-text">Inventory</span>
                    </a>
                    <a href="admin-archives.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-box-archive icon"></i>
                        <span class="nav-text">Archives</span>
                    </a>
                    <a href="admin-logs.php" class="list-group-item  py-2 ripple">
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
            <div class="content mt-5" id="content">

                <a href="admin-inventory.php" id="back" class="fst-italic ms-3 text-decoration-none text-dark">
                    <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to previous page</span>
                </a>

                <div class="container-fluid overflow-auto pb-5">

                    <div class="content-title d-flex justify-content-center mt-3">
                        <h3>Update Inventory Details</h3>
                    </div>

                    <div class="container-fluid ps-5 pe-5">
                        <form method="post" action="" onsubmit="updateinv()">
                            <?php if (isset($errors['error'])) : ?>
                                <div class="mt-3 bg-danger bg-opacity-25 text-danger text-center rounded" id="errortext"><?= $errors['error'] ?></div>
                            <?php endif; ?>
                            <input hidden type="text" class="form-control" name="update-id" id="update-id" value="<?php echo $data['admin_inv_id']; ?>" placeholder="">
                            <div class="row">
                                <div class="col-md">

                                    <div class="col-md mb-3 mt-4">
                                        <label for="area">Area:</label>
                                        <input type="text" class="form-control shadow-sm" name="area" id="area" value="<?php echo $data['area']; ?>" placeholder="">
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <label for="floor-area">Air Conditioned Floor Area:</label>
                                        <input type="text" class="form-control shadow-sm" name="floor-area" id="floor-area" value="<?php echo $data['ac_floor_area']; ?>" placeholder="">
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <p>Type:</p>
                                        <div class="col-sm d-flex form-check ">
                                            <input type="checkbox" class="form-check-input me-2 border-dark" value="Split Type" name="typeST" <?php if ($data['type_st'] == "Split Type") {echo 'checked';} ?> placeholder=""> <label for="type-st" class="form-check-label">Split Type</label>
                                            <div class="col-sm-3"></div>
                                            <input type="checkbox" class="form-check-input me-2 border-dark" value="Window Type" name="typeWT" <?php if ($data['type_wt'] == "Window Type") {echo 'checked';} ?> placeholder=""> <label for="type-wt" class="form-check-label">Window Type</label>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <label for="status">Status:</label>
                                        <input type="text" class="form-control shadow-sm" name="status" value="<?php echo $data['status']; ?>" placeholder="">
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <p>Quantity</p>
                                        <div class="col-sm d-flex form-group">
                                            <div>
                                                <label for="split-type">Split Type:</label>
                                                <input type="text" class="form-control shadow-sm" name="qty-st" id="qty-st" value="<?php echo $data['qty_st']; ?>" placeholder="">
                                            </div>
                                            <div class="col-sm-1"></div>
                                            <div>
                                                <label for="window-type">Window Type:</label>
                                                <input type="text" class="form-control shadow-sm" name="qty-wt" id="qty-wt" value="<?php echo $data['qty_wt']; ?>" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3 mt-5">
                                        <p>Category</p>
                                        <div class="d-flex">
                                            <div class="col-sm-4 form-group">
                                                <label for="" class="form-check-label">Split Type:</label>
                                                <div class="form-check d-flex">
                                                    <input type="radio" class="form-check-input me-2 border-dark" name="categoryST" <?php if ($data['category_st'] == "INV") {echo 'checked';} ?> value="INV" placeholder=""><label for="cat-st-inv">INV</label>
                                                    <div class="col-sm-3"></div>
                                                    <input type="radio" class="form-check-input me-2 border-dark" name="categoryST" <?php if ($data['category_st'] == "N-INV") {echo 'checked';} ?> value="N-INV" placeholder=""><label for="cat-st-ninv">N-INV</label>
                                                </div>
                                            </div>
                                            <div class="col-sm-4 form-group">
                                                <label for="" class="form-check-label">Window Type:</label>
                                                <div class="form-check d-flex">
                                                    <input type="radio" class="form-check-input me-2 border-dark" name="categoryWT" <?php if ($data['category_wt'] == "INV") {echo 'checked';} ?> value="INV" placeholder=""><label for="cat-wt-inv">INV</label>
                                                    <div class="col-sm-3"></div>
                                                    <input type="radio" class="form-check-input me-2 border-dark" name="categoryWT" <?php if ($data['category_wt'] == "N-INV") {echo 'checked';} ?> value="N-INV" placeholder=""><label for="cat-wt-ninv">N-INV</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3 mt-5">
                                        <p>Nameplate Rating:</p>
                                        <div class="mt-1">
                                            <label for="cooling">Cooling Capacity (Kl/hr):</label>
                                            <input type="text" class="form-control shadow-sm" name="cooling-capacity" value="<?php echo $data['cooling_capacity']; ?>" placeholder="">
                                        </div>
                                        <div class="mt-3">
                                            <label for="rating">Capacity Rating (HR or TR):</label>
                                            <input type="text" class="form-control shadow-sm" name="capacity-rating" value="<?php echo $data['capacity_rating']; ?>" placeholder="">
                                        </div>
                                        <div class="col-sm form-group mt-3">
                                            <label>Energy Efficiency Ratio:</label>
                                            <div class="d-flex justify-content-start">
                                                <div>
                                                    <label for="nr-st">Split Type:</label>
                                                    <input type="text" class="form-control shadow-sm" name="energy-ratio-st" id="energy-ratio-st" value="<?php echo $data['energy_st']; ?>" placeholder="">
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div>
                                                    <label for="nr-wt">Window Type:</label>
                                                    <input type="text" class="form-control shadow-sm" name="energy-ratio-wt" id="energy-ratio-wt" value="<?php echo $data['energy_wt']; ?>" placeholder="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3 mt-5">
                                        <label for="year-purchase">Year of Purchase:</label>
                                        <input type="month" class="form-control shadow-sm" name="year-purchase" value="<?php echo $data['year_purchase']; ?>" placeholder="">
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <p>Operation:</p>
                                        <div class="col-sm d-flex form-group">
                                            <div>
                                                <label for="hrs-day">Hours per Day:</label>
                                                <input type="number" class="form-control shadow-sm" name="hrs-day" id="hrs-day" value="<?php echo $data['operation_hours']; ?>" placeholder="">
                                            </div>
                                            <div class="col-sm-1"></div>
                                            <div>
                                                <label for="days-week">Days per Week:</label>
                                                <input type="number" class="form-control shadow-sm" name="days-week" id="days-week" value="<?php echo $data['operation_days']; ?>" placeholder="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3">
                                        <div class="col-md btnAdd">
                                            <button type="submit" class="btn btn-warning mt-2 fsz" id="update-inv" name="update-inv">Update Equipment</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <script>
        function updateinv() {
            Swal.fire({
                title: 'Updating inventory...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.updateinv();
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