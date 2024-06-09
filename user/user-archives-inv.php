<?php 
// USER: INV Archive
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
                    <a href="user-notice.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-snowflake icon"></i>
                        <span class="nav-text">Aircon Maintenance</span>
                    </a>
                    <a href="user-inventory.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-box-open icon"></i>
                        <span class="nav-text">Inventory</span>
                    </a>
                    <a href="user-archives.php" class="list-group-item  py-2 ripple active-btn">
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
        <section id="" class="">
            <div class="content mt-5 pb-5" id="content">

                <div class="">

                    <div class="pt-3">
                        <div class="content-title d-flex justify-content-center">
                            <h2>Archives</h2>
                        </div>
                    </div>

                    <div id="custom-tabs" class="custom-tabs bg-dangerx d-flex">
                    <div class="d-flex justify-content-between align-items-center ps-5 pe-5 pt-3">
                        <div class="d-flex p-1">
                            <a href="user-archives.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 opacity-75 border-end border-2 rounded-0">
                                <i class="fa-solid fa-folder icon p-1"></i>
                                <h6 class="fw-lighter p-1 fsz">Equipment Records</h6>
                            </a>
                            <a href="user-archives-inv.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 border-start border-5 border-primary rounded-0 bg-primary bg-opacity-25">
                                <i class="fa-solid fa-box-open icon p-1"></i>
                                <h6 class="fw-mediumm p-1 fsz">Inventory</h6>
                            </a>
                        </div>
                    </div>
                    </div>
                    
                    <div class="container-fluid ps-3 pe-3">
                        <div class="table-div h-100x borderx ps-5 pe-5 pt-3 pb-5 overflow-auto">
                            <table id="userarchiveinv-tbl" class="table pt-3">
                                <thead class="text-center border-bottom border-dark fw-bold">
                                    <tr>
                                        <th hidden class="th-bg">ID</th>
                                        <th class="th-bg">Item</th>
                                        <th class="th-bg text-end">...</th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    <?php
                                    $eq = mysqli_query($connect, "SELECT * FROM user_inventory WHERE archive=1 AND userID='$user'");
                                    if (mysqli_num_rows($eq) > 0) {
                                        while ($row = mysqli_fetch_assoc($eq)) {
                                    ?>
                                            <tr class="tr">
                                                <td hidden class=""><?php echo htmlspecialchars($row['inv_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class=""><?php echo htmlspecialchars($row['inv_item'], ENT_QUOTES, 'UTF-8'); ?></td>
                                                <td class="text-center d-flex justify-content-end">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="m-1">
                                                            <button type="button" class="btn btn-success fsz d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#restore<?php echo $row['inv_id']; ?>"><i class="fa-solid fa-arrow-up-from-bracket m-1"></i>Restore</button>
                                                        </div>
                                                        <div class="m-1">
                                                            <button type="button" class="btn btn-danger fsz d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#delete<?php echo $row['inv_id']; ?>"><i class="fa-solid fa-trash-can m-1"></i>Delete</button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            
                                            <!--DELETE MODAL -->
                                            <div class="modal fade" id="delete<?php echo $row['inv_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                            <div class="mb-4">
                                                                <h5>Delete permanently.</h5>
                                                                <p>Are you sure you want to delete this record?<br>This action cannot be undone.</p>
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal" aria-label="NO">NO</button>
                                                                <button type="button" name="deleteINV" id="<?php echo $row['inv_id']; ?>" class="btn btn-danger deleteINV">YES</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- DELETE MODAL END -->

                                            <!--RESTORE MODAL -->
                                            <div class="modal fade" id="restore<?php echo $row['inv_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <input hidden name="equipID" value="<?php echo $row['inv_id'] ?>">
                                                        <div class="card text-center border-0 m-5 d-flex justify-content-center">
                                                            <div class="mb-4">
                                                                <h5>Restore record.</h5>
                                                                <p>Are you sure you want to restore this record?</p>
                                                            </div>
                                                            <div class="d-flex justify-content-center">
                                                                <button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal" aria-label="NO">NO</button>
                                                                <button type="button" name="restoreINV" id="<?php echo $row['inv_id']; ?>" class="btn btn-success me-2 restoreINV">YES</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- RESTORE MODAL END -->

                                    <?php } } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            // datatable
            $('#userarchiveinv-tbl').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });

            //restore button
            $('.restoreINV').on('click', function() {
                var restoreINV = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/archive.php",
                    data: {
                        restoreINV: restoreINV
                    },
                    success: function(response) {
                        console.log(response);
                        window.location.reload();
                        $(".tr" + restoreINV).empty();
                        Swal.fire({
                            title: 'Restoring...',
                            allowOutsideClick: false,
                            showConfirmButton: false,

                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

            //delete button
            $('.deleteINV').on('click', function() {
                var deleteINV = $(this).attr('id');
                $.ajax({
                    type: "POST",
                    url: "../config/archive.php",
                    data: {
                        deleteINV: deleteINV
                    },
                    success: function(response) {
                        console.log(response);
                        window.location.reload();
                        $(".tr" + deleteINV).empty();
                        Swal.fire({
                            title: 'Deleting...',
                            allowOutsideClick: false,
                            showConfirmButton: false,

                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });

        });
    </script>
    <?php include '../include/scripts.php'; ?>

</body>

</html>