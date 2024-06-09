<?php 
// USER: REQUESTED SCHEDULES
include '../config/connect.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
} else if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['verified'] == 0) {
        header('location:../verify.php');
    }
}
$currentDate = date("Y-m-d");
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
                    <a href="user-notice.php" class="list-group-item  py-2 ripple active-btn">
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
        <section id="job-request" class="">
            <div id="content" class="content mt-5 pb-5">

                <div class="">

                    <div class="pt-3">
                        <div class="content-title d-flex justify-content-center">
                            <h2>Aircon Preventive Maintenance</h2>
                        </div>
                    </div>

                    <div class="container-fluid pt-3 ps-5 pe-5 d-flex align-items-center">
                        <i class="fa-solid fa-circle-exclamation p-1 text-danger"></i>
                        <h6 class="text-danger fst-italic fw-bold p-1">Note: If the scheduled date is not available, click reschedule.</h6>
                    </div>

                    <div class="container-fluid ps-3 pe-3">
                        <div class="table-div h-100x borderx ps-5 pe-5 pt-3 pb-5 table-responsive">

                            <div id="request-sched" class="mt-3 mb-3">
                                <button class="btn btn-primary fsz " type="button" data-bs-toggle="modal" data-bs-target="#usernotice">Request Schedule</button>
                            </div>

                            <table id="mntnotice-tbl" class="table table-hover pt-3">
                                <thead class="text-center border-bottom border-dark fw-bold">
                                    <tr>
                                        <th hidden class="border-end th-bg">ID</th>
                                        <th class="border-end th-bg">Job Services Rendered</th>
                                        <th class="border-end th-bg">Date to be rendered</th>
                                        <th class="border-end th-bg">Date Requested</th>
                                        <th class="border-end th-bg">Time</th>
                                        <th class="border-end th-bg">Location</th>
                                        <th class="border-end th-bg">Requesting Official</th>
                                        <th class="border-end text-truncate th-bg">End-User</th>
                                        <th class="border-end th-bg">Status</th>
                                        <th class="th-bg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    $typeID = isset($_GET['id']) ? $_GET['id'] : '';
                                    $user = $_SESSION['user']['userID'];
                                    $request = mysqli_query($connect, "SELECT * FROM sched_records WHERE userID='$user' AND archive=0 ORDER BY sched_id DESC");
                                    if (mysqli_num_rows($request) > 0) {
                                        while ($rows = (mysqli_fetch_assoc($request))) { ?>
                                            <tr>
                                                <td hidden class=""><?php echo $rows['sched_id']; ?></td>
                                                <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>">
                                                    <div class="d-flex justify-content-center align-items-center"><?php echo nl2br($rows['job_render']); ?></div>
                                                </td>
                                                <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo date("F j, Y", strtotime($rows['sched_render'])); ?></td>
                                                <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo date("F j, Y", strtotime($rows['date_request'])); ?></td>
                                                <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo ($rows['time_request'] != null ? date("h:i A", strtotime($rows['time_request'])) : 'none'); ?></td>
                                                <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo $rows['job_location']; ?></td>
                                                <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo $rows['requesting_official']; ?></td>
                                                <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo $rows['end_user']; ?></td>
                                                <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>">
                                                <?php if ($rows['done'] == 1) {
                                                        echo "<h6 class='bg-primary bg-opacity-25 text-primary rounded-1 p-1 fsz'>Completed</h6>";
                                                    }
                                                    if ($rows['job_request'] == 1 && $rows['done'] == 0) {
                                                        echo "<a href='user-jobrequest.php' class='bg-success bg-opacity-25 text-success rounded-1 p-1 text-decoration-none fsz text-truncate'>Job Request</a>";
                                                    } else if ($rows['sched_status'] == 1 && $rows['done'] == 0) {
                                                        echo "<h6 class='bg-danger bg-opacity-25 text-danger rounded-1 p-1 fsz'>Rescheduled</h6>";
                                                    } else if ($rows['sched_status'] == 0 && $rows['done'] == 0) {
                                                        echo "<h6 class='bg-secondary bg-opacity-25 text-muted rounded-1 p-1 fsz'>Scheduled</h6>";
                                                    } else if ($rows['sched_status'] == 2) {
                                                        echo "<h6 class='bg-danger bg-opacity-75 text-light rounded-1 p-1 text-truncate fsz'>Declined</h6>";
                                                    } else if ($rows['sched_status'] == 3) {
                                                        echo "<h6 class='bg-danger bg-opacity-75 text-light rounded-1 p-1 text-truncate fsz'>Cancelled</h6>";
                                                } ?>
                                                </td>
                                                <td class="<?php echo ($rows['sched_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>">
                                                    <div class="dropdown">
                                                        <a class="btn btn-success fsz dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</a>
                                                        <ul class="dropdown-menu m-0 p-0">
                                                            <li>
                                                                <a class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" <?php if ($rows['job_request'] == 1) {echo "disabled style='opacity:0.7;'";} else if ($rows['sched_status'] == 3) {echo "disabled style='opacity:0.7;'";} else { echo 'data-bs-toggle="modal" data-bs-target="#resched' . $rows['sched_id'] . '"';} ?>>Reschedule</a>
                                                            </li>
                                                            <li class="d-flex justify-content-center m-2">
                                                                <button class="btn btn-danger border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" <?php if ($rows['job_request'] == 1) {echo "disabled style='opacity:0.7;'";} else if ($rows['sched_status'] == 2 || $rows['sched_status'] == 3) {echo "disabled style='opacity:0.7;'";} else {echo 'data-bs-toggle="modal" data-bs-target="#cancel' . $rows['sched_id'] . '"';} ?>>Cancel</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- SCHED INFO MODAL -->
                                            <div class="modal fade" id="schedInfo<?php echo $rows['sched_id']; ?>" tabindex="" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content ps-3 pe-3">
                                                        <form method="post" action="../config/notice-sched.php">
                                                            <div class="modal-header">
                                                                <h5>Update Aircon Maintenance Information</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="text-start d-flexjustify-content-center">
                                                                    <input hidden name="edit-schedID" value="<?php echo $rows['sched_id']; ?>">
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
                                                                    <button class="btn btn-warning" name="edit-info" id="edit-info">Save</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--  SCHED INFO MODAL END -->

                                            <!-- RESCHEDULE MODAL -->
                                            <div class="modal fade" id="resched<?php echo $rows['sched_id']; ?>" tabindex="" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form method="post" action="../config/notice-sched.php" onsubmit="reschedule()">
                                                            <div class="modal-header">
                                                                <h5>Reschedule Aircon Maintenance</h5>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div>
                                                                    <input hidden name="schedID" value="<?php echo $rows['sched_id']; ?>">
                                                                    <div class="m-2">
                                                                        <label for="date-render">Date Requested:&nbsp;</label>
                                                                        <span><?php echo date("F j, Y", strtotime($rows['date_request'])); ?></span>
                                                                    </div>
                                                                    <div class="m-2 pt-2 d-flex align-items-center">
                                                                        <label for="date-render">Date to be Rendered:&nbsp;</label>
                                                                        <span><?php echo date("F j, Y", strtotime($rows['sched_render'])); ?></span>
                                                                    </div>
                                                                    <div class="m-2 pt-2">
                                                                        <label for="date-render">New Schedule:<span class="text-danger">*</span></label>
                                                                        <input type="date" class="form-control fw-bold" name="date-render" id="date-render" min="<?php echo $currentDate; ?>" required>
                                                                    </div>
                                                                    <div class="m-2 pt-2">
                                                                        <label for="time-request">Time:</label>
                                                                        <input type="time" class="form-control" name="time-request" id="time-request" value="<?php echo $rows['time_request']; ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footerr m-3">
                                                                <div class="d-flex justify-content-between m-3">
                                                                    <button type="button" class="btn btn-danger me-3" data-bs-dismiss="modal" aria-label="">Cancel</button>
                                                                    <button class="btn btn-warning" name="resched" id="resched">Reschedule</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--  RESCHEDULE MODAL END -->

                                            <!-- CANCEL MODAL -->
                                            <div class="modal fade" id="cancel<?php echo $rows['sched_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                            <div class="mb-4">
                                                                <h5>Cancel schedule</h5>
                                                                <p>Are you sure you want to cancel this schedule? You will need to request a new schedule if you cancel.</p>
                                                                <p class="p-1 text-danger">This action cannot be undone!</p>
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
                                                                <button type="button" name="cancel" id="<?php echo $rows['sched_id']; ?>" class="btn btn-success cancel"><i class="fa-solid fa-square-check p-1"></i>Yes</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- CANCEL MODAL END -->

                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <!-- REQUEST NOTICE (USER) MODAL -->
    <div class="modal fade" id="usernotice" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="post" action="../config/notice-sched.php" name="jobrequest-form" id="jobrequest-form" onsubmit="requestsched()">
                    <div class="modal-header text-dark">
                        <h5 class="modal-title" id="">Request Aircon cleaning schedule</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php $currentDate = date("Y-m-d"); ?>
                        <div class="row">
                            <div class="col-md">
                                <label>Type of Service:<span class="text-danger">*</span></label>
                                <div class="col-md mb-3 d-flex align-items-center">
                                    <input type="radio" class="form-check-input border-dark me-2" name="service" id="aircon" value="Cleaning of Room Airconditioning">
                                    <label for="aircon">Cleaning of Room Air Conditioning</label>
                                </div>
                                <div class="col-md mb-3 d-flex align-items-center">
                                    <input type="radio" class="form-check-input border-dark me-2" name="service" id="fans" value="Cleaning of Electric Fans">
                                    <label for="e-fans">Cleaning of Electric Fans</label>
                                </div>
                                <div class="col-md mb-3 d-flex align-items-center">
                                    <input type="radio" class="form-check-input border-dark me-2" name="service" id="others" value="">
                                    <label for="e-fans">Others</label>
                                    <input type="text" class="m-1 form-control border-top-0 border-end-0 border-start-0" name="otherInput" id="othersInput" placeholder="Enter details" disabled>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="requesting-official">Requesting Official:<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="requesting-official" id="requesting-official" placeholder="" value="<?php echo $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname']; ?>" required maxlength="100">
                                </div>
                                <div class="col-md mb-3">
                                    <label for="job-location">Location:<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="job-location" id="job-location" placeholder="Faculty Office, Room 404, etc." required maxlength="100">
                                </div>
                                <div class="col-md mb-3">
                                    <label for="date-requested">Date Requested:<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date-requested" id="date-requested" placeholder="" value="<?php echo $currentDate; ?>" min="<?php echo $currentDate; ?>" required>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="date-render">Date to be Rendered:<span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date-render" id="date-render" placeholder="" min="<?php echo $currentDate; ?>" required>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="time-request">Time:<span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="time-request" id="time-request" required>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="end-user">End-User:</label>
                                    <input type="text" class="form-control" name="end-user" id="end-user" placeholder="" value="<?php echo $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname']; ?>" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit" name="request-notice" id="requestSched" class="btn btn-warning">Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- REQUEST NOTICE MODAL END -->

    <script>
        function requestsched() {
            Swal.fire({
                title: 'Requesting schedule...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.requestsched();
                },
            });
        }

        function reschedule() {
            Swal.fire({
                title: 'Rescheduling request...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.reschedule();
                },
            });
        }

        function hideLoading() {
            Swal.close();
        }

        $(document).ready(function() {
            $('#mntnotice-tbl').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });

            $('.cancel').on('click', function() {
                var cancel = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/decline-cancel.php",
                    data: {
                        cancel: cancel
                    },
                    success: function(response) {
                        console.log(response);
                        console.log("cancel ID:" + cancel);
                        window.location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            const option1 = document.getElementById('aircon');
            const option2 = document.getElementById('fans');
            const option3 = document.getElementById('others');
            const otherInput = document.getElementById('othersInput');

            option1.addEventListener('change', updateInputField);
            option2.addEventListener('change', updateInputField);
            option3.addEventListener('change', updateInputField);

            function updateInputField() {
                if (option1.checked || option2.checked) {
                    otherInput.disabled = true;
                    otherInput.value = '';
                } else if (option3.checked) {
                    otherInput.disabled = false;
                    otherInput.addEventListener('input', function() {
                        option3.value = otherInput.value.trim();
                        console.log(option3.value);
                    });
                }
            }

            //create job request from schedule
            $("#requestSched").click(function() {
                var jobService = $('input[name="service"]:checked').val();
                var userID = $("#userID").val();
                var schedID = $("#schedID").val();
                var jobservice = $("#jobservice").val();
                var joblocation = $("#joblocation").val();
                var schedrender = $("#schedrender").val();
                var rqofficial = $("#rqofficial").val();
                var daterequested = $("#daterequested").val();
                var jobnumber = $("#jobnumber").val();
                var feedbacknumber = $("#feedbacknumber").val();
                var supplies = $("#supplies").val();
                var causes = $("#causes").val();
                var personnel = $("#personnel").val();

                if (jobservice.trim() !== "" &&
                    joblocation.trim() !== "" &&
                    schedrender.trim() !== "" &&
                    rqofficial.trim() !== "" &&
                    daterequested.trim() !== "" &&
                    jobnumber.trim() !== "" &&
                    feedbacknumber.trim() !== "" &&
                    supplies.trim() !== "" &&
                    causes.trim() !== "" &&
                    personnel.trim() !== ""
                ) {

                    $.ajax({
                        url: "../config/create-job.php",
                        type: "POST",
                        data: {
                            userID: userID,
                            schedID: schedID,
                            jobservice: jobservice,
                            joblocation: joblocation,
                            schedrender: schedrender,
                            rqofficial: rqofficial,
                            daterequested: daterequested,
                            jobnumber: jobnumber,
                            feedbacknumber: feedbacknumber,
                            supplies: supplies,
                            causes: causes,
                            personnel: personnel,
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Success!",
                                text: "Data submitted.",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1000,

                            });
                            window.location.reload();
                        },
                        error: function(error) {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred.",
                                icon: "error",
                            });
                        },
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "Please fill up the fields.",
                        icon: "error",
                    });
                }
            });

        });

    </script>

    <?php include '../include/scripts.php'; ?>

</body>

</html>