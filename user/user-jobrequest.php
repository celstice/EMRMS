<?php 
// USER: JOB REQUEST interface
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
$fetch = "SELECT
    job_request.userID,
    job_request.done as job_done,
    feedbacks.job_id as jobID_done,
    feedbacks.done as feedback_done
FROM
    job_request
LEFT JOIN
    feedbacks ON job_request.job_id = feedbacks.job_id
WHERE
    job_request.userID = '$user'
    AND feedbacks.job_id IS NULL
    AND feedbacks.done IS NULL
ORDER BY
    job_request.job_id DESC;
";
$fetch2 = mysqli_query($connect, $fetch);
$done = mysqli_fetch_assoc($fetch2);

?>

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
                    <a href="user-jobrequest.php" class="list-group-item  py-2 ripple active-btn">
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
        <section id="job-request" class="">
            <div id="content" class="content mt-5 pb-5">

                <div class="">

                    <div class="pt-3">
                        <div class="content-title d-flex justify-content-center">
                            <h2>Job Requests</h2>
                        </div>
                    </div>

                    <div class="container-fluid ps-3 pe-3">

                        <div class="table-div h-100x borderx ps-5 pe-5 pt-3 pb-3 overflow-auto table-responsive">
                            <div id="new-request" class="d-flex mt-3 mb-3">
                                <button class="btn btn-primary fsz" type="button" <?php if (mysqli_num_rows($fetch2) === 0) {echo 'data-bs-toggle="modal" data-bs-target="#newRequest" ';} else if ($done['jobID_done'] == null && $done['feedback_done'] == null) {echo 'data-bs-toggle="modal" data-bs-target="#message" style="opacity:0.6;"';} else {echo 'data-bs-toggle="modal" data-bs-target="#newRequest" ';} ?>>New Request</button>
                            </div>
                            <table id="jobrequest-tbl" class="table  table-hover pt-3">
                                <thead class="text-center border-bottom border-dark fw-bolder">
                                    <tr class="">
                                        <th hidden class="border-end th-bg">ID</th>
                                        <th class="border-end th-bg">Request for Job Services <br>to be Rendered</th>
                                        <th class="border-end th-bg">Date<br> Requested</th>
                                        <th class="border-end th-bg">Location</th>
                                        <th class="border-end th-bg">Requesting OFficial</th>
                                        <th class="border-end th-bg">Status</th>
                                        <th class="th-bg">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    $typeID = isset($_GET['id']) ? $_GET['id'] : '';
                                    $query1 = mysqli_query($connect, "SELECT * FROM job_request WHERE userID = '$user' AND archive=0 ORDER BY job_id DESC");
                                    if (mysqli_num_rows($query1) > 0) {
                                        while ($row = mysqli_fetch_array($query1)) { ?>
                                            <tr class="">

                                                <td hidden class=""><?php echo $row['job_id']; ?></td>
                                                <td class="text-start <?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?>"><?php echo nl2br($row['job_service']); ?></td>
                                                <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?> text-truncate"><?php echo date("F j, Y", strtotime($row['date_requested'])); ?></td>
                                                <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?> "><?php echo $row['job_location']; ?></td>
                                                <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?> text-truncate"><?php echo $row['requesting_official']; ?></td>
                                                <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?> text-truncate">
                                                <?php if ($row['confirmed'] == 0) {
                                                    echo "<h6 class='bg-secondary bg-opacity-25 text-muted rounded-1 p-1 fsz'>Pending</h6>";
                                                    } else if ($row['confirmed'] == 1 && $row['done'] == 1) {
                                                    echo "<h6 class='bg-primary bg-opacity-25 text-primary rounded-1 p-1 fsz'>Completed</h6>";
                                                    } else if ($row['confirmed'] == 1) {
                                                    echo "<h6 class='bg-success bg-opacity-25 text-success rounded-1 p-1 fsz'>Confirmed</h6>";
                                                }?>
                                                </td>
                                                <td class="<?php echo ($row['job_id'] == $typeID ? 'bg-success bg-opacity-10' : ''); ?> ">
                                                    <div class="d-flex justify-content-center flex-column text-center">
                                                        <div class="dropdown">
                                                            <a class="btn btn-success fsz dropdown-toggle m-1" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</a>
                                                            <ul class="dropdown-menu m-0 p-0 text-darkx">
                                                                <li>
                                                                    <?php if ($row['confirmed'] == "0") {
                                                                        echo '<a type="button" disabled class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" style="opacity:0.7 !important;">View Details</a>';
                                                                    } else {
                                                                        echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#view-details' . $row['job_id'] . '">View Details</a>';
                                                                    } ?>
                                                                </li>
                                                                <li>
                                                                    <?php
                                                                    $jobId = $row['job_id'];
                                                                    $view = mysqli_query($connect, "SELECT * FROM feedbacks WHERE job_id='$jobId'");
                                                                    if (mysqli_num_rows($view) > 0) {
                                                                        $feedback = mysqli_fetch_assoc($view);
                                                                        echo '<a href="feedback-result.php?id=' . $feedback['feedback_id'] . '" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden">View Feedback</a>';
                                                                    } else {
                                                                        echo '<a type="button" disabled class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" style="opacity:0.7 !important;">View Feedback</a>';
                                                                    } ?>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="m-1">
                                                            <?php
                                                            if ($row['confirmed'] == 0) {
                                                                echo "<button disabled class='btn btn-warning fsz text-truncate'>Add Feedback</button>";
                                                            } else if (mysqli_num_rows($view) === 0) {
                                                                echo "<a href='user-feedback.php?id=" . $jobId . "' class='btn btn-warning fsz text-truncate'>Add Feedback</a>";
                                                            } ?>
                                                        </div>
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
                                                            $query = mysqli_query($connect, "SELECT * FROM job_request WHERE userID = '$user' and job_id = '$jid'");
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
                                                                        <!-- <hr> -->
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

                                            <!-- MODAL UPDATE REQUEST DETAILS -->
                                            <div id="update-details<?php echo $row['job_id'] ?>" aria-hidden="true" class="modal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content rounded-0">
                                                        <div class="modal-header border-0 text-center d-flex justify-content-center align-items-center">
                                                            <h6 class="text-uppercase fw-bold"> Update Job Request Details</h6>
                                                        </div>
                                                        <div class="modal-body pt-0 pb-0 m-1 d-flex flex-column">
                                                            <form method="post" id="update-form" action="../config/update-jobrequest.php" onsubmit="updating()">
                                                                <input hidden id="update-id" required name="update-id" value="<?php echo $row['job_id']; ?>">
                                                                <?php
                                                                $jid = $row['job_id'];
                                                                $query = mysqli_query($connect, "SELECT * FROM job_request WHERE userID = '$user' and job_id = '$jid'");
                                                                while ($rows = mysqli_fetch_assoc($query)) {
                                                                ?>
                                                                    <div class="border">
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Request for Job Services to be Rendered:</span>
                                                                            <textarea rows="5" class="form-control" name="job-service" id="job-service" placeholder="" required maxlength="200"><?php echo $rows['job_service']; ?></textarea>
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Requesting Official:</span>
                                                                            <input type="text" class="form-control" name="requesting-official" id="requesting-official" placeholder="" required maxlength="100" value="<?php echo $rows['requesting_official']; ?>">
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Location:</span>
                                                                            <input type="text" class="form-control" name="job-location" id="job-location" placeholder="" required maxlength="100" value="<?php echo $rows['job_location']; ?>">
                                                                        </div>
                                                                        <div class="borderx p-2 d-flex flex-column text-center">
                                                                            <span class="fst-italic fw-bold tg-text">Date Requested:</span>
                                                                            <input type="date" class="form-control" name="date-requested" id="date-requested" placeholder="" required value="<?php echo $rows['date_requested']; ?>">
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer border-0 d-flex justify-content-center">
                                                            <button class="tg-text text-upppercase btn btn-secondary bg-opacity-50 text-light fw-bold rounded-0">CLOSE</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- MODAL UPDATE REQUEST DETAILS END -->

                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <!-- NEW REQUEST MODAL -->
    <div class="modal fade" id="newRequest" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header text-dark border-0 mb-0">
                    <h5 class="modal-title text-uppercase fw-bold mb-0" id="">Job Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form method="post" action="../config/user-request.php" name="jobrequest-form" id="jobrequest-form" onsubmit="loading()">
                    <div class="modal-body">
                        <div class="d-flex flex-column">
                            <!-- <div class="col-md"> -->
                            <div class="col-md mb-2">
                                <label for="job-service" class="fst-italic fw-bold tg-text">Request for Job/Services to be Rendered:<span class="text-danger">*</span></label>
                                <textarea rows="5" class="form-control" name="job-service" id="job-service" placeholder="Example: Computer repair etc." required maxlength="200"></textarea>
                            </div>
                            <div class="col-md mb-2">
                                <label for="requesting-official" class="fst-italic fw-bold tg-text">Requesting Official:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="requesting-official" id="requesting-official" placeholder="" value="<?php echo $_SESSION['user']['firstname'] . ' ' . $_SESSION['user']['lastname']; ?>" required maxlength="100">
                            </div>
                            <div class="col-md mb-2">
                                <label for="job-location" class="fst-italic fw-bold tg-text">Location:<span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="job-location" id="job-location" placeholder="Example: Bldg.1 Room No.7, etc." required maxlength="100">
                            </div>
                            <div class="col-md mb-2">
                                <label for="date-requested" class="fst-italic fw-bold tg-text">Date Requested:<span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date-requested" id="daterequested" placeholder="" required>
                            </div>
                            <!-- </div> -->
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center align-items-center border-0">
                        <button type="submit" name="user-request" class="btn btn-warning fsz">Request</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <!--NEW REQUEST MODAL END -->

    <!-- MESSAGE MODAL -->
    <div class="modal fade" id="message" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card text-center border-0 m-5 d-flex justify-content-center">
                    <p>Before adding new requests, please give us your feedback.</p>
                    <br>
                    <p>Click the &nbsp;<button class="btn btn-warning fsz" data-bs-dismiss="modal">Add Feedback</button>&nbsp; button on your job request to add feedback.</p>
                    <br>
                    <h6>Thank you!</h6>
                </div>
            </div>
        </div>
    </div>
    <!-- MESSAGE MODAL END -->

    <script>
        $(document).ready(function() {
            $('#jobrequest-tbl').DataTable({
                "order": [
                    [0, "desc"]
                ],
            });
            dateJobRequest();
        });

        function loading() {
            Swal.fire({
                title: 'Sending Request...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.loading();
                },
            });
        }

        function updating() {
            Swal.fire({
                title: 'Updating Request...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.updating();
                },
            });
        }

        function hideLoading() {
            Swal.close();
        }

        function dateJobRequest() {

            const dateInput = document.getElementById('daterequested');

            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const dateToday = `${year}-${month}-${day}`;

            dateInput.value = dateToday;
            dateInput.min = dateToday;
        }
    </script>
    <?php include '../include/scripts.php'; ?>

</body>

</html>