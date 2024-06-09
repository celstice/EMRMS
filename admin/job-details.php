<?php
// ADMIN: job request details interface
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
    $request = $_GET['id'];
    $sql = mysqli_query($connect, "SELECT * FROM job_request WHERE job_id = $request");
}
$result = mysqli_fetch_array($sql);
$jobID = $result['job_id'];
$userID = $result['userID'];
$job_request = $result['job_service'];
$job_number = $result['job_control_number'];
$job_location = $result['job_location'];

$sql2 = mysqli_query($connect, "SELECT * FROM repair_records WHERE job_id = '$jobID'");
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
            <div class="container">

                <div class="content mt-5" id="content">

                    <div class="container overflow-auto">
                        <div class="content-title d-flex justify-content-center m-3">
                            <h3>Job Request Record Details</h3>
                        </div>

                        <div class="form-content">
                            <form method="post" action="../config/mnt-records.php" id="jobdetailsForm" onsubmit="requestcomplete()">
                                <?php if (isset($errors['error'])) : ?>
                                    <div class="mt-3 bg-danger bg-opacity-25 text-danger text-center rounded" id="errortext"><?= $errors['error'] ?></div>
                                <?php endif; ?>
                                <div class="row">
                                    <div class="col-md">
                                        <input hidden name="job-id" value="<?php echo $jobID; ?>">
                                        <input hidden name="user-id" value="<?php echo $userID; ?>">

                                        <div class="col-md mb-3 mt-4">
                                            <div class="col-md d-flex mb-3">
                                                <p class="p-1">Request for Job Services to be Rendered:</p><?php if (isset($errors['jobNumber'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['qtyST'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                <p class="p-1 fw-bold text-primary"><?php echo $job_request; ?></p>
                                            </div>
                                            <div class="col-sm d-flex form-group">
                                                <div class="col-md d-flex flex-column">
                                                    <label for="job-number">Job Number:</label><?php if (isset($errors['jobNumber'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['qtyST'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                    <input required class="form-control-plaintext fw-bold text-primary" name="job-number" id="job-number" value="<?php echo $job_number; ?>">
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-md d-flex flex-column">
                                                    <label for="job-location">Location:</label><?php if (isset($errors['location'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['qtyWT'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                    <input required class="form-control-plaintext fw-bold text-primary" name="job-location" id="job-location" value="<?php echo $job_location; ?>">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md mb-3 mt-">
                                            <div class="mt-1">
                                                <label for="job-render">Job Rendered:<span class="text-danger">*</span></label><?php if (isset($errors['job'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['cooling'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                <select name="job-render" id="job-render" class="form-select" required>
                                                    <option value="" disabled selected class="fst-italic text-secondary text-muted">Select category</option>
                                                    <option value="1">Aircon Cleaning</option>
                                                    <option value="2">Aircon Repair</option>
                                                    <option value="3">Aircon installation</option>
                                                    <option value="4">Electric Fan Cleaning / Repair</option>
                                                    <option value="5">Electric Fan installation</option>
                                                    <option value="6">Other Equipment Repair</option>
                                                    <option value="7">Computer Repair & Troubleshoot</option>
                                                    <option value="8">Hauling Services</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md mb-3 mt-4">
                                            <div class="col-sm d-flex form-group">
                                                <div class="col-md">
                                                    <label for="equipment">Equipment / Device:<span class="text-danger">*</span></label><?php if (isset($errors['energyST'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['energyST'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                    <input required type="text" class="form-control shadow-sm" name="equipment" id="equipment" placeholder="ex. RAC (S.T), etc.">
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-md">
                                                    <label for="unit">Number of Units:<span class="text-danger">*</span></label><?php if (isset($errors['energyWT'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['energyWT'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                    <input required type="number" class="form-control shadow-sm" name="unit" id="unit" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md mb-3 mt-4">
                                            <div class="col-sm d-flex form-group">
                                                <div class="col-md">
                                                    <label for="start-time">Time Started:<span class="text-danger">*</span></label><?php if (isset($errors['qtyST'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['qtyST'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                    <input type="time" class="form-control shadow-sm" name="start-time" id="start-time" placeholder="">
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-md">
                                                    <label for="finish-time">Time Finished:<span class="text-danger">*</span></label><?php if (isset($errors['qtyWT'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['qtyWT'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                    <input type="time" class="form-control shadow-sm" name="finish-time" id="finish-time" placeholder="">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md mb-3 mt-4">
                                            <div class="col-s d-flex form-group">
                                                <div class="col-md">
                                                    <div class="d-flex flex-column">
                                                        <label for="split-type">Date Started:<span class="text-danger">*</span></label><?php if (isset($errors['qtyST'])) : ?><span id="errortext" class="text-danger text-center m-1 p-1"><?= $errors['qtyST'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span><?php endif; ?>
                                                        <input required type="date" class="form-control" id="dateStart" name="dateStart" placeholder="" required>
                                                    </div>
                                                </div>
                                                <div class="col-sm-1"></div>
                                                <div class="col-md">
                                                    <div class="d-flex align-items-center">
                                                        <label for="dateStart">Date Finished:<span class="text-danger">*</span></label>
                                                        <input required type="checkbox" class="form-check-input border-dark m-2" id="sameDate" name="sameDate" value="" onclick="copyDate()">
                                                        <label for="sameDate">Same with Date Started</label>
                                                    </div>
                                                    <input required type="date" class="form-control" id="dateFinish" name="dateFinish" placeholder="" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md mb-3 mt-4 d-flex justify-content-between bg-infox">
                                            <div class="">
                                                <a href="admin-jobrequest.php" name="" id="" class="btn btn-danger">Cancel</a>
                                            </div>
                                            <div class=" btnAdd">
                                                <button type="submit" name="save-repair" id="save-repair" class="btn btn-warning">Done</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <!-- ADD JOB DETAILS MODAL -->
    <div class="modal fade" id="jobDetails" tabindex="-1" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="card text-center border-0 m-5 d-flex justify-content-center">
                    <div class="mb-4">
                        <h5>Job Request Complete</h5>
                        <p>Complete the details to mark as Done.</p>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ADD JOB DETAILS MODAL end-->

    <?php include '../include/scripts.php'; ?>
    
    <script>
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

        function requestcomplete() {
            Swal.fire({
                title: 'Adding to records...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.requestcomplete();
                },
            });
        }

        function hideLoading() {
            Swal.close();
        }
    </script>

</body>

</html>