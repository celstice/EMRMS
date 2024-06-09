<?php
// ADMIN: ADDING INV RECORD Interface
include '../config/connect.php';
require_once('../config/admin-inv.php');

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
} else if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['verified'] == 0) {
        header('location:../verify.php');
    }
}
?>

<!DOCTYPE HTML>

<html>

<?php
include '../include/head.php';
include '../include/header.php';
?>

<body class="is-preload">

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
            <div class="content mt-5 pb-3" id="content">
                <a href="admin-inventory.php" id="back" class="fst-italic ms-3 text-decoration-none text-dark">
                    <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to previous page</span>
                </a>
                <div class="container-fluid overflow-auto pb-5">

                    <div class="content-title d-flex justify-content-center m-3">
                        <h3>Aircon Inventory Details</h3>
                    </div>

                    <div class="container-fluid ps-5 pe-5">
                        <form method="post" action="" id="admin-add-inv" onsubmit="addinv()">
                            <?php if (isset($errors['error'])) : ?>
                                <div class="mt-3 bg-danger bg-opacity-25 text-danger text-center rounded" id="errortext"><?= $errors['error'] ?></div>
                            <?php endif; ?>
                            <div class="row">
                                <div class="col-md">

                                    <div class="col-md mb-3 mt-4">
                                        <label for="area">Area:<span class="text-danger">*</span></label><?php if (isset($errors['area'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['area'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                        <input type="text" class="form-control shadow-sm" name="area" id="area" placeholder="Admin Bldg., OAD, etc. " autofocus value="<?= htmlspecialchars($_POST['area'] ?? "") ?>">
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <label for="floor-area">Air Conditioned Floor Area:<span class="text-danger">*</span></label><?php if (isset($errors['floor_area'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['floor_area'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                        <input type="text" class="form-control shadow-sm" name="floor-area" id="floor-area" placeholder="Enter value" autofocus value="<?= htmlspecialchars($_POST['floor-area'] ?? "") ?>">
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <div class="d-flex">
                                            <p>Type</p><?php if (isset($errors['type'])) : ?><span id="errortext" class="text-danger text-center ms-2"><?= $errors['type'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                        </div>
                                        <div class="col-sm d-flex form-check">
                                            <div class="d-flex justify-content-around">
                                                <input type="checkbox" class="form-check-input me-2 border-dark" value="Split Type" name="typeST" id="typeST" autofocus <?= isset($_POST['typeST']) && $_POST['typeST'] === 'Split Type' ? 'checked' : '' ?>>
                                                <label for="type-st" class="form-check-label">Split Type<span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-3"></div>
                                            <div class="d-flex justify-content-around">
                                                <input type="checkbox" class="form-check-input me-2 border-dark" value="Window Type" name="typeWT" id="typeWT" autofocus <?= isset($_POST['typeWT']) && $_POST['typeWT'] === 'Window Type' ? 'checked' : '' ?>>
                                                <label for="type-wt" class="form-check-label">Window Type<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <label for="status">Status:</label><?php if (isset($errors['status'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['status'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                        <input type="text" class="form-control shadow-sm" name="status" id="status" placeholder="Operational, Non-operational, Stand-by, etc." autofocus value="<?= htmlspecialchars($_POST['status'] ?? "") ?>">
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <div class="d-flex">
                                            <p>Quantity</p><?php if (isset($errors['quantity'])) : ?><span id="errortext" class="text-danger text-center ms-2"><?= $errors['quantity'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                        </div>
                                        <div class="col-sm d-flex form-group">
                                            <div>
                                                <label for="split-type">Split Type:<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="qty-st" id="qty-st" placeholder="Enter quantity" autofocus value="<?= htmlspecialchars($_POST['qty-st'] ?? "") ?>">
                                            </div>
                                            <div class="col-sm-1"></div>
                                            <div>
                                                <label for="window-type">Window Type:<span class="text-danger">*</span></label>
                                                <input type="number" class="form-control shadow-sm" name="qty-wt" id="qty-wt" placeholder="Enter quantity" autofocus value="<?= htmlspecialchars($_POST['qty-wt'] ?? "") ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3 mt-5">
                                        <div class="d-flex">
                                            <p>Category</p><?php if (isset($errors['category'])) : ?><span id="errortext" class="text-danger text-center ms-2"><?= $errors['category'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                        </div>
                                        <div class="d-flex">
                                            <div class="col-sm-4 form-group">
                                                <label for="" class="form-check-label">Split Type:<span class="text-danger">*</span></label><?php if (isset($errors['categoryST'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['categoryST'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                <div class="form-check d-flex">
                                                    <input type="radio" class="form-check-input me-2 border-dark" name="categoryST" id="categoryST" value="INV" autofocus <?= isset($_POST['categoryST']) && $_POST['categoryST'] === 'INV' ? 'checked' : '' ?>><label for="categoryST">INV</label>
                                                    <div class="col-sm-3"></div>
                                                    <input type="radio" class="form-check-input me-2 border-dark" name="categoryST" id="categoryST" value="N-INV" autofocus <?= isset($_POST['categoryST']) && $_POST['categoryST'] === 'N-INV' ? 'checked' : '' ?>><label for="categoryST">N-INV</label>
                                                </div>
                                            </div>

                                            <div class="col-sm-4 form-group">
                                                <label for="" class="form-check-label">Window Type:<span class="text-danger">*</span></label><?php if (isset($errors['categoryWT'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['categoryWT'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                <div class="form-check d-flex">
                                                    <input type="radio" class="form-check-input me-2 border-dark" name="categoryWT" id="categoryWT" value="INV" autofocus <?= isset($_POST['categoryWT']) && $_POST['categoryWT'] === 'N-INV' ? 'checked' : '' ?>><label for="categoryWT">INV</label>
                                                    <div class="col-sm-3"></div>
                                                    <input type="radio" class="form-check-input me-2 border-dark" name="categoryWT" id="categoryWT" value="N-INV" autofocus <?= isset($_POST['categoryWT']) && $_POST['categoryWT'] === 'N-INV' ? 'checked' : '' ?>><label for="categoryWT">N-INV</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3 mt-5">
                                        <p>Nameplate Rating</p>
                                        <div class="mt-1">
                                            <label for="cooling">Cooling Capacity (Kl/hr):<span class="text-danger">*</span></label><?php if (isset($errors['cooling'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['cooling'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                            <input type="text" class="form-control shadow-sm" name="cooling-capacity" placeholder="ex. 19000, 13000, etc." autofocus value="<?= htmlspecialchars($_POST['cooling-capacity'] ?? "") ?>">
                                        </div>
                                        <div class="mt-3">
                                            <label for="rating">Capacity Rating (HR or TR):<span class="text-danger">*</span></label><?php if (isset($errors['rating'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['rating'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                            <input type="text" class="form-control shadow-sm" name="capacity-rating" placeholder="ex. 2.0, 2.5, etc." autofocus value="<?= htmlspecialchars($_POST['capacity-rating'] ?? "") ?>">
                                        </div>

                                        <div class="col-sm form-group mt-3">
                                            <div class="d-flex">
                                                <p>Energy Efficiency Ratio: </p><?php if (isset($errors['energy'])) : ?><span id="errortext" class="text-danger text-center ms-2"><?= $errors['energy'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                            </div>
                                            <div class="d-flex justify-content-start">
                                                <div>
                                                    <label for="nr-st">Split Type:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control shadow-sm" name="energy-ratio-st" id="energy-ratio-st" placeholder="ex. 5.17, 6.13, etc." autofocus value="<?= htmlspecialchars($_POST['energy-ratio-st'] ?? "") ?>">
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div>
                                                    <label for="nr-wt">Window Type:<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control shadow-sm" name="energy-ratio-wt" id="energy-ratio-wt" placeholder="ex. 5.17, 6.13, etc." autofocus value="<?= htmlspecialchars($_POST['energy-ratio-wt'] ?? "") ?>">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3 mt-5">
                                        <label for="year-purchase">Year of Purchase:<span class="text-danger">*</span></label><?php if (isset($errors['year'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['year'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                        <input type="month" class="form-control shadow-sm" name="year-purchase" id="year-purchase" value="<?= htmlspecialchars($_POST['year-purchase'] ?? "") ?>">
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <p>Operation:</p>
                                        <div class="col-sm d-flex form-group">
                                            <div>
                                                <label for="hrs-day">Hours per Day:<span class="text-danger">*</span></label><?php if (isset($errors['hours'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['hours'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                <input type="number" class="form-control shadow-sm" name="hrs-day" id="hrs-day" placeholder="1,2,3 etc." autofocus value="<?= htmlspecialchars($_POST['hrs-day'] ?? "") ?>">
                                            </div>
                                            <div class="col-sm-1"></div>
                                            <div>
                                                <label for="days-week">Days per Week:<span class="text-danger">*</span></label><?php if (isset($errors['days'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['days'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                <input type="number" class="form-control shadow-sm" name="days-week" id="days-week" placeholder="1,2,3 etc." autofocus value="<?= htmlspecialchars($_POST['days-week'] ?? "") ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md mb-3 mt-4">
                                        <div class="col-md btnAdd">
                                            <button type="submit" class="btn btn-warning mt-2" id="add-inv" name="add-inv">Add Inventory</button>
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
        function addinv() {
            Swal.fire({
                title: 'Adding inventory...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.addinv();
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