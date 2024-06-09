<?php
// ADMIN: PREVENTIVE MAINTENANCE PROGRAM/SCHEDULES
include '../config/connect.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
} else if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['verified'] == 0) {
        header('location:../verify.php');
    }
}
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
                    <a href="admin-scheduled.php" class="list-group-item  py-2 ripple active-btn">
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
            <div class="content mt-5 pb-3" id="content">

                <div class="container-fluid overflow-auto">

                    <div class="content-title text-center d-flex flex-column justify-content-center m-3 ">
                        <h3 class="">Preventive Maintenance Program</h3>
                        <h4 class="mt-2">Equipment Repair and Maintenance Services</h4>
                    </div>

                    <div class="h-100 border ps-3 pe-3 pt-3 pb-3 bg-body overflow-auto">
                        <table class="table">
                            <thead class="text-center border-bottom border-dark fw-bold">
                                <th class="border-end th-bg">Offices / Colleges/ Dorms</th>
                                <th class="border-end th-bg">RAC<br>Window<br>Type</th>
                                <th class="border-end th-bg">RAC<br>Split<br>Type</th>
                                <th class="border-end th-bg">Ref<br>Freezer</th>
                                <th class="border-end th-bg">Car<br>Aircon</th>
                                <th class="border-end th-bg">Electric<br>Fan</th>
                                <th class="border-end th-bg">Computer<br>Unit</th>
                                <th class="border-end th-bg">Type<br>Writer</th>
                                <th class="border-end th-bg">Dispenser</th>
                                <th class="border-end th-bg">Laboratory<br>Equipment</th>
                                <th class="border-end th-bg">Other<br>Equipment</th>
                                <th class="th-bg">Edit</th>
                            </thead>
                            <tbody class="text-center">
                                <tr>
                                    <td colspan="12" class="bg-light border">1st Quarter</td>
                                </tr>

                                <?php
                                include '../config/connect.php';
                                $first = mysqli_query($connect, "SELECT * FROM scheduled WHERE quarter=1");
                                while ($row = mysqli_fetch_array($first)) { ?>
                                    <tr>
                                        <td hidden><?php echo $row['scheduled_id']; ?></td>
                                        <td class="bg-light border border-end"><?php echo htmlspecialchars($row['sched_location'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['rac_window_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['rac_split_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['ref_freezer'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['car_aircon'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['electric_fan'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['computer_unit'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['type_writer'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['dispenser'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['lab_equipment'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['others'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end">
                                            <button class="btn btn-success fsz" data-bs-toggle="modal" type="button" data-bs-target="#editSched<?php echo $row['scheduled_id']; ?>">Edit</button>
                                        </td>
                                    </tr>
                                <?php include '../config/editSched-modal.php';
                                } ?>

                                <tr>
                                    <td colspan="12" class="bg-light border">2nd Quarter</td>
                                </tr>

                                <?php
                                include '../config/connect.php';
                                $second = mysqli_query($connect, "SELECT * FROM scheduled WHERE quarter=2");
                                while ($row = mysqli_fetch_array($second)) { ?>
                                    <tr>
                                        <td hidden><?php echo $row['scheduled_id']; ?></td>
                                        <td class="bg-light border border-end"><?php echo htmlspecialchars($row['sched_location'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['rac_window_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['rac_split_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['ref_freezer'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['car_aircon'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['electric_fan'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['computer_unit'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['type_writer'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['dispenser'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['lab_equipment'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['others'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end">
                                            <button class="btn btn-success fsz" data-bs-toggle="modal" type="button" data-bs-target="#editSched<?php echo $row['scheduled_id']; ?>">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                <?php include '../config/editSched-modal.php';
                                } ?>

                                <tr>
                                    <td colspan="12" class="bg-light border">3rd Quarter</td>
                                </tr>

                                <?php
                                include '../config/connect.php';
                                $third = mysqli_query($connect, "SELECT * FROM scheduled WHERE quarter=3");
                                while ($row = mysqli_fetch_array($third)) { ?>
                                    <tr>
                                        <td hidden><?php echo $row['scheduled_id']; ?></td>
                                        <td class="bg-light border border-end"><?php echo htmlspecialchars($row['sched_location'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['rac_window_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['rac_split_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['ref_freezer'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['car_aircon'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['electric_fan'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['computer_unit'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['type_writer'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['dispenser'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['lab_equipment'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['others'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end">
                                            <button class="btn btn-success fsz" data-bs-toggle="modal" type="button" data-bs-target="#editSched<?php echo $row['scheduled_id']; ?>">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>
                                <?php include '../config/editSched-modal.php';
                                } ?>

                                <tr>
                                    <td colspan="12" class="bg-light border">4th Quarter</td>
                                </tr>

                                <?php
                                include '../config/connect.php';
                                $fourth = mysqli_query($connect, "SELECT * FROM scheduled WHERE quarter=4");
                                while ($row = mysqli_fetch_array($fourth)) { ?>
                                    <tr>
                                        <td hidden><?php echo $row['scheduled_id']; ?></td>
                                        <td class="bg-light border border-end"><?php echo htmlspecialchars($row['sched_location'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['rac_window_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['rac_split_type'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['ref_freezer'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['car_aircon'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['electric_fan'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['computer_unit'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['type_writer'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['dispenser'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['lab_equipment'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end"><?php echo htmlspecialchars($row['others'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class="border-end">
                                            <button class="btn btn-success fsz" data-bs-toggle="modal" type="button" data-bs-target="#editSched<?php echo $row['scheduled_id']; ?>">
                                                Edit
                                            </button>
                                        </td>
                                    </tr>

                                <?php include '../config/editSched-modal.php';
                                } ?>

                                <tr>
                                    <?php
                                    include '../config/connect.php';
                                    $racWT = mysqli_query($connect, "SELECT SUM(rac_window_type) as racWT FROM scheduled;");
                                    $racST = mysqli_query($connect, "SELECT SUM(rac_split_type) as racST FROM scheduled;");
                                    $refFZ = mysqli_query($connect, "SELECT SUM(ref_freezer) as refFZ FROM scheduled;");
                                    $carAC = mysqli_query($connect, "SELECT SUM(car_aircon) as carAC FROM scheduled;");
                                    $eFan = mysqli_query($connect, "SELECT SUM(electric_fan) as eFan FROM scheduled;");
                                    $computer = mysqli_query($connect, "SELECT SUM(computer_unit) as computer FROM scheduled;");
                                    $typeWR = mysqli_query($connect, "SELECT SUM(type_writer) as typeWR FROM scheduled;");
                                    $dispenser = mysqli_query($connect, "SELECT SUM(dispenser) as dispenser FROM scheduled;");
                                    $labEQ = mysqli_query($connect, "SELECT SUM(lab_equipment) as labEQ FROM scheduled;");
                                    $other = mysqli_query($connect, "SELECT SUM(others) as other FROM scheduled;");
                                    ?>
                                    <td class="bg-light border">Total:</td>
                                    <td class="border-end bg-light"><?php while ($wt = mysqli_fetch_array($racWT)) {
                                                                        echo htmlspecialchars($wt['racWT'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="border-end bg-light"><?php while ($st = mysqli_fetch_array($racST)) {
                                                                        echo htmlspecialchars($st['racST'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="border-end bg-light"><?php while ($rf = mysqli_fetch_array($refFZ)) {
                                                                        echo htmlspecialchars($rf['refFZ'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="border-end bg-light"><?php while ($ca = mysqli_fetch_array($carAC)) {
                                                                        echo htmlspecialchars($ca['carAC'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="border-end bg-light"><?php while ($ef = mysqli_fetch_array($eFan)) {
                                                                        echo htmlspecialchars($ef['eFan'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="border-end bg-light"><?php while ($cu = mysqli_fetch_array($computer)) {
                                                                        echo htmlspecialchars($cu['computer'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="border-end bg-light"><?php while ($tw = mysqli_fetch_array($typeWR)) {
                                                                        echo htmlspecialchars($tw['typeWR'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="border-end bg-light"><?php while ($dp = mysqli_fetch_array($dispenser)) {
                                                                        echo htmlspecialchars($dp['dispenser'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="border-end bg-light"><?php while ($le = mysqli_fetch_array($labEQ)) {
                                                                        echo htmlspecialchars($le['labEQ'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="border-end bg-light"><?php while ($ot = mysqli_fetch_array($other)) {
                                                                        echo htmlspecialchars($ot['other'], ENT_QUOTES, 'UTF-8');
                                                                    } ?></td>
                                    <td class="bg-light border-end"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- add button | uncomment to add new sched -->
                <!-- <button class="btn btn-secondary ms-5 me-5" data-bs-toggle="modal" data-bs-target="#scheduled">Add</button> -->

            </div>
        </section>
    </div>

    <!-- Add sched MODAL -->
    <div class="modal fade modal-xl" id="scheduled" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header text-dark">
                    <h5 class="modal-title" id="">Scheduled Maintenance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                
                <form method="post" action="../config/add-sched.php">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md mb-2">
                                <label for="sched-location">Offices / Colleges / Dorms:</label>
                                <textarea rows=2 type="text" class="form-control" name="sched-location" id="sched-location" placeholder="" required></textarea>
                            </div>
                            <div class="col-md-3 mb-2">
                                <label>Quarter:</label>
                                <select class="form-control" name="quarter" id="quarter" placeholder="Quarter">
                                    <option disabled selected hidden>-</option>
                                    <option value="1">1st QUARTER</option>
                                    <option value="2">2nd QUARTER</option>
                                    <option value="3">3rd QUARTER</option>
                                    <option value="4">4th QUARTER</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md mb-2">
                                <label for="rac-window">RAC Window Type:</label>
                                <input type="number" class="form-control" name="rac-window" id="rac-window" placeholder="" required>
                            </div>
                            <div class="col-md mb-2">
                                <label for="rac-split">RAC Split Type:</label>
                                <input type="number" class="form-control" name="rac-split" id="rac-window" placeholder="" required>
                            </div>
                            <div class="col-md mb-2">
                                <label for="ref-freezer">Ref / Freezer:</label>
                                <input type="number" class="form-control" name="ref-freezer" id="ref-freezer" placeholder="" required>
                            </div>
                            <div class="col-md mb-2">
                                <label for="car-aircon">Car Aircon:</label>
                                <input type="number" class="form-control" name="car-aircon" id="car-aircon" placeholder="" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md mb-2">
                                <label for="electric-fan">Electric Fan:</label>
                                <input type="number" class="form-control" name="electric-fan" id="electric-fan" placeholder="" required>
                            </div>
                            <div class="col-md mb-2">
                                <label for="computer-unit">Computer Unit:</label>
                                <input type="number" class="form-control" name="computer-unit" id="computer-unit" placeholder="" required>
                            </div>
                            <div class="col-md mb-2">
                                <label for="type-writer">Type Writer:</label>
                                <input type="number" class="form-control" name="type-writer" id="type-writer" placeholder="" required>
                            </div>
                            <div class="col-md mb-2">
                                <label for="dispenser">Dispenser:</label>
                                <input type="number" class="form-control" name="dispenser" id="dispenser" placeholder="" required>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md mb-2">
                                <label for="lab-equipment">Laboratory Equipment:</label>
                                <input type="number" class="form-control" name="lab-equipment" id="lab-equipment" placeholder="" required>
                            </div>
                            <div class="col-md mb-2">
                                <label for="others">Other Equipment:</label>
                                <input type="number" class="form-control" name="others" id="others" placeholder="" required>
                            </div>
                            <div class="col-md mb-2">
                                <label for=""></label>
                                <input type="" class="form-control" name="" placeholder="" hidden>
                            </div>
                            <div class="col-md mb-2">
                                <label for=""></label>
                                <input type="" class="form-control" name="" placeholder="" hidden>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer d-flex justify-content-center align-items-center">
                        <button type="submit" name="scheduled" class="btn btn-warning">Add data</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script>
        function updaterecord() {
            Swal.fire({
                title: 'Updating record...',
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.updaterecord();
                },
            });
        }

        function hideLoading() {
            Swal.close();
        }
    </script>
    <?php include '../include/scripts.php'; ?>

</body>

</html>