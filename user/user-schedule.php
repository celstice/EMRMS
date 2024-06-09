<?php 
// USER: MANTENANCE SCHEDULES

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
                    <a href="user-records.php" class="list-group-item  py-2 ripple active-btn">
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
                            <h2>Equipment Records</h2>
                        </div>
                    </div>

                    <div id="custom-tabs" class="custom-tabs bg-dangerx d-flex">
                        <div class="d-flex justify-content-between align-items-center pt-3 ps-5 pe-5">
                            <div class="d-flex p-1">
                                <a href="user-records.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 opacity-75 border-end border-2 rounded-0">
                                    <i class="fa-solid fa-screwdriver-wrench icon p-1"></i>
                                    <h6 class="fw-lighter p-1 fsz">Equipments</h6>
                                </a>
                                <a href="user-schedule.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 border-start border-5 border-primary rounded-0 bg-primary bg-opacity-25">
                                    <i class="fa-solid fa-calendar icon p-1"></i>
                                    <h6 class="fw-mediumm p-1 fsz">Maintenance Schedules</h6>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid ps-3 pe-3">
                        <div class="table-div h-100x borderx ps-5 pe-5 pt-3 pb-5 overflow-auto">

                            <div id="add-sched" class="d-flex mt-3 mb-3">
                                <button class="btn btn-primary fsz" data-bs-toggle="modal" data-bs-target="#set">Add Schedule</button>
                            </div>

                            <table id="mntsched-tbl" class="table pt-3">
                                <thead class="text-center border-bottom border-dark fw-bolder">
                                    <th class="border-end th-bg">Equipment</th>
                                    <th class="border-end th-bg">Maintenance Schedule</th>
                                    <th class="border-end th-bg">Description</th>
                                    <th class="border-end th-bg">Maintained By</th>
                                    <th class="border-end th-bg">Remarks</th>
                                    <th class="th-bg">...</th>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    $sched = mysqli_query($connect, "SELECT maintenance_records.*,equipments.equipment_id,equipments.equip_name,equipments.mnt_sched FROM equipments JOIN maintenance_records ON equipments.equipment_id=maintenance_records.equipment_id WHERE maintenance_records.userID='$user' AND maintenance_records.done=0 AND equipments.mnt_sched=1");
                                    if (mysqli_num_rows($sched) > 0) {
                                        while ($rows = mysqli_fetch_assoc($sched)) {
                                            $mntID = $rows['mnt_id'];
                                            $last = $rows['last_mnt'];
                                            $next = $rows['next_mnt'];
                                            $by = $rows['maintained_by'];
                                            $desc = $rows['mnt_description'];
                                            $notes = $rows['notes_remarks']; ?>
                                            <tr disabled class="rowRecord">
                                                <td class="border-end text-truncate"><?php echo htmlspecialchars($rows['equip_name']); ?></td>
                                                <td class="border-end"><?php if (!empty($rows['next_mnt']) && $rows['next_mnt'] !== "0000-00-00") {echo date("F j, Y", strtotime($rows['next_mnt']));} else {echo "Set Schedule";} ?></td>
                                                <td class="border-end"><?php echo htmlspecialchars($rows['mnt_description']); ?></td>
                                                <td class="border-end"><?php echo htmlspecialchars($rows['maintained_by']); ?></td>
                                                <td class="border-end"><?php echo htmlspecialchars($rows['notes_remarks']); ?></td>
                                                <td class=" d-flex justify-content-center">
                                                    <div class="dropdown">
                                                        <a class="btn btn-success fsz dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</a>
                                                        <ul class="dropdown-menu m-0 p-0">
                                                            <li><a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#mnt-done<?php echo $mntID; ?>">Done</a></li>
                                                            <li><a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#setUpdate<?php echo $mntID; ?>">Update</a></li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Equipment-done MODAL -->
                                            <div class="modal fade" id="mnt-done<?php echo $mntID; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                            <div class="mb-4">
                                                                <h5>Mark as Done</h5>
                                                                <p>Are you sure you want to mark this Maintenance Schedule as Done?</p>
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
                                                                <button type="button" name="doneRecord" id="<?php echo $mntID; ?>" class="btn btn-primary doneRecord"><i class="fa-solid fa-square-check p-1"></i>Done</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Equipment-done MODAL END -->

                                            <!--EDIT MAINTENANCE MODAL -->
                                            <div class="modal fade" id="setUpdate<?php echo $mntID; ?>"" tabindex=" -1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header text-dark">
                                                            <h6>Update Maintenance Schedule</h6>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <form method="post" action="../config/set.php">
                                                            <input hidden name="edit-set-id" value="<?php echo $mntID; ?>">
                                                            <div class="modal-body">
                                                                <div class="m-3 text-start">
                                                                    <div class="col mb-3">
                                                                        <div class="col mb-3">
                                                                            <input type="date" name="edit-next" id="editnext" class="form-control" value="<?php echo $next; ?>" min="<?php echo $next; ?>" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col mb-3">
                                                                        <label>Maintained By:</label>
                                                                        <input type="text" name="edit-by" id="edit-by" class="form-control" value="<?php echo $by; ?>" required>
                                                                    </div>
                                                                    <div class="col mb-3">
                                                                        <label>Maintenance Description:</label>
                                                                        <input type="text" name="edit-description" id="edit-description" class="form-control" value="<?php echo $desc; ?>" required>
                                                                    </div>
                                                                    <div class="col mb-3">
                                                                        <label>Notes / Remarks:</label>
                                                                        <input type="text" name="edit-notes" id="edit-notes" class="form-control" value="<?php echo $notes; ?>" required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="submit" name="edit-set" class="btn btn-info">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- EDIT MAINTENANCE MODAL END -->
                                    
                                            <?php } } ?>
                                </tbody>
                            </table>

                        </div>
                    </div>

                    <!-- SET MAINTENANCE MODAL -->
                    <div class="modal fade" id="set" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header text-dark">
                                    <h6>Set Maintenance Schedule for:</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form method="post" action="../config/set.php" onsubmit="loading()">
                                    <div class="modal-body">
                                        <div class="m-3">
                                            <label for="equip-id">Equipment:<span class="text-danger">*</span></label>
                                            <select name="equip-id" id="equip-id" class="form-select" placeholder="..." required>
                                                <option disabled selected class="fst-italic text-muted" placeholder="Select equipment">Select equipment</option>
                                                <?php
                                                $sql = mysqli_query($connect, "SELECT * FROM equipments WHERE userID='$user' AND mnt_sched=0  AND archive=0");
                                                while ($row = mysqli_fetch_assoc($sql)) { ?>
                                                    <option value="<?php echo $row['equipment_id']; ?>"><?php echo $row['equip_name']; ?></option><br>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="m-3">
                                            <div class="col mb-3">
                                                <label>Next Maintenance Schedule:<span class="text-danger">*</span></label>
                                                <input type="date" name="next" id="next" class="form-control" min="<?php echo $currentDate; ?>" required>
                                            </div>
                                            <div class="col mb-3">
                                                <label>Maintained By:</label>
                                                <input type="text" name="by" id="by" class="form-control" required>
                                            </div>
                                            <div class="col mb-3">
                                                <label>Maintenance Description:</label>
                                                <input type="text" name="description" id="description" class="form-control" required>
                                            </div>
                                            <div class="col mb-3">
                                                <label>Notes / Remarks:</label>
                                                <input type="text" name="notes" id="notes" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" name="set" class="btn btn-info">Set Schedule</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- SET MAINTENANCE MODAL END -->

                </div>

            </div>
        </section>
    </div>

    <?php include '../include/scripts.php'; ?>


    <script>
        function loading() {
            Swal.fire({
                title: 'Creating schedule...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.loading();
                },
            });
        }

        function hideLoading() {
            Swal.close();
        }
        $(document).ready(function() {

            $(document).ready(function() {
                $('#mntsched-tbl').DataTable({
                    "order": [
                        [2, "desc"]
                    ]
                });
            });

            $('.doneRecord').on('click', function() {
                var done = $(this).attr('id');
                $.ajax({
                    url: "../config/set.php",
                    type: "POST",
                    data: {
                        done: done
                    },
                    success: function(response) {
                        console.log(response);
                        window.location.reload();
                        $(".rowRecord" + done).empty();
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
            dateNext();
        });

        function dateNext() {

            const dateNext = document.getElementById('next');
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const dateToday = `${year}-${month}-${day}`;

            dateNext.min = dateToday;
        }
    </script>
</body>

</html>