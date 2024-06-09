<?php 
// ADMIN INV ARCHIVE interface
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

                    <div id="custom-tabs" class="custom-tabs d-flex">
                        <div class="d-flex justify-content-between align-items-center  pt-3 ps-5 pe-5">
                            <div class="d-flex p-1">
                                <a href="admin-archives.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 opacity-75 border-end border-2 rounded-0">
                                    <i class="fa-solid fa-screwdriver-wrench icon p-1"></i>
                                    <h6 class="fw-lighter p-1 fsz">Maintenance Records</h6>
                                </a>
                                <a href="admin-archives-inv.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 border-start border-5 border-primary rounded-0 bg-primary bg-opacity-25">
                                    <i class="fa-brands fa-intercom fa-rotate-90 icon p-1"></i>
                                    <h6 class="fw-mediumm p-1 fsz">Inventory</h6>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-div h-100x bg-body overflow-auto mt-3">
                        <table id="adminarchives-tbl" class="table overflow-auto border border-dark shadow-sm bg-body rounded rounded-1">
                            <thead class="text-center bg-">
                                <tr>
                                    <th rowspan="4" class="bg-light text-dark border border-1 border-dark th-bg">Actions</th>
                                    <th rowspan="4" class="bg-light text-dark border border-1 border-dark th-bg">Area</th>
                                    <th rowspan="4" class="bg-light text-dark border border-1 border-dark th-bg">Floor Area</th>
                                    <th colspan="2" rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">type</th>
                                    <th rowspan="4" class="bg-light text-dark border border-1 border-dark th-bg">Status</th>
                                    <th colspan="2" rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">Quantity</th>
                                    <th colspan="2" rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">Category</th>
                                    <th colspan="4" rowspan="" class="bg-light text-dark border border-1 border-dark th-bg">Nameplate Rating</th>
                                    <th rowspan="4" colspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Year of Purchase</th>
                                    <th colspan="2" rowspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Operation</th>
                                </tr>
                                <tr>
                                    <th rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">Cooling Capacity</th>
                                    <th rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">Capacity Rating</th>
                                    <th colspan="2" rowspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Energy Efficiency Ratio</th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Hours per Day</th>
                                    <th rowspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Days per Week</th>
                                </tr>
                                <tr>
                                    <th class="bg-light text-dark border border-1 border-dark th-bg">ST</th>
                                    <th class="bg-light text-dark border border-1 border-dark th-bg">WT</th>
                                    <th class="bg-light text-dark border border-1 border-dark th-bg">ST</th>
                                    <th class="bg-light text-dark border border-1 border-dark th-bg">WT</th>
                                    <th class="bg-light text-dark border border-1 border-dark th-bg">ST</th>
                                    <th class="bg-light text-dark border border-1 border-dark th-bg">WT</th>
                                    <th class="bg-light text-dark border border-1 border-dark th-bg">ST</th>
                                    <th class="bg-light text-dark border border-1 border-dark th-bg">WT</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                $inv = mysqli_query($connect, "SELECT * FROM admin_inventory WHERE archive=1");
                                if (mysqli_num_rows($inv) > 0) {
                                    while ($row = mysqli_fetch_assoc($inv)) {
                                        $year = htmlspecialchars($row['year_purchase'], ENT_QUOTES, 'UTF-8');
                                        $date = htmlspecialchars(date("F Y", strtotime($year)), ENT_QUOTES, 'UTF-8'); ?>
                                        <tr class="border border-1 border-dark tr">
                                            <td class="  border border-1 border-dark">
                                                <button class="btn btn-success fsz m-1" data-bs-placement="top" title="Restore" data-bs-toggle="modal" data-bs-target="#restoreINV<?php echo $row['admin_inv_id']; ?>">Restore</button>
                                                <button class="btn btn-danger fsz m-1" data-bs-placement="top" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteINV<?php echo $row['admin_inv_id']; ?>">Delete</button>
                                                
                                                <!--DELETE MODAL -->
                                                <div class="modal fade" id="deleteINV<?php echo $row['admin_inv_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                                <div class="mb-4">
                                                                    <h5>Delete permanently?</h5>
                                                                    <p>Confirm Deletion: This action cannot be undone.</p>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal" aria-label="NO">NO</button>
                                                                    <button type="button" name="deleteINV" id="<?php echo $row['admin_inv_id']; ?>" class="btn btn-danger deleteINV">YES</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- DELETE MODAL END -->

                                                <!--RESTORE MODAL -->
                                                <div class="modal fade" id="restoreINV<?php echo $row['admin_inv_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                                <div class="mb-4">
                                                                    <h5>Restore record.</h5>
                                                                    <p>Are you sure you want to restore this record?</p>
                                                                </div>
                                                                <div class="d-flex justify-content-center">
                                                                    <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal" aria-label="NO">NO</button>
                                                                    <button type="button" name="restoreINV" id="<?php echo $row['admin_inv_id']; ?>" class="btn btn-success me-2 restoreINV">YES</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- RESTORE MODAL END -->
                                                 
                                            </td>

                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['area'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['ac_floor_area'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php if ($row['type_st'] == "Split Type") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></td>
                                            <td class="border border-1 border-dark"><?php if ($row['type_wt'] == "Window Type") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['qty_st'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['qty_wt'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['category_st'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="text-nowrap border border-1 border-dark"><?php echo htmlspecialchars($row['category_wt'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['cooling_capacity'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['capacity_rating'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['energy_st'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['energy_wt'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td colspan="2" class="text-nowrap border border-1 border-dark"><?php echo $date; ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['operation_hours'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="border border-1 border-dark"><?php echo htmlspecialchars($row['operation_days'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        </tr>

                                <?php  }
                                } else {
                                    echo "<tr class='text-center'><td colspan='22'>no records</td></tr>";
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

            //restore button
            $('.restoreINV').on('click', function() {
                var restoreINV = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/admin-archive.php",
                    data: {
                        restoreINV: restoreINV
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Restoring...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                        window.location.reload();
                        $(".tr" + restoreINV).empty();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            //deleteRepair button
            $('.deleteINV').on('click', function() {
                var deleteINV = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/admin-archive.php",
                    data: {
                        deleteINV: deleteINV
                    },
                    success: function(response) {
                        console.log(response);
                        Swal.fire({
                            title: 'Deleting...',
                            allowOutsideClick: false,
                            showConfirmButton: false,
                        });
                        window.location.reload();
                        $(".tr" + deleteINV).empty();
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