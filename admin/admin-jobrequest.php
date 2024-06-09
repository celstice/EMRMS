<?php 
// ADMIN JOB REQUEST interface
include '../config/connect.php';
session_start();
require_once('../config/confirm-jobrequest.php');

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
                            <h2>Job Request</h2>
                        </div>
                    </div>

                    <div id="custom-tabs" class="custom-tabs bg-dangerx d-flex">
                        <div class="d-flex justify-content-between align-items-center  pt-3 ps-5 pe-5">
                            <div class="d-flex p-1 pb-3">
                                <a href="admin-jobrequest.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 border-start border-5 border-primary rounded-0 bg-primary bg-opacity-25">
                                    <i class="fa-solid fa-toolbox icon p-1"></i>
                                    <h6 class="fw-mediumm p-1 fsz">Job Request</h6>
                                </a>
                                <a href="admin-notice.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 opacity-75 border-start border-2 rounded-0">
                                    <i class="fa-solid fa-calendar icon p-1"></i>
                                    <h6 class="fw-lighter p-1 fsz">Schedule Request</h6>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="table-div h-100x borderx ps-5 pe-5 pt-3 pb-3 bg-body table-responsive">
                        <table id="jobrequest-table" class="table table-hover pt-3">
                            <thead class="text-center border-bottom border-dark fw-bold">
                                <tr>
                                    <th hidden class="border-end th-bg">ID</th>
                                    <th class="border-end th-bg">Status</th>
                                    <th class="border-end th-bg">Job Services <br>to be Rendered</th>
                                    <th class="border-end th-bg">Requesting<br> Official</th>
                                    <th class="border-end th-bg">Location</th>
                                    <th class="border-end th-bg">Date <br>Requested</th>
                                    <th class="border-end th-bg">Job Order<br> Control Number</th>
                                    <th class="border-endx th-bg">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                include '../config/connect.php';
                                $typeID = isset($_GET['id']) ? $_GET['id'] : '';
                                $query1 = mysqli_query($connect, "SELECT * FROM job_request WHERE archive=0 ORDER BY job_id DESC");
                                if (mysqli_num_rows($query1) > 0) {
                                    while ($row = mysqli_fetch_array($query1)) {
                                        $jobId = $row['job_id'];
                                        $view = mysqli_query($connect, "SELECT * FROM feedbacks WHERE job_id='$jobId'"); ?>
                                        <tr>
                                            <td hidden><?php echo $row['job_id']; ?></td>
                                            <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>">
                                            <?php if ($row['confirmed'] == 0 && $row['done'] == 0) {
                                                echo "<figure class='d-flex justify-content-center'><h6 class='bg-danger bg-opacity-25 text-danger rounded-1 p-1 d-flex justify-content-center align-items-center text-truncate fsz'><i class='fa-solid fa-circle-exclamation p-1'></i>New Request&nbsp;</h6></figure>";
                                                } else if ($row['confirmed'] == 1 && $row['done'] == 0) {
                                                echo "<h6 class='bg-secondary bg-opacity-25 text-muted rounded-1 p-1 fsz'>Confirmed</h6>";
                                                } else if (mysqli_num_rows($view) == 0) {
                                                echo "<figure class='d-flex justify-content-center'><h6 class='bg-warning bg-opacity-75 opacity-75 text-dark rounded-1 p-1 d-flex justify-content-center align-items-center text-truncate fsz'><i class='fa-solid fa-triangle-exclamation p-1'></i>No Feedback&nbsp;</h6></figure>";
                                                } else if ($row['confirmed'] == 1 && $row['done'] == 1) {
                                                echo "<h6 class='bg-primary bg-opacity-25 text-primary rounded-1 p-1 fsz'>Completed</h6>";
                                            } ?>
                                            </td>
                                            <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo htmlspecialchars(nl2br($row['job_service']), ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo htmlspecialchars($row['requesting_official'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo htmlspecialchars($row['job_location'], ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo htmlspecialchars(date("F j, Y", strtotime($row['date_requested'])), ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php if (!empty($row['job_control_number'])) {echo $row['job_control_number'];} else {echo "N/A";} ?></td>
                                            <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>">
                                                <div class="dropdown">
                                                    <a class="btn btn-success fsz dropdown-toggle ripple" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</a>
                                                    <ul class="dropdown-menu m-0 p-0 text-dark" id="dropdown-menu">
                                                        <li>
                                                            <?php if ($row['confirmed'] == 0 && $row['done'] == 0) {
                                                                echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#confirm-request' . $row['job_id'] . '">Confirm</a>';
                                                            } else {
                                                                echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden opacity-50">Confirm</a>';
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($row['confirmed'] == 1 && $row['done'] == 0) {
                                                                echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#doneRepair' . $row['job_id'] . '">Done</a>';
                                                            } else {
                                                                echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden opacity-50">Done</a>';
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($row['confirmed'] == 1 && $row['done'] == 0) {
                                                                echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#update-request' . $row['job_id'] . '">Update</a>';
                                                            } else {
                                                                echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden opacity-50">Update</a>';
                                                            } ?>
                                                        </li>
                                                        <li>
                                                            <?php if ($row['confirmed'] == 1) {
                                                                echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#view-details' . $row['job_id'] . '">Details</a>';
                                                            } else if ($row['confirmed'] == 0) {
                                                                echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden opacity-50">Details</a>';
                                                            } ?>
                                                        </li>
                                                        <li class="d-flex justify-content-center m-2">
                                                            <form method="post" action="../config/generate-jobrequest.php">
                                                                <input hidden name="job-id" value="<?php echo $row['job_id']; ?>">
                                                                <button class="btn btn-primary border d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" name="jobrequest" type="submit" <?php if ($row['confirmed'] == 0) {echo "disabled";} else {echo " ";} ?>>Download Job Order</button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- MODAL VIEW REQUEST DETAILS -->
                                        <div id="view-details<?php echo $row['job_id'] ?>" aria-hidden="true" class="modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content rounded-0">
                                                    <div class="modal-header border-0 text-center d-flex justify-content-center align-items-center">
                                                        <h6 class="text-uppercase fw-bold">Job Request Details</h6>
                                                    </div>
                                                    <div class="modal-body pt-0 pb-0 m-1 d-flex flex-column">
                                                        <?php
                                                        $jid = $row['job_id'];
                                                        $query = mysqli_query($connect, "SELECT * FROM job_request WHERE job_id = '$jid'");
                                                        while ($rows = mysqli_fetch_assoc($query)) { ?>
                                                            <div class="border">
                                                                <div class="">
                                                                    <div class="border-bottom p-2 d-flex justify-content-center tea-green-bg">
                                                                        <span class="tg-text text-uppercase fw-bold text-center">Job Control Number:&nbsp;</span>
                                                                        <span class="fw-bold text-center"><?php echo $rows['job_control_number']; ?></span>
                                                                    </div>
                                                                    <div class="borderx p-2 d-flex flex-column text-center">
                                                                        <span class="fst-italic fw-bold tg-text">Request for Job Services to be Rendered:</span>
                                                                        <span class=""><?php echo $rows['job_service']; ?></span>
                                                                    </div>
                                                                    <div class="borderx p-2 d-flex flex-column text-center">
                                                                        <span class="fst-italic fw-bold tg-text">Requesting Official:</span>
                                                                        <span class=""><?php echo $rows['requesting_official']; ?></span>
                                                                    </div>
                                                                    <div class="borderx p-2 d-flex flex-column text-center">
                                                                        <span class="fst-italic fw-bold tg-text">Location:</span>
                                                                        <span class=""><?php echo $rows['job_location']; ?></span>
                                                                    </div>
                                                                    <div class="borderx p-2 d-flex flex-column text-center">
                                                                        <span class="fst-italic fw-bold tg-text">Date Requested:</span>
                                                                        <span class=""><?php echo date("F j, Y", strtotime($rows['date_requested'])); ?></span>
                                                                    </div>
                                                                    <div class="borderx p-2 d-flex flex-column text-center">
                                                                        <span class="fst-italic fw-bold tg-text">Supplies / Materials Needed:</span>
                                                                        <span class=""><?php echo $rows['supplies_materials']; ?></span>
                                                                    </div>
                                                                    <div class="borderx p-2 d-flex flex-column text-center">
                                                                        <span class="fst-italic fw-bold tg-text">Causes & Remedies:</span>
                                                                        <span class=""><?php echo $rows['causes']; ?></span>
                                                                    </div>
                                                                    <div class="borderx p-2 d-flex flex-column text-center">
                                                                        <span class="fst-italic fw-bold tg-text">Assigned Personnel:</span>
                                                                        <span class=""><?php echo $rows['assigned_personnel']; ?></span>
                                                                    </div>
                                                                    <div class="borderx p-2 d-flex flex-column text-center">
                                                                        <span class="fst-italic fw-bold tg-text">Feedback Number:</span>
                                                                        <span class=""><?php echo $rows['feedback_number']; ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                    <div class="modal-footer border-0 d-flex justify-content-center">
                                                        <button class="tg-text text-upppercase btn btn-secondary bg-opacity-50 text-light fw-bold rounded-0" data-bs-dismiss="modal">CLOSE</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MODAL VIEW REQUEST DETAILS END -->

                                        <!-- MODAL UPDATE REQUEST -->
                                        <div id="update-request<?php echo $row['job_id'] ?>" aria-hidden="true" class="modal">
                                            <div class="modal-dialog">
                                                <div class="modal-content rounded-0">
                                                    <div class="modal-header border-0 text-center d-flex justify-content-center align-items-center tea-green-bgx">
                                                        <h6 class="text-uppercase fw-bold">Update Job Request</h6>
                                                    </div>
                                                    <form method="post" action="../config/update-jobrequest.php" id="update-form" onsubmit="updatejobrequest()">
                                                        <input id="update-id" name="update-id" hidden value="<?php echo $row['job_id']; ?>">
                                                        <input id="uid" name="uid" hidden value="<?php echo $row['userID']; ?>">
                                                        <div class="modal-body pt-0 pb-0 m-1 d-flex flex-column">
                                                            <?php
                                                            $jid = $row['job_id'];
                                                            $query = mysqli_query($connect, "SELECT * FROM job_request WHERE job_id = '$jid'");
                                                            while ($rows = mysqli_fetch_assoc($query)) { ?>
                                                                <div class="borders">
                                                                    <div class="">
                                                                        <div class="border-bottom p-2 d-flex flex-column justify-content-center tea-green-bg">
                                                                            <span class="tg-text text-uppercase fw-bold text-center">Job Control Number:&nbsp;</span>
                                                                            <input class="form-control" id="job-number" name="job-number" value="<?php echo $row['job_control_number']; ?>">
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Supplies / Materials Needed:</span>
                                                                            <textarea rows="2" class="form-control" id="supplies-materials" name="supplies-materials"><?php echo $row['supplies_materials']; ?></textarea>
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Causes & Remedies:</span>
                                                                            <textarea rows="2" class="form-control" id="causes" name="causes"><?php echo $row['causes']; ?></textarea>
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Assigned Personnel:</span>
                                                                            <textarea rows="2" class="form-control" id="assigned-personnel" name="assigned-personnel"><?php echo $row['assigned_personnel']; ?></textarea>
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Feedback Number:</span>
                                                                            <input class="form-control" id="feedback-number" name="feedback-number" value="<?php echo $row['feedback_number']; ?>">
                                                                        </div>
                                                                        <hr class="p-1">
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Request for Job Services to be Rendered:</span>
                                                                            <input class="form-control" id="job-service" required name="job-service" value="<?php echo $row['job_service']; ?>">
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Requesting Official:</span>
                                                                            <input class="form-control" id="requesting-official" required name="requesting-official" value="<?php echo $row['requesting_official']; ?>">
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Location:</span>
                                                                            <input class="form-control" id="location" required name="location" value="<?php echo $row['job_location']; ?>">
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Date Requested:</span>
                                                                            <input class="form-control" type="date" id="date-requested" required name="date-requested" value="<?php echo $row['date_requested']; ?>">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                        <div class="modal-footer border-0 d-flex justify-content-center">
                                                            <div class="d-flex justify-content-between">
                                                                <div class="m-1">
                                                                    <button type="button" class="btn btn-danger close " data-bs-dismiss="modal" aria-label="Close"> Cancel </button>
                                                                </div>
                                                                <div class="m-1">
                                                                    <button value="" type="submit" name="updatejob" id="updatejob" class="btn btn-primary">Update</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- MODAL UPDATE REQUEST DETAILS END -->

                                        <!-- JOB-DONE MODAL -->
                                        <div class="modal fade" id="doneRepair<?php echo $row['job_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                        <div class="mb-4">
                                                            <h5>Job Request Complete</h5>
                                                            <p>Complete the details to mark as Done.</p>
                                                        </div>
                                                        <div class="d-flex justify-content-center">
                                                            <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
                                                            <a href="job-details.php?id=<?php echo $row['job_id']; ?>" class="text-decoration-none btn btn-primary">Continue<i class="fa-solid fa-arrow-right p-1"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- JOB-DONE MODAL END -->

                                <?php include '../config/confirm-modal.php';} } ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <?php include '../include/scripts.php'; ?>

    <script>
        // datatable
        $(document).ready(function() {
            $('#jobrequest-table').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });

        });

        // confirm request
        function loading() {
            Swal.fire({
                title: 'Confirming request...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.loading();
                },
            });
        }

        // updating job request 
        function updatejobrequest() {
            Swal.fire({
                title: 'Updating job request...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.updatejobrequest();
                },
            });
        }

        function hideLoading() {
            Swal.close();
        }
    </script>

</body>

</html>