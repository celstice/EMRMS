<?php 
// ADMIN: CREATE JOB REQUEST from sched request
include '../config/connect.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
} else if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['verified'] == 0) {
        header('location:../verify.php');
    }
}

if (isset($_GET['id'])) {
    $sched = $_GET['id'];
    $sql = mysqli_query($connect, "SELECT * FROM sched_records WHERE sched_id = $sched");
}
$result = mysqli_fetch_array($sql);
$schedID = $result['sched_id'];
$userID = $result['userID'];
$job_render = $result['job_render'];
$job_location = $result['job_location'];
$sched_render = date("F j, Y", strtotime($result['sched_render']));
$date_request = date("F j, Y", strtotime($result['date_request']));
$date_requested = $result['date_request'];
$official = $result['requesting_official'];

$sql2 = mysqli_query($connect, "SELECT * FROM repair_records WHERE job_id = '$schedID'");
$repair = mysqli_fetch_assoc($sql2);

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
                    <a href="admin-logs.php" class="list-group-item py-2 ripple">
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
            <div class="content mt-5" id="content">

                <div class="container overflow-auto pb-5">
                    <form method="post" action="" id="jobCompleteForm">
                        <div class="form-content">
                            <input hidden id="userID" name="user-id" value="<?php echo $userID; ?>">
                            <input hidden id="schedID" name="sched-id" value="<?php echo $schedID; ?>">
                            <input hidden id="jobID" name="job-id" value="<?php echo $get_ID; ?>">

                            <!-- JOB INFO -->
                            <div class="row">
                                <div class="col-md mb-3">
                                    <div class="col-md mb-4 mt-4">

                                        <div class="col-md d-flex flex-column align-items-center justify-content-center border">
                                            <label class="pt-1">Request for Job Services to be Rendered:&nbsp;</label>
                                            <input name="job-service" id="jobservice" class="text-center form-control-plaintext fw-bold text-primary" value="<?php echo $job_render; ?>">
                                        </div>

                                        <div class="col-sm mb-4 d-flex form-group justify-content-center text-center ">
                                            <div class="col-md d-flex flex-column pt-2 border">
                                                <label for="job-location">Location:</label>
                                                <hr class="border opacity-25 m-1 p-0">
                                                <input required class="form-control-plaintext text-center fw-bold text-primary" name="job-location" id="joblocation" value="<?php echo $job_location; ?>">
                                            </div>

                                            <div class="col-md d-flex flex-column pt-2 border">
                                                <label for="job-number">Date to be Rendered:</label>
                                                <hr class="border opacity-25 m-1 p-0">
                                                <input required class="form-control-plaintext text-center fw-bold text-primary" name="sched-render" id="schedrender" value="<?php echo $sched_render; ?>">
                                            </div>

                                            <div class="col-md d-flex flex-column pt-2 border">
                                                <label for="requesting-official">Requesting Official:</label>
                                                <hr class="border opacity-25 m-1 p-0">
                                                <input required class="form-control-plaintext text-center fw-bold text-primary" name="requesting-official" id="rqofficial" value="<?php echo $official; ?>">
                                            </div>

                                            <div class="col-md d-flex flex-column pt-2 border">
                                                <label for="date-request">Date Requested:</label>
                                                <hr class="border opacity-25 m-1 p-0">
                                                <input disabled class="form-control-plaintext text-center fw-bold text-primary" name="" id="" value="<?php echo $date_request; ?>">
                                                <input hidden class="" id="daterequested" name="date-requested" value="<?php echo $date_requested; ?>">
                                            </div>
                                        </div>

                                        <div class="content-title d-flex justify-content-start mt-5 mb-3">
                                            <h4>Create Job Request</h4>
                                        </div>

                                        <div class="col-md mb-3 mt-4">
                                            <div class="col-sm d-flex form-group">
                                                <div class="col-md">
                                                    <label for="job-number">Job Order Control Number:<span class="text-danger">*</span></label>
                                                    <input required type="text" class="form-control shadow-sm" name="job-number" id="jobnumber" placeholder="ERMS-0000">
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-md">
                                                    <label for="feedback-number">Feedback Number:<span class="text-danger">*</span></label>
                                                    <input required type="text" class="form-control shadow-sm" name="feedback-number" id="feedbacknumber" placeholder="00000">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md mb-3 mt-4">
                                            <div class="m-3x">
                                                <label for="supplies-materials">Supplies / Materials Needed:</label>
                                                <textarea rows="2" class="form-control" id="supplies" name="supplies-materials" placeholder="..."></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md mb-3 mt-4">
                                            <div class="m-3x">
                                                <label for="causes">Causes & Remedies:</label>
                                                <textarea rows="2" class="form-control" id="causes" name="causes" placeholder="..." required></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md mb-3 mt-4">
                                            <div class="m-3x">
                                                <label for="assigned-personnel">Assigned Personnel:</label>
                                                <textarea rows="2" class="form-control" id="personnel" name="assigned-personnel" required>ERMS Personnel</textarea>
                                            </div>
                                        </div>

                                        <div class="col-md mb-3 mt-4 d-flex justify-content-between">
                                            <div class="">
                                                <a href="admin-notice.php" name="" id="" class="btn btn-danger">Cancel</a>
                                            </div>
                                            <div class="">
                                                <button type="button" name="create-job" id="create-job" class="btn btn-warning d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#complete"><i class="fa-solid fa-toolbox p-1"></i>Create Job Request</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
        </section>
    </div>

    <div class="modal fade" id="complete" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card text-center border-0 m-5 d-flex justify-content-center">
                    <div class="mb-4">
                        <h5>Job Request Complete</h5>
                        <p>Continue</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
                        <button type="button" id="jobComplete" name="jobComplete" class="text-decoration-none btn btn-primary">Continue<i class="fa-solid fa-arrow-right p-1"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include '../include/scripts.php'; ?>
    <script>
        $(document).ready(function() {

            $("#jobComplete").click(function() {
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

                if (jobservice.trim() !== "" && joblocation.trim() !== "" && schedrender.trim() !== "" && rqofficial.trim() !== "" && daterequested.trim() !== "" && jobnumber.trim() !== "" && feedbacknumber.trim() !== "" && supplies.trim() !== "" && causes.trim() !== "" && personnel.trim() !== ""){
                
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
                                text: "Job request created.",
                                icon: "success",
                                showConfirmButton: false,
                                timer: 1000,
                            });
                            window.location.href='../admin/admin-notice.php';
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
                        text: "Please fill up the fields.",
                        icon: "error",
                    });
                }
            });
        });

        function copyDate() {
            var dateStart = document.getElementById('dateStart').value;
            var dateFinish = document.getElementById('dateFinish');
            var sameDate = document.getElementById('sameDate');
            
            if (sameDate.checked) {
                dateFinish.value = dateStart;
            } else {
                dateFinish.value = '';
            }
        }

    </script>

</body>

</html>