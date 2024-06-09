<?php
// USER: ADD EQUIPMENT RECORD
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
?>

<!DOCTYPE HTML>

<html>

<?php
include '../include/head.php';
include '../include/header.php';
?>

<body class="is-preloadd">
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
            <div id="content" class="content mt-5">

                <a href="user-records.php" id="back" class="fst-italic ms-3 text-decoration-none text-dark">
                    <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to previous page</span>
                </a>

                <div class="container overflow-auto pt-3 pb-5">

                    <div class="content-title d-flex justify-content-start">
                        <h5 class="text-uppercase fw-bold">Add equipment record</h5>
                    </div>
                    <div class="d-flex justify-content-center mt-3 mb-3">
                        <span class="mb-2 h6 text-uppercase fst-italic">Equipment Information</span>
                    </div>
                    <div class="container ps-3 pe-3">
                        <form method="post" action="" onsubmit="loading()">
                            <?php if (isset($errors['error'])) : ?>
                                <div class="mt-3 mb-3 bg-danger bg-opacity-25 text-danger text-center rounded" id="errortext"><?= $errors['error'] ?></div>
                            <?php endif; ?>

                            <div class="row">
                                <div class="col-md mb-3">
                                    <label for="name">Equipment Name:<span class="text-danger">*</span><?php if (isset($errors['equipname'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['equipname'] ?></span>
                                        <?php endif; ?>
                                    </label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control me- shadow-sm" name="name" id="name" placeholder="PC #1, Printer #1, etc." autofocus value="<?= htmlspecialchars($_POST['name'] ?? "") ?>" placeholder="">
                                    </div>
                                </div>
                            </div>

                            <div class="row pt-3">
                                <div class="col-md mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <label for="category">Category:<span class="text-danger">*</span><?php if (isset($errors['category'])) : ?>
                                                <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['category'] ?></span>
                                            <?php endif; ?></label>
                                        <!-- CATEGORY BUTTON -->
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#category">Add New Category</button>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <select name="selectCategory" id="selectCategory" class="form-select selectCategory" required></select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md mb-3">
                                    <label for="model">Equipment Model:<span class="text-danger">*</span><?php if (isset($errors['equipmodel'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['equipmodel'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control shadow-sm" name="model" id="model" placeholder="MacBook Air M2, Acer-Aspire5, etc." autofocus value="<?= htmlspecialchars($_POST['model'] ?? "") ?>">
                                    </div>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="brand-label">Brand / Label:<span class="text-danger">*</span><?php if (isset($errors['equipbrand'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['equipbrand'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control shadow-sm" name="brand-label" id="brand-label" placeholder="ACER, Apple, ASUS etc." autofocus value="<?= htmlspecialchars($_POST['brand-label'] ?? "") ?>">
                                    </div>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="serial-number">Property Number:<span class="text-danger">*</span><?php if (isset($errors['pnumber'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['pnumber'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control shadow-sm" name="property-number" id="property-number" placeholder="Enter property number" autofocus value="<?= htmlspecialchars($_POST['property-number'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md mb-3">
                                    <label for="location">Location:<span class="text-danger">*</span><?php if (isset($errors['location'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['location'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control shadow-sm" name="location" id="location" placeholder="Faculty Office, Room 404, etc." autofocus value="<?= htmlspecialchars($_POST['location'] ?? "") ?>">
                                    </div>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="status">Status:<span class="text-danger">*</span><?php if (isset($errors['status'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['status'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <select name="status" id="status" class="form-select" placeholder="..." required>
                                            <option disabled selected class="fst-italic text-secondary text-muted">Select status</option>
                                            <option autofocus value="Operational" <?= htmlspecialchars($_POST['status'] ?? '') === 'Operational' ? ' selected' : '' ?>>Operational</option>
                                            <option autofocus value="Non-Operational" <?= htmlspecialchars($_POST['status'] ?? '') === 'Non-Operational' ? ' selected' : '' ?>>Non-Operational</option>
                                            <option autofocus value="For Repair" <?= htmlspecialchars($_POST['status'] ?? '') === 'For Repair' ? ' selected' : '' ?>>For Repair</option>
                                            <option autofocus value="Condemn" <?= htmlspecialchars($_POST['status'] ?? '') === 'Condemn' ? ' selected' : '' ?>>Condemn</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md mb-3">
                                    <label for="date-service">Date put into Service:<span class="text-danger">*</span><?php if (isset($errors['dateservice'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['dateservice'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control shadow-sm" name="date-service" id="date-service" autofocus value="<?= htmlspecialchars($_POST['date-service'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md mb-3">
                                    <label for="assigned">Person Responsible for the Equipment:<span class="text-danger">*</span><?php if (isset($errors['person'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['person'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="text" class="form-control shadow-sm" name="assigned" id="assigned" placeholder="Enter name" autofocus value="<?= htmlspecialchars($_POST['assigned'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="d-flex justify-content-center mb-3 mt-3">
                                    <span class="mb-2 h6 text-uppercase fst-italic">Purchase Details</span>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="date-purchase">Date Purchased:<span class="text-danger">*</span><?php if (isset($errors['datepurchase'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['datepurchase'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control shadow-sm" name="date-purchased" id="date-purchased" autofocus value="<?= htmlspecialchars($_POST['date-purchased'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md mb-3">
                                    <label for="price">Price:<span class="text-danger">*</span><?php if (isset($errors['price'])) : ?>
                                            <span class="m-0 p-0 bg-transparent text-danger text-center rounded" id="errortext"><?= $errors['price'] ?></span>
                                        <?php endif; ?></label>
                                    <div class="d-flex">
                                        <input type="number" class="form-control shadow-sm" name="price" id="price" step=".01" placeholder="Enter price" autofocus value="<?= htmlspecialchars($_POST['price'] ?? "") ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-5">
                                <div class="mb-3">
                                    <label for="warranty" class="fst-italic">Remarks (optional):</label>
                                    <div class="d-flex">
                                        <textarea rows="2" name="remarks" id="remarks" placeholder="Equipment remarks..." class="form-control me-1 shadow-sm"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md mt-2 mb-2 d-flex justify-content-center">
                                    <button type="submit" name="add-equipment" id="add-equipment" class="btn btn-warning fw-bold text-uppercase">Add Equipment</button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <!-- CATEGORY MODAL -->
    <div class="modal fade" id="category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header text-dark">
                    <h5 class="modal-title text-uppercase fw-bold mb-0">New Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="m-3">
                    <label class="m-1">Category:</label>
                    <input type="text" name="ctg" id="ctg" class="form-control mb-3 col-sm" value="" required>
                    <div class="d-flex justify-content-center align-items-center">
                        <button type="button" class="btn btn-secondary bg-opacity-50" id="addCategory" name="addCategory">Add Category</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- CATEGORY MODAL end -->

    <script>
        function loadCategories() {
            $.ajax({
                url: "../config/load-categories.php",
                type: "GET",
                success: function(data) {
                    $("#selectCategory").html(data);
                },
                error: function(error) {
                    console.error("Error loading categories:", error);
                }
            });
        }

        function loading() {
            Swal.fire({
                title: 'Adding Equipment...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.loading();
                },
            });
        }

        function hideLoading() {
            Swal.close();
        }

        $(document).ready(function() {
            loadCategories();
           
            $("#addCategory").click(function() {
                var category = $("#ctg").val();

                if (category !== "") {
                    $.ajax({
                        url: "../config/add-category.php",
                        type: "POST",
                        data: {
                            ctg: category
                        },
                        success: function(response) {
                           
                            Swal.close();
                            Swal.fire({
                                title: "Success!",
                                text: "Category added successfully.",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1000,

                            });

                            $("#ctg").val("");
                            loadCategories();
                        },
                        error: function(error) {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while adding the category.",
                                icon: "error",
                            });
                        },
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "Enter category.",
                        icon: "error",
                    });
                }
            });
            
        });
    </script>

    <?php include '../include/scripts.php'; ?>

</body>

</html>