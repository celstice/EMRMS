<?php
// ADMIN MAINTENANCE RECORDS ARCHIVE interface
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
                    <a href="admin-inventory.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-box-open icon"></i>
                        <span class="nav-text">Inventory</span>
                    </a>
                    <a href="admin-archives.php" class="list-group-item  py-2 ripple active-btn">
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
        <section id="records" class="records">
            <div id="content" class="content mt-5 pb-3">

                <div class="container-fluid overflow-auto pb-5">

                    <div class="pt-3">
                        <div class="content-title d-flex justify-content-center">
                            <h2>Archives</h2>
                        </div>
                    </div>

                    <div id="custom-tabs" class="custom-tabs bg-dangerx d-flex">
                        <div class="d-flex justify-content-between align-items-center  pt-3 ps-5 pe-5">
                            <div class="d-flex p-1">
                                <a href="admin-archives.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 border-start border-5 border-primary rounded-0 bg-primary bg-opacity-25">
                                    <i class="fa-solid fa-screwdriver-wrench icon p-1"></i>
                                    <h6 class="fw-mediumm p-1 fsz">Maintenance Records</h6>
                                </a>
                                <a href="admin-archives-inv.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 opacity-75 border-start border-2 rounded-0">
                                    <i class="fa-brands fa-intercom fa-rotate-90 icon p-1"></i>
                                    <h6 class="fw-lighter p-1 fsz">Inventory</h6>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-div h-100x borderx ps-4 pe-4 pt-3 pb-3 bg-body overflow-auto">
                        <table id="adminarchives-tbl" class="table pt-3">
                            <thead class="text-center text-dark">
                                <tr>
                                    <th hidden class="border-end th-bg">ID</th>
                                    <th class="border-end th-bg">Location</th>
                                    <th class="border-end th-bg">Unit</th>
                                    <th class="border-end th-bg">Equipment / Device</th>
                                    <th class="border-end th-bg">Type</th>
                                    <th class="border-end th-bg">Time Started</th>
                                    <th class="border-end th-bg">Time Finished</th>
                                    <th class="border-end th-bg">Date</th>
                                    <th class="border-endx th-bg">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                include 'repair-type.php';
                                $ts = mysqli_query($connect, "SELECT * FROM repair_records WHERE archive=1");
                                if (mysqli_num_rows($ts) > 0) {
                                    while ($row1 = mysqli_fetch_assoc($ts)) { ?>
                                        <tr class="repairRow">
                                            <td hidden class="border-end"><?php echo htmlspecialchars($row1['repair_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border-end"><?php echo htmlspecialchars($row1['repair_location'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border-end"><?php echo htmlspecialchars($row1['repair_unit'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border-end"><?php echo htmlspecialchars($row1['equipment_device'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border-end"><?php echo repairType($row1['repair_type']); ?></td>
                                            <td class="border-end"><?php if (!empty($row1['start_time']) && $row1['start_time'] !== "00:00:00") {
                                                                        echo date("h:i A", strtotime($row1['start_time']));
                                                                    } else {
                                                                        echo "";
                                                                    } ?></td>
                                            <td class="border-end"><?php if (!empty($row1['finish_time']) && $row1['finish_time'] !== "00:00:00") {
                                                                        echo date("h:i A", strtotime($row1['finish_time']));
                                                                    } else {
                                                                        echo "";
                                                                    } ?></td>
                                            <td class="border-end"><?php if (!empty($row1['date_finish']) && $row1['date_finish'] !== "0000-00-00") {
                                                                        echo date("F j, Y", strtotime($row1['date_finish']));
                                                                    } else {
                                                                        echo "";
                                                                    } ?></td>
                                            <td class="">
                                                <div class="d-flex justify-content-between ">
                                                    <div class="m-1">
                                                        <button type="button" class="btn btn-success text-truncate fsz d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#restore<?php echo $row1['repair_id']; ?>"><i class="fa-solid fa-arrow-up-from-bracket me-2"></i>Restore</button>
                                                    </div>
                                                    <div class="m-1">
                                                        <button type="button" class="btn btn-danger text-truncate fsz d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#deleteRepair<?php echo $row1['repair_id']; ?>"><i class="fa-solid fa-trash-can me-2"></i>Delete</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <!--DELETE MODAL -->
                                        <div class="modal fade" id="deleteRepair<?php echo $row1['repair_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                        <div class="mb-4">
                                                            <h5>Delete permanently?</h5>
                                                            <p>Confirm Deletion: This action cannot be undone.</p>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <form method="post" action="../config/admin-archive.php">
                                                                <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal" aria-label="NO">NO</button>
                                                                <input hidden name="deleterepair" id="repair" value="<?php echo $row1['repair_id']; ?>">
                                                                <input hidden name="deleterequest" id="request" value="<?php echo $row1['job_id']; ?>">
                                                                <button name="deleteRepair" id="<?php echo $row1['repair_id']; ?>" class="btn btn-danger deleteRepair">YES</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- DELETE MODAL END -->

                                        <!--RESTORE MODAL -->
                                        <div class="modal fade" id="restore<?php echo $row1['repair_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <input hidden name="equipID" value="<?php echo $row['repair_id'] ?>">
                                                    <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                        <div class="mb-4">
                                                            <h5>Restore record.</h5>
                                                            <p>Are you sure you want to restore this record?</p>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <form method="post" action="../config/admin-archive.php">
                                                                <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal" aria-label="NO">NO</button>
                                                                <input hidden name="repair" id="repair" value="<?php echo $row1['repair_id']; ?>">
                                                                <input hidden name="request" id="request" value="<?php echo $row1['job_id']; ?>">
                                                                <button name="restoreRepair" id="<?php echo $row1['repair_id']; ?>" class="btn btn-success me-2 restoreRepair">YES</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- RESTORE MODAL END -->

                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <?php include '../include/scripts.php'; ?>

    <script type="text/javascript">
        $(document).ready(function() {

            // datatable
            $('#adminarchives-tbl').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });

            //restoreRepair button
            $('.restoreRepair--').on('click', function() {
                var restoreRepair = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/admin-archive.php",
                    data: {
                        restoreRepair: restoreRepair
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Restoring...',
                            allowOutsideClick: false,
                            showConfirmButton: false,

                        });
                        window.location.reload();
                        $(".repairRow" + restoreRepair).empty();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            //deleteRepair button
            $('.deleteRepair--').on('click', function() {
                var deleteRepair = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/admin-archive.php",
                    data: {
                        deleteRepair: deleteRepair
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Deleting...',
                            allowOutsideClick: false,
                            showConfirmButton: false,

                        });
                        window.location.reload();
                        $(".repairRow" + deleteRepair).empty();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

        });
    </script>

</body>

</html>