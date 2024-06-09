<?php 
// UPDATE USER PROFILE
include '../config/connect.php';
require_once('../config/user-settings.php');

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
            <div id="content" class="content mt-5 pt-2">

                <div class="container-fluid ps-5 pe-5 pb-3 rs-1 overflow-auto table-div">
                    <div class="rounded d-flex flex-column  bg-cbody lh-1" id="user-profile"><?php include '../include/update-profile-div.php' ?> </div>
                </div>
                
            </div>
        </section>
    </div>

    <?php include '../include/scripts.php'; ?>

</body>

</html>