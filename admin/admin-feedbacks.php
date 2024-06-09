<?php 

// ADMIN: FEEDBACK LIST
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
                    <a href="admin-scheduled.php" class="list-group-item  py-2 ripple">
                        <i class="fa-solid fa-calendar icon"></i>
                        <span class="nav-text">Preventive Maintenance</span>
                    </a>
                    <a href="admin-feedbacks.php" class="list-group-item  py-2 ripple active-btn">
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
            <div id="content" class="content mt-5 pb-3">

                <div class="container overflow-auto">
                    <div class="pt-3">
                        <div class="content-title d-flex justify-content-center">
                            <h2>Feedbacks</h2>
                        </div>
                    </div>

                    <div class="table-div ps-3 pe-3 pt-3 pb-5 bg-body overflow-auto">
                        <table id="feedbacks-tbl" class="table pt-3">
                            <thead class="text-center border-bottom border-dark fw-bold">
                                <tr>
                                    <th class="border-end th-bg text-truncate">Feedback Number</th>
                                    <th class="border-end th-bg text-truncate">Job Order Control Number</th>
                                    <th class="border-end th-bg">Job Service Rendered</th>
                                    <th class="border-end th-bg">Date</th>
                                    <th class="th-bg"></th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <?php
                                include '../config/connect.php';
                                $query2 = mysqli_query($connect, "SELECT * FROM feedbacks WHERE archive=0 ORDER BY feedback_id DESC");
                                while ($row = mysqli_fetch_array($query2)) { ?>
                                    <tr>
                                        <td class=""><?php echo htmlspecialchars($row['feedback_number'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class=""><?php echo htmlspecialchars($row['job_ctrl'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class=""><?php echo htmlspecialchars($row['job_service'], ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class=""><?php echo htmlspecialchars(date("F j, Y", strtotime($row['feedback_date'])), ENT_QUOTES, 'UTF-8'); ?></td>
                                        <td class=" text-truncate"><a href="admin-feedback-result.php?id=<?php echo $row['feedback_id']; ?>" class="btn btn-success fsz">View Feedback</a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>
    </div>

    <script>
        // datatable
        $(document).ready(function() {
            $('#feedbacks-tbl').DataTable({
                "order": [
                    [3, "desc"]
                ]
            });
        });
    </script>
    <?php include '../include/scripts.php'; ?>

</body>

</html>