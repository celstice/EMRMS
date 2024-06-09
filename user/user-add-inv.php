<?php 
// USER: ADD INV
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
                    <a href="user-inventory.php" class="list-group-item  py-2 ripple active-btn">
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
                        <h2>Add inventory record</h2>
                    </div>

                    <div class="container ps-5 pe-5 pb-5">
                        <form method="post" action="" onsubmit="addInv()">
                            <?php if (isset($errors['error'])) : ?>
                                <div class="mt-3 bg-danger bg-opacity-25 text-danger text-center rounded" id="errortext"><?= $errors['error'] ?></div>
                            <?php endif; ?>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="name">Item:<span class="text-danger">*</span><?php if (isset($errors['item'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['item'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control me- shadow-sm" name="inv-item" id="inv-item" placeholder="PC #1, Printer #1, etc." autofocus value="<?= htmlspecialchars($_POST['inv-item'] ?? "") ?>" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="property-number">Property Number:<span class="text-danger">*</span><?php if (isset($errors['pnumber'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['pnumber'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control me- shadow-sm" name="property-number" id="property-number" placeholder="Enter property number" autofocus value="<?= htmlspecialchars($_POST['property-number'] ?? "") ?>" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="quantity">Quantity:<span class="text-danger">*</span><?php if (isset($errors['qty'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['qty'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="number" class="form-control m-1 shadow-sm" name="quantity" id="quantity" placeholder="Enter quantity" autofocus value="<?= htmlspecialchars($_POST['quantity'] ?? "") ?>">
                                    </div>
                                </div>

                                <div class="col-md mb-3">
                                    <label for="unit">Unit:<?php if (isset($errors['unit'])) : ?>
                                        <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['unit'] ?></span>
                                    <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control m-1 shadow-sm" name="unit" id="unit" placeholder="Set, 1 unit, etc." autofocus value="<?= htmlspecialchars($_POST['unit'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="price">Price:<?php if (isset($errors['price'])) : ?>
                                        <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['price'] ?></span>
                                    <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="number" step=".01" class="form-control m-1 shadow-sm" name="price" placeholder="Enter price" id="price" autofocus value="<?= htmlspecialchars($_POST['price'] ?? "") ?>">
                                    </div>
                                </div>

                                <div class="col-md mb-3">
                                    <label for="total">Total:<?php if (isset($errors['total'])) : ?>
                                        <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['total'] ?></span>
                                    <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="number" step=".01" class="form-control m-1 shadow-sm" name="total" placeholder="Total price of unit or quantity " id="total" autofocus value="<?= htmlspecialchars($_POST['total'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="date-acquired">Date Acquired:<?php if (isset($errors['dateacquired'])) : ?>
                                        <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['dateacquired'] ?></span>
                                    <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control m-1 shadow-sm" name="date-acquired" autofocus value="<?= htmlspecialchars($_POST['date-acquired'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="location">Location:<span class="text-danger">*</span><?php if (isset($errors['location'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['location'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control m-1 shadow-sm" name="location" id="location" placeholder="Faculty Office, Room 404, etc" autofocus value="<?= htmlspecialchars($_POST['location'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="person">Person Responsible for the Equipment:<?php if (isset($errors['person'])) : ?>
                                        <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['person'] ?></span>
                                    <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control m-1 shadow-sm" name="person" id="person" placeholder="Enter Name" autofocus value="<?= htmlspecialchars($_POST['person'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="description">Description:<?php if (isset($errors['desc'])) : ?>
                                        <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['desc'] ?></span>
                                    <?php endif; ?></label>
                                    <div class="d-flex">
                                        <textarea rows="2" type="text" class="form-control shadow-sm" name="description" placeholder="Equipment description..." autofocus value="<?= htmlspecialchars($_POST['description'] ?? "") ?>"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md mb-3">
                                    <label for="remarks">Remarks(Optional):</label>
                                    <div class="d-flex">
                                        <textarea rows="2" type="text" class="form-control shadow-sm" name="remarks" placeholder="Equipment remarks..." autofocus value="<?= htmlspecialchars($_POST['remarks'] ?? "") ?>"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md mb-2 d-flex justify-content-center">
                                    <button type="submit" name="add-inv" id="add-inv" class="btn btn-warning fsz">Add Inventory Record</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <script>
        function addInv() {
            Swal.fire({
                title: 'Adding inventory...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.addInv();
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