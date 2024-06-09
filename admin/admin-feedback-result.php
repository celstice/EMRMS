<?php 
// ADMIN: VIEW FEEDBACK RESULT 
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
    $feedback = $_GET['id'];
    $sql = mysqli_query($connect, "SELECT * FROM feedbacks WHERE feedback_id = $feedback");
}

$data = mysqli_fetch_array($sql);
$user_id = $data['job_id'];
$getUser = mysqli_query($connect, "SELECT requesting_official FROM job_request WHERE job_id = '$user_id'");
$user = mysqli_fetch_assoc($getUser);
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
        <section id="" class="">
            <div id="content" class="content mt-5  pb-5">

                <a href="admin-feedbacks.php" id="back" class="fst-italic ms-3 text-decoration-none text-dark">
                    <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to previous page</span>
                </a>

                <div class="container mb-5">

                    <!-- FEEDBACK HEADER -->
                    <div class="feedback-header">
                        <div class="container pt-3 pb-3">
                            <div class="row">
                                <div class="col d-flex justify-content-end p-3">
                                    <div class="p-3">
                                        <img class="feedback-logo" id="feedback-logo" src="../assets/img/clsu-logo.png">
                                    </div>
                                </div>

                                <div class="col-7 justify-content-center ms-3">
                                    <div class="text-center m-0">
                                        <p class="mb-0 mt-0 p-0">REPUBLIC OF THE PHILIPPINES</p>
                                        <p class="mb-0 mt-0 p-0 fw-bolder"><strong>CENTRAL LUZON STATE UNIVERSITY</strong></p>
                                        <p class="mb-0 mt-0 p-0">Science City of Muñoz, Nueva Ecija</p>
                                        <p class="h5 mb-3 mt-3">OFFICE OF THE UNIVERSITY PRESIDENT</p>
                                    </div>

                                    <div class="text-center">
                                        <h5 class="mt-3 mb-3">FEEDBACK FORM</h5>
                                        <div class="d-flex justify-content-center align-items-center ms-5 me-5 ps-5 pe-5">
                                            <label for="office-rated" class="p-1">Office Rated: </label>
                                            <p class="p-1 fw-bold"><?php echo $data['office']; ?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="col text-start d-flex align-items-center p-0 m-0">
                                    <h6 class="fw-bolder">Feedback No.&nbsp;<?php echo $data['feedback_number'] ?></h6>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- USER / REPAIR INFO -->
                    <div class="container-fluid">
                        <table class="table border-0 ">
                            <tr class="border-0 d-flex justify-content-around">
                                <td class="m-0 h6 border-0 d-flex flex-column text-start">
                                    <label for="transaction" class="fst-italic">Type of Transaction / Service: </label>
                                    <p class="p-1"><?php echo $data['job_service'] ?></p>
                                </td>
                                <td class="m-0 h6 border-0 d-flex flex-column text-start">
                                    <label for="employee" class="fst-italic">Name of Employee: </label>
                                    <p><?php echo $user['requesting_official']; ?></p>
                                </td>
                                <td class="m-0 h6 border-0 d-flex flex-column text-start">
                                    <label for="date" class="fst-italic">Date: </label>
                                    <p class="p-1"><?php echo date("F j, Y", strtotime($data['feedback_date'])); ?></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <form action="../config/generate-user-feedback.php" method="post">
                        <input hidden name="fid" id="fid" value="<?php echo $data['feedback_id']; ?>">
                        <div class="card-body">
                            <div class="container-fluid">

                                <table class="table">
                                    <thead class="text-center text-dark border">
                                        <th class="border-end bg-light fsz" colspan="">Service Quality</th>
                                        <th class="border-end bg-light fsz">Needs Improvement (1)</th>
                                        <th class="border-end bg-light fsz">Fair (2)</th>
                                        <th class="border-end bg-light fsz">Good(3)</th>
                                        <th class="border-end bg-light fsz">Very<br>Good (4)</th>
                                        <th class="border-end bg-light fsz">Excellent<br>(5)</th>
                                    </thead>
                                    <tbody class="" id="feedback-btn">
                                        <tr class="border">
                                            <td colspan="6" class="m-1 p-2 text-center fsz">RESPONSIVENESS</td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">1. The service is provided promptly / timely.
                                                <span class="fst-italic tg-text">Mabilis ang serbisyo at nasa tamang oras.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive1'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive1'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive1'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive1'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive1'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">2. The personnel show willingness to help the client.
                                                <span class="fst-italic tg-text">Nagpapakita ng kagustuhang maglingkod ang mga kawani.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive2'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive2'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive2'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive2'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['responsive2'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td colspan="6" class="m-1 p-2 text-center fsz">RELIABILITY</td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">1. The service exhibits quality and high standard.
                                                <span class="fst-italic tg-text">Nagpapamalas ng kalidad at mataas na pamnatayan ang serbisyo.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability1'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else { echo ''; } ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability1'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability1'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability1'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability1'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">2. The service meets the expectation of the client.
                                                <span class="fst-italic tg-text">Nakapaglilingkod nang ayon sa inaasahan ng kliyente.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability2'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability2'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability2'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability2'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['reliability2'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td colspan="6" class="m-1 p-2 text-center fsz">ACCESS AND FACILITIES</td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">1. The facilities are clean, organized and accessible.
                                                <span class="fst-italic tg-text">Malinis, maayos at madaling marating ang pasilidad.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['facility'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['facility'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['facility'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['facility'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['facility'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">2. Online Services are made available.
                                                <span class="fst-italic tg-text">Mayroong serbisyong online.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['access'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['access'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['access'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['access'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['access'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td colspan="6" class="m-1 p-2 text-center fsz">COMMUNICATION</td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">1. The instructions and information are clear.
                                                <span class="fst-italic tg-text">Malinaw ang mga tagubilin at impormasyon.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication1'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication1'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication1'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication1'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication1'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">2. The personnel explains te service effectively.
                                                <span class="fst-italic tg-text">Naipaliliwanag nang mabisa ng mga kawani ang kanilang serbisyo.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication2'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication2'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication2'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else { echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication2'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['communication2'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td colspan="6" class="m-1 p-2 text-center fsz">COST</td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">1. The billing process, method and payment are timely and appropriate.
                                                <span class="fst-italic tg-text">Nasa oras at angkop ang proseso ng paniningil at metodo ng pagbabayad.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost1'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost1'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost1'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost1'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost1'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">2. The cost of service is fair and reasonable.
                                                <span class="fst-italic tg-text">Angkop at makatwiran ang halaga ng serbisyo.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost2'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost2'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost2'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost2'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['cost2'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td colspan="6" class="m-1 p-2 text-center fsz">INTEGRITY</td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">The employees demonstrate honesty, justice, fairness and trustworthiness.
                                                <span class="fst-italic tg-text">Matapat, makatarungan, mapagkakatiwalaan at tapat ang mga kawani.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['integrity'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['integrity'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['integrity'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['integrity'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['integrity'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td colspan="6" class="m-1 p-2 text-center fsz">ASSURANCE</td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">The frontline staff are knowledgeable, helpful, courteous and understand client needs.
                                                <span class="fst-italic tg-text">Maalam, matulungin, magalang at maunawain sa mga pangangailangan ng kliyente ang mga pangunang empleyado.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['assurance'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['assurance'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['assurance'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['assurance'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['assurance'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td colspan="6" class="m-1 p-2 text-center fsz">OUTCOME</td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border-0 d-flex flex-column">The desired service is achieved.
                                                <span class="fst-italic tg-text">Naabot ang ninanais na serbisyo.</span>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['outcome'] == "1") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['outcome'] == "2") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['outcome'] == "3") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['outcome'] == "4") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                            <td class="border">
                                                <div class="text-center"><?php if ($data['outcome'] == "5") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></div>
                                            </td>
                                        </tr>
                                        <tr class="border">
                                            <td class="border ps-3" colspan=""> Comment / Suggestion for Improvement: </td>
                                            <td class="" colspan="6"><?php echo $data['comments'] ?></td>
                                        </tr>
                                        <tr class="">
                                            <td class="d-flex align-items-center ps-3" colspan="4">Download as: &nbsp;
                                                <div class="m-1">
                                                    <button type="submit" name="feedback-pdf" id="feedback-pdf" class="btn btn-danger">PDF</button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </form>

                </div>

            </div>
        </section>
    </div>

    <?php include '../include/scripts.php'; ?>

</body>

</html>