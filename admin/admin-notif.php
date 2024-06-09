<?php 
// ADMIN: NOTIFICATIONS Interface
include '../config/connect.php';
session_start();

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
                    <a href="admin-inventory.php" class="list-group-item  py-2 ripple">
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
            <div id="content" class="content mt-5">
                <div class="container-fluid overflow-auto pb-5">

                    <div class="table-div container-fluid ps-5 pe-5">
                        <div class="notif content-title d-flex justify-content-between align-items-center mt-3 ps-5 pe-5">
                            <h3>Notifications</h3>
                            <div id="notifbtn" class="d-flex justify-content-evenly">
                                <button id="read-all" name="read-all" type="button" class="btn btn-outline-secondary d-flex justify-content-center align-items-center m-1">
                                    Mark all as read <i class="fa-solid fa-check-double ms-1 me-1"></i>
                                </button>
                            </div>
                        </div>
                        <div class="table-div h-100x ps-5 pe-5 pb-3 bg-body overflow-auto">
                            <div class="">
                                <!-- fetch data using js -->
                                <div class="list-group mx-3 mt-3" id="notifications"></div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <?php include '../include/scripts.php'; ?>

</body>

</html>