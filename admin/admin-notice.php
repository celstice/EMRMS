<?php 
// ADMIN: SCHEDULE REQUEST interface
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
                    <a href="admin-jobrequest.php" class="list-group-item  py-2 ripple active-btn">
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
        <section id="records" class="records">
            <div id="content" class="content mt-5 pb-5">

                <div class="container-fluid overflow-auto pb-5">

                    <div class="pt-3">
                        <div class="content-title d-flex justify-content-center">
                            <h2>Schedule Request</h2>
                        </div>
                    </div>

                    <div id="custom-tabs" class="custom-tabs bg-dangerx d-flex">
                        <div class="d-flex justify-content-between align-items-center  pt-3 ps-5 pe-5">
                            <div class="d-flex p-1 pb-3">
                                <a href="admin-jobrequest.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 opacity-75 border-end border-2 rounded-0">
                                    <i class="fa-solid fa-toolbox icon p-1"></i>
                                    <h6 class="fw-mediumm p-1 fsz">Job Request</h6>
                                </a>
                                <a href="admin-notice.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 border-start border-5 border-primary rounded-0 bg-primary bg-opacity-25">
                                    <i class="fa-solid fa-calendar icon p-1"></i>
                                    <h6 class="fw-lighter p-1 fsz">Schedule Request</h6>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-div h-100x borderx ps-5 pe-5 pt-3 pb-3 bg-body table-responsive">
                        <table id="schednotice-tbl" class="table table-hover pt-3">
                            <thead class="text-center border-bottom border-dark fw-bold">
                                <tr>
                                    <th hidden class="border-end th-bg">ID</th>
                                    <th class="border-end th-bg">Status</th>
                                    <th class="border-end th-bg">Job Services to be Rendered</th>
                                    <th class="border-end th-bg">Date to be Rendered</th>
                                    <th class="border-end th-bg">Time</th>
                                    <th class="border-end th-bg">Location</th>
                                    <th class="border-end th-bg">Requesting Official</th>
                                    <th class="th-bg">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                $typeID = isset($_GET['id']) ? $_GET['id'] : '';
                                $sql = mysqli_query($connect, "SELECT * FROM sched_records WHERE archive=0");
                                if (mysqli_num_rows($sql) > 0) {
                                    while ($rows = mysqli_fetch_assoc($sql)) { ?>
                                        <tr class="row1">
                                            <td hidden class=""><?php echo $rows['sched_id']; ?></td>
                                            <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>">
                                                <?php if ($rows['sched_status'] == 0 && $rows['job_request'] == 1) {
                                                    echo "<h6 class='bg-success bg-opacity-25 text-success rounded-1 p-1 fsz'>Job Request</h6>";
                                                } else if ($rows['sched_status'] == 1 && $rows['job_request'] == 1) {
                                                    echo "<h6 class='bg-success bg-opacity-25 text-success rounded-1 p-1 fsz'>Job Request</h6>";
                                                } else if ($rows['sched_status'] == 1) {
                                                    echo "<h6 class='bg-secondary bg-opacity-25 text-dark rounded-1 p-1 fsz'>Rescheduled</h6>";
                                                } else if ($rows['sched_status'] == 0) {
                                                    echo "<h6 class='bg-danger bg-opacity-25 text-danger rounded-1 p-1 text-truncate fsz'><i class='fa-solid fa-circle-exclamation icon-1 me-1'></i>New Schedule</h6>";
                                                } else if ($rows['sched_status'] == 2) {
                                                    echo "<h6 class='bg-danger bg-opacity-75 text-light rounded-1 p-1 text-truncate fsz'>Declined</h6>";
                                                } else if ($rows['sched_status'] == 3) {
                                                    echo "<h6 class='bg-danger bg-opacity-75 text-light rounded-1 p-1 text-truncate fsz'>Cancelled</h6>";
                                                } ?>
                                            </td>
                                            <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo nl2br($rows['job_render']); ?></td>
                                            <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo date("F j, Y", strtotime($rows['sched_render'])); ?></td>
                                            <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo ($rows['time_request'] != null ? date("h:i A", strtotime($rows['time_request'])) : 'none'); ?></td>
                                            <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo $rows['job_location']; ?></td>
                                            <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo $rows['requesting_official']; ?></td>
                                            <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>">
                                                <div class="dropdown">
                                                    <a class="btn btn-success fsz dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</a>
                                                    <ul class="dropdown-menu m-0 p-0">
                                                        <li>
                                                            <a href="create-jobrequest.php?id=<?php echo $rows['sched_id']; ?>" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden text-truncate" <?php if ($rows['job_request'] == 1) {echo "style='opacity:0.7;' disabled";} else if ($rows['sched_status'] == 2 || $rows['sched_status'] == 3) {echo "style='opacity:0.7;' disabled";} ?>>Create Job Request</a>
                                                        </li>
                                                        <li>
                                                            <a type=button class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#schedEdit<?php echo $rows['sched_id']; ?>" <?php if ($rows['job_request'] == 1) {echo "disabled style='opacity:0.7;'";} else if ($rows['sched_status'] == 2 || $rows['sched_status'] == 3) {echo "style='opacity:0.7;' disabled";} ?>>Update</a>
                                                        </li>
                                                        <li class="d-flex justify-content-center m-2">
                                                            <button name="" id="" <?php if ($rows['sched_status'] == 2 || $rows['sched_status'] == 3) {echo "style='opacity:0.7;' disabled";} else if ($rows['job_request'] == 1) {echo "disabled style='opacity:0.7;'";} else {echo 'data-bs-toggle="modal" data-bs-target="#decline' . $rows['sched_id'] . '"';} ?> class="btn btn-danger border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden">Decline</button>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- CREATE JOB REQUEST MODAL -->
                                        <div class="modal fade" id="create-job<?php echo $rows['sched_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                        <div class="mb-4">
                                                            <h5>Create Job Request</h5>
                                                            <p>Are you sure you want to create job request for this schedule?</p>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
                                                            <a name="" href="create-jobrequest.php?id=<?php echo $rows['sched_id']; ?>" class="btn btn-success"><i class="fa-solid fa-square-check p-1"></i>Yes</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- CREATE JOB REQUEST MODAL END -->

                                        <!-- SCHED COMPLETE MODAL -->
                                        <div class="modal fade" id="done<?php echo $rows['sched_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                        <div class="mb-4">
                                                            <h5>Mark as Done</h5>
                                                            <p>Are you sure you want to mark this schedule as done?</p>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
                                                            <button type="button" name="schedDone" id="<?php echo $rows['sched_id']; ?>" class="btn btn-success schedDone"><i class="fa-solid fa-square-check p-1"></i>Yes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- SCHED COMPLETE MODAL END -->

                                        <!-- DECLINE MODAL -->
                                        <div class="modal fade" id="decline<?php echo $rows['sched_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                        <div class="mb-4">
                                                            <h5>Decline schedule</h5>
                                                            <p>Are you sure you want to decline this schedule?</p>
                                                            <p class="p-1 text-danger">This action cannot be undone!</p>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
                                                            <button type="button" name="decline" id="<?php echo $rows['sched_id']; ?>" class="btn btn-success decline"><i class="fa-solid fa-square-check p-1"></i>Yes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- DECLINE MODAL END -->

                                        <!-- REMOVE MODAL -->
                                        <div class="modal fade" id="remove<?php echo $rows['sched_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                        <div class="mb-4">
                                                            <h5>Remove from record?</h5>
                                                            <p>This action will delete the record.</p>
                                                            <p class="p-1 text-danger">This action cannot be undone!</p>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
                                                            <button type="button" name="remove" id="<?php echo $rows['sched_id']; ?>" class="btn btn-success remove"><i class="fa-solid fa-square-check p-1"></i>Yes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- REMOVE MODAL END -->

                                        <!-- SCHED EDIT MODAL -->
                                        <div class="modal fade" id="schedEdit<?php echo $rows['sched_id']; ?>" tabindex="" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <form method="post" action="../config/notice-sched.php">
                                                        <div class="modal-header">
                                                            <h5>Update Aircon Maintenance Information</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="text-start">
                                                                <input hidden name="edit-schedID" value="<?php echo $rows['sched_id']; ?>">
                                                                <div class="m-2 pt-2">
                                                                    <label for="date-render">Date to be rendered:</label>
                                                                    <input type="date" class="form-control" name="date-render" id="date-render" value="<?php echo $rows['sched_render']; ?>" required>
                                                                </div>
                                                                <div class="m-2 pt-2">
                                                                    <label for="date-render">Location:</label>
                                                                    <input type="text" class="form-control" name="job-location" id="job-location" value="<?php echo $rows['job_location']; ?>" required>
                                                                </div>
                                                                <div class="m-2 pt-2">
                                                                    <label for="date-render">Requesting Official:</label>
                                                                    <input type="text" class="form-control" name="official" id="official" value="<?php echo $rows['requesting_official']; ?>" required>
                                                                </div>
                                                                <div class="m-2 pt-2">
                                                                    <label for="date-render">End-user:</label>
                                                                    <input type="text" class="form-control" name="end-user" id="end-user" value="<?php echo $rows['end_user']; ?>" required>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footerr m-3">
                                                            <div class="d-flex justify-content-between m-3">
                                                                <button type="button" class="btn btn-danger me-3" data-bs-dismiss="modal" aria-label="">Cancel</button>
                                                                <button class="btn btn-warning" name="edit-sched-info" id="edit-sched-info">Save</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- SCHED EDIT MODAL END -->

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
    <script>
        $(document).ready(function() {

            // datatable
            $('#schednotice-tbl').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });

            // schedule done button
            $('.schedDone').on('click', function() {
                var schedDone = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/notice-sched.php",
                    data: {
                        schedDone: schedDone
                    },
                    success: function(response) {
                        console.log(response);
                        console.log(schedDone);
                        window.location.reload();
                        $(".row1" + schedDone).empty();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // decline button
            $('.decline').on('click', function() {
                var decline = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/decline-cancel.php",
                    data: {
                        decline: decline
                    },
                    success: function(response) {
                        console.log(response);
                        console.log("decline ID:" + decline);
                        window.location.reload();
                        // $(".row1" + schedDone).empty();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            // remove button
            $('.remove').on('click', function() {
                var removeDeclined = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/decline-cancel.php",
                    data: {
                        removeDeclined: removeDeclined
                    },
                    success: function(response) {
                        console.log(response);
                        console.log("removed:" + removeDeclined);
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

        })
    </script>

</body>

</html>