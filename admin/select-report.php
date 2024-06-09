<?php
// ADMIN: View Selected report before download
include '../config/connect.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('location:../login.php');
} else if (isset($_SESSION['user'])) {
    if ($_SESSION['user']['verified'] == 0) {
        header('location:../verify.php');
    }
}

if (isset($_POST['select-report'])) {

    // FROM DATE
    $Fmonth = $_POST['from-month'];
    $Fyear = $_POST['from-year'];
    $fromDate = $Fyear . "-" . $Fmonth;

    // TO DATE
    $Tmonth = $_POST['to-month'];
    $Tyear = $_POST['to-year'];
    $toDate = $Tyear . "-" . $Tmonth;

    $from = date("Y-m-01", strtotime($fromDate));
    $to = date("Y-m-t", strtotime($toDate));

    $evaluation_period = date("F Y", strtotime($from)) . " - " . date("F Y", strtotime($to));

    $rate = mysqli_query($connect, "SELECT COUNT(*) as raters  FROM feedbacks WHERE feedback_date BETWEEN '$from' AND '$to'");
    $rater = mysqli_fetch_assoc($rate);
    $raters = $rater['raters'];
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
                <div id="content" class="content mt-5 pt- pb-5">

                    <div class="report-header">
                        <div class="container pt- pb-">
                            <div class="row">
                                <div class="col-2 m-0 p-0 d-flex justify-content-end">
                                    <img class="report-logo" id="report-logo" src="../assets/img/clsu-logo.png">
                                </div>
                                <div class="col-8 m-0 p-0">
                                    <div class="text-center mt-3">
                                        <p class="mb-0 mt-0 p-0">REPUBLIC OF THE PHILIPPINES</p>
                                        <p class="mb-0 mt-0 p-0 fw-bolder"><strong>CENTRAL LUZON STATE UNIVERSITY</strong></p>
                                        <p class="mb-0 mt-0 p-0">Science City of Muñoz, Nueva Ecija</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form method="post" action="../config/generate-reports.php">
                        
                        <div class="container ps-5 pe-5 mb-3">
                            <div class="text-center">
                                <p class="h5 fw-bold mb-3 mt-4">OFFICE FEEDBACK REPORT</p>
                                <h5 class="mt-2 mb-1 fw-bold">Office Rated: ERMS - PPSDS</h5>
                                <div class="d-flex flex-column justify-content-center align-items-center ms-5 me-5 ps-5 pe-5">
                                    <p class="p-1 fw-bold">Evaluation Period:&nbsp;</p>
                                    <input name="evaluation" id="evaluation" value="<?php echo $evaluation_period; ?>" class="p-0 m-0 border-0 fw-bold form-control text-center">
                                </div>
                                <div class="text-start mt-3 d-flex align-items-center">
                                    <input hidden name="raters" value="<?php echo $raters; ?>">
                                    <h6>This is the summary report on the feedback given by <span class="fw-bold"><u> <?php echo str_repeat('&nbsp;', 2); ?><?php echo $raters; ?><?php echo str_repeat('&nbsp;', 2); ?></u></span> raters / evaluators.</h6>
                                </div>
                            </div>
                        </div>

                        <div class="container ps-5 pe-5 mb-3">
                            <div class="m-3">
                                <h6>Type of Services rendered within the evaluation period:</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border border-dark">
                                    <thead>
                                        <th class="border">Type</th>
                                        <th class="border">Frequency</th>
                                        <th class="border">Percent</th>
                                    </thead>
                                    <tr>
                                        <?php
                                        include '../config/function.php';;
                                        ?>
                                        <td class="border">Air-con Cleaned</td>
                                        <td class="border text-center">
                                            <input value="<?php echo $service1; ?>" name="service1" id="service1" class="text-center border-0 m-0 p-0">
                                        </td>
                                        <td class="border text-center">
                                            <input value="<?php echo $percent1; ?>" name="percent1" id="percent1" class="text-center border-0 m-0 p-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">Air-con Repair</td>
                                        <td class="border text-center">
                                            <input value="<?php echo $service2; ?>" name="service2" id="service2" class="text-center border-0 m-0 p-0">
                                        </td>
                                        <td class="border text-center">
                                            <input value="<?php echo $percent2; ?>" name="percent2" id="percent2" class="text-center border-0 m-0 p-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">Air-con Installed</td>
                                        <td class="border text-center">
                                            <input value="<?php echo $service3; ?>" name="service3" id="service3" class="text-center border-0 m-0 p-0">
                                        </td>
                                        <td class="border text-center">
                                            <input value="<?php echo $percent3; ?>" name="percent3" id="percent3" class="text-center border-0 m-0 p-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">Electric Fan Cleaned / Repair</td>
                                        <td class="border text-center">
                                            <input value="<?php echo $service4; ?>" name="service4" id="service4" class="text-center border-0 m-0 p-0">
                                        </td>
                                        <td class="border text-center">
                                            <input value="<?php echo $percent4; ?>" name="percent4" id="percent4" class="text-center border-0 m-0 p-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">Electric Fan Installed</td>
                                        <td class="border text-center">
                                            <input value="<?php echo $service5; ?>" name="service5" id="service5" class="text-center border-0 m-0 p-0">
                                        </td>
                                        <td class="border text-center">
                                            <input value="<?php echo $percent5; ?>" name="percent5" id="percent5" class="text-center border-0 m-0 p-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">Other Equipment Repair</td>
                                        <td class="border text-center">
                                            <input value="<?php echo $service6; ?>" name="service6" id="service6" class="text-center border-0 m-0 p-0">
                                        </td>
                                        <td class="border text-center">
                                            <input value="<?php echo $percent6; ?>" name="percent6" id="percent6" class="text-center border-0 m-0 p-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">Computer Repair & Troubleshoot</td>
                                        <td class="border text-center">
                                            <input value="<?php echo $service7; ?>" name="service7" id="service7" class="text-center border-0 m-0 p-0">
                                        </td>
                                        <td class="border text-center">
                                            <input value="<?php echo $percent7; ?>" name="percent7" id="percent7" class="text-center border-0 m-0 p-0">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border">Hauling Services</td>
                                        <td class="border text-center">
                                            <input value="<?php echo $service8; ?>" name="service8" id="service8" class="text-center border-0 m-0 p-0">
                                        </td>
                                        <td class="border text-center">
                                            <input value="<?php echo $percent8; ?>" name="percent8" id="percent8" class="text-center border-0 m-0 p-0">
                                        </td>
                                    </tr>
                                    <tr class="text-center fw-bold">
                                        <td class="border">Total</td>
                                        <td class="border text-center">
                                            <input value="<?php echo $total_job; ?>" name="total-job" id="total-job" class="text-center fw-bold border-0 m-0 p-0">
                                        </td>
                                        <td class="border text-center">
                                            <input value="100%" class="fw-bold text-center border-0 m-0 p-0">
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- RESPONSIVENESS -->
                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">I. RESPONSIVENESS (PAGTUGON)</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border">
                                    <tr>
                                        <th class="border" rowspan=3>RESPONSIVENESS (PAGTUGON)</th>
                                        <th class="border" colspan="5">Frequency Ratings</th>
                                        <th class="border" rowspan="3">MEAN</th>
                                        <th class="border" rowspan="3">ADJECTIVAL RATING</th>
                                    </tr>
                                    <tr>
                                        <th class="border">NI</th>
                                        <th class="border">F</th>
                                        <th class="border">G</th>
                                        <th class="border">VG</th>
                                        <th class="border">E</th>
                                    </tr>
                                    <tr>
                                        <th class="border">1</th>
                                        <th class="border">2</th>
                                        <th class="border">3</th>
                                        <th class="border">4</th>
                                        <th class="border">5</th>
                                    </tr>

                                    <tr class="text-center">
                                        <td class="border">1. The service is provided promptly / timely. <br><span class="fst-italic">Mabilis ang serbisyo at nasa tamang oras.</span></td>
                                        <td class="border text-center"><input name="responsive1-1" id="responsive1-1" value="<?php echo $responsive1_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="responsive1-2" id="responsive1-2" value="<?php echo $responsive1_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="responsive1-3" id="responsive1-3" value="<?php echo $responsive1_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="responsive1-4" id="responsive1-4" value="<?php echo $responsive1_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="responsive1-5" id="responsive1-5" value="<?php echo $responsive1_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="rs1-mean" id="rs1-mean" value="<?php echo $rs1Mean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="rs1-rate" id="rs1-rate" value="<?php echo AdRating($rs1Mean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr>
                                        <td class="border">2. The personnel show willingness to help the client. <br><span class="fst-italic">Nagpapakita ng kagustuhang maglingkod ang mga kawani.</span></td>
                                        <td class="border text-center"><input name="responsive2-1" id="responsive2-1" value="<?php echo $responsive2_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="responsive2-2" id="responsive2-2" value="<?php echo $responsive2_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="responsive2-3" id="responsive2-3" value="<?php echo $responsive2_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="responsive2-4" id="responsive2-4" value="<?php echo $responsive2_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="responsive2-5" id="responsive2-5" value="<?php echo $responsive2_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="rs2-mean" id="rs2-mean" value="<?php echo $rs2Mean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="rs2-rate" id="rs2-rate" value="<?php echo AdRating($rs2Mean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr class="text-center fw-bold">
                                        <td class="border" colspan="6">Mean Rating for Responsiveness (Pagtugon)</td>
                                        <td class="border"><input name="rs-mean" id="rs-mean" value="<?php echo $rsMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- RELIABILITY -->
                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">II. RELIABILITY (PAGIGING MAAASAHAN)</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border">
                                    <tr>
                                        <th class="border" rowspan=3>RELIABILITY (PAGIGING MAAASAHAN)</th>
                                        <th class="border" colspan="5">Frequency Ratings</th>
                                        <th class="border" rowspan="3">MEAN</th>
                                        <th class="border" rowspan="3">ADJECTIVAL RATING</th>
                                    </tr>
                                    <tr>
                                        <th class="border">NI</th>
                                        <th class="border">F</th>
                                        <th class="border">G</th>
                                        <th class="border">VG</th>
                                        <th class="border">E</th>
                                    </tr>
                                    <tr>
                                        <th class="border">1</th>
                                        <th class="border">2</th>
                                        <th class="border">3</th>
                                        <th class="border">4</th>
                                        <th class="border">5</th>
                                    </tr>

                                    <tr>
                                        <td class="border">1. The service exhibits quality and high standard. <br><span class="fst-italic">Nagpapamalas ng kalidad at mataas na pamnatayan ang serbisyo.</span></td>
                                        <td class="border text-center"><input name="reliability1-1" id="reliability1-1" value="<?php echo $reliability1_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="reliability1-2" id="reliability1-2" value="<?php echo $reliability1_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="reliability1-3" id="reliability1-3" value="<?php echo $reliability1_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="reliability1-4" id="reliability1-4" value="<?php echo $reliability1_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="reliability1-5" id="reliability1-5" value="<?php echo $reliability1_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="rl1-mean" id="rl1-mean" value="<?php echo $rl1Mean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="rl1-rate" id="rl1-rate" value="<?php echo AdRating($rl1Mean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr>
                                        <td class="border">2. The service meets the expectations of the client. <br><span class="fst-italic">Nakapaglilingkod nang ayon sa inaasahan ng kliyente.</span></td>
                                        <td class="border text-center"><input name="reliability2-1" id="reliability2-1" value="<?php echo $reliability2_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="reliability2-2" id="reliability2-2" value="<?php echo $reliability2_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="reliability2-3" id="reliability2-3" value="<?php echo $reliability2_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="reliability2-4" id="reliability2-4" value="<?php echo $reliability2_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="reliability2-5" id="reliability2-5" value="<?php echo $reliability2_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="rl2-mean" id="rl2-mean" value="<?php echo $rl2Mean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="rl2-rate" id="rl2-rate" value="<?php echo AdRating($rl2Mean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr class="text-center fw-bold">
                                        <td class="border" colspan="6">Mean Rating for Reliability (Pagiging Maaasahan)</td>
                                        <td class="border"><input name="rl-mean" id="rl-mean" value="<?php echo $rlMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- ACCESS AND FACILITIES -->
                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">III. ACCESS AND FACILITIES (PASILIDAD)</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border">
                                    <tr>
                                        <th class="border" rowspan=3>ACCESS AND FACILITIES (PASILIDAD)</th>
                                        <th class="border" colspan="5">Frequency Ratings</th>
                                        <th class="border" rowspan="3">MEAN</th>
                                        <th class="border" rowspan="3">ADJECTIVAL RATING</th>
                                    </tr>
                                    <tr>
                                        <th class="border">NI</th>
                                        <th class="border">F</th>
                                        <th class="border">G</th>
                                        <th class="border">VG</th>
                                        <th class="border">E</th>
                                    </tr>
                                    <tr>
                                        <th class="border">1</th>
                                        <th class="border">2</th>
                                        <th class="border">3</th>
                                        <th class="border">4</th>
                                        <th class="border">5</th>
                                    </tr>

                                    <tr>
                                        <td class="border">1. The facilities are clean, organized and accessible. <br><span class="fst-italic">Malinis, maayos at madaling marating ang pasilidad.</span></td>
                                        <td class="border text-center"><input name="facility-1" id="facility-1" value="<?php echo $facility_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="facility-2" id="facility-2" value="<?php echo $facility_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="facility-3" id="facility-3" value="<?php echo $facility_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="facility-4" id="facility-4" value="<?php echo $facility_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="facility-5" id="facility-5" value="<?php echo $facility_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="fac-mean" id="fac-mean" value="<?php echo $facilityMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="fac-rate" id="fac-rate" value="<?php echo AdRating($facilityMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr>
                                        <td class="border">2. Online services are made available. <br><span class="fst-italic">Mayroong serbisyong online.</span></td>
                                        <td class="border text-center"><input name="access-1" id="access-1" value="<?php echo $access_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="access-2" id="access-2" value="<?php echo $access_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="access-3" id="access-3" value="<?php echo $access_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="access-4" id="access-4" value="<?php echo $access_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="access-5" id="access-5" value="<?php echo $access_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="acc-mean" id="acc-mean" value="<?php echo $accessMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="acc-rate" id="acc-rate" value="<?php echo AdRating($accessMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr class="text-center fw-bold">
                                        <td class="border" colspan="6">Mean Rating for Access and Facilities (Pasilidad)</td>
                                        <td class="border"><input name="af-mean" id="af-mean" value="<?php echo $AFMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- COMMUNICATION -->
                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">IV. COMMUNICATION (KOMUNIKASYON)</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border">
                                    <tr>
                                        <th class="border" rowspan=3>COMMUNICATION (KOMUNIKASYON)</th>
                                        <th class="border" colspan="5">Frequency Ratings</th>
                                        <th class="border" rowspan="3">MEAN</th>
                                        <th class="border" rowspan="3">ADJECTIVAL RATING</th>
                                    </tr>
                                    <tr>
                                        <th class="border">NI</th>
                                        <th class="border">F</th>
                                        <th class="border">G</th>
                                        <th class="border">VG</th>
                                        <th class="border">E</th>
                                    </tr>
                                    <tr>
                                        <th class="border">1</th>
                                        <th class="border">2</th>
                                        <th class="border">3</th>
                                        <th class="border">4</th>
                                        <th class="border">5</th>
                                    </tr>

                                    <tr>
                                        <td class="border">1. The instructions and information are clear. <br><span class="fst-italic">Malinaw ang mga tagubilin at impormasyon.</span></td>
                                        <td class="border text-center"><input name="comm1-1" id="comm1-1" value="<?php echo $communication1_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm1-2" id="comm1-2" value="<?php echo $communication1_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm1-3" id="comm1-3" value="<?php echo $communication1_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm1-4" id="comm1-4" value="<?php echo $communication1_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm1-5" id="comm1-5" value="<?php echo $communication1_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm1-mean" id="comm1-mean" value="<?php echo $comm1Mean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm1-rate" id="comm1-rate" value="<?php echo AdRating($comm1Mean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr>
                                        <td class="border">2. The personnel explains the service effectively. <br><span class="fst-italic">Naipaliliwanag nang mabisa ng mga kawani ang kanilang serbisyo.</span></td>
                                        <td class="border text-center"><input name="comm2-1" id="comm2-1" value="<?php echo $communication2_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm2-2" id="comm2-2" value="<?php echo $communication2_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm2-3" id="comm2-3" value="<?php echo $communication2_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm2-4" id="comm2-4" value="<?php echo $communication2_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm2-5" id="comm2-5" value="<?php echo $communication2_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm2-mean" id="comm2-mean" value="<?php echo $comm2Mean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="comm2-rate" id="comm2-rate" value="<?php echo AdRating($comm2Mean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr class="text-center fw-bold">
                                        <td class="border" colspan="6">Mean Rating for Communication (Komunikasyon)</td>
                                        <td class="border"><input name="comm-mean" id="comm-mean" value="<?php echo $commMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- COSTS -->
                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">V. COSTS (HALAGA)</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border">
                                    <tr>
                                        <th class="border" rowspan=3> COSTS (HALAGA)</th>
                                        <th class="border" colspan="5">Frequency Ratings</th>
                                        <th class="border" rowspan="3">MEAN</th>
                                        <th class="border" rowspan="3">ADJECTIVAL RATING</th>
                                    </tr>
                                    <tr>
                                        <th class="border">NI</th>
                                        <th class="border">F</th>
                                        <th class="border">G</th>
                                        <th class="border">VG</th>
                                        <th class="border">E</th>
                                    </tr>
                                    <tr>
                                        <th class="border">1</th>
                                        <th class="border">2</th>
                                        <th class="border">3</th>
                                        <th class="border">4</th>
                                        <th class="border">5</th>
                                    </tr>

                                    <tr>
                                        <td class="border">1. The billing process, method and payment procedure are timely and appropriate. <br><span class="fst-italic">Nasa oras at angkop ang proseso ng paniningil at metodo ng pagbabayad.</span></td>
                                        <td class="border text-center"><input name="cost1-1" id="cost1-1" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cost1-2" id="cost1-2" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cost1-3" id="cost1-3" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cost1-4" id="cost1-4" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cost1-5" id="cost1-5" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cs1-mean" id="cs1-mean" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cs1-rate" id="cs1-rate" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr>
                                        <td class="border">2. The cost of service is fair and reasonable. <br><span class="fst-italic">Angkop at mkatwiran ang halaga ng serbisyo.</span></td>
                                        <td class="border text-center"><input name="cost2-1" id="cost2-1" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cost2-2" id="cost2-2" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cost2-3" id="cost2-3" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cost2-4" id="cost2-4" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cost2-5" id="cost2-5" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cs2-mean" id="cs2-mean" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="cs2-rate" id="cs2-rate" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr class="text-center fw-bold">
                                        <td class="border" colspan="6">Mean Rating for Costs (Halaga)</td>
                                        <td class="border"><input name="cost-mean" id="cost-mean" value="<?php echo ""; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- INTEGRITY -->
                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">VI. INTEGRITY (INTEGRIDAD)</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border">
                                    <tr>
                                        <th class="border" rowspan=3>INTEGRITY (INTEGRIDAD)</th>
                                        <th class="border" colspan="5">Frequency Ratings</th>
                                        <th class="border" rowspan="3">MEAN</th>
                                        <th class="border" rowspan="3">ADJECTIVAL RATING</th>
                                    </tr>
                                    <tr>
                                        <th class="border">NI</th>
                                        <th class="border">F</th>
                                        <th class="border">G</th>
                                        <th class="border">VG</th>
                                        <th class="border">E</th>
                                    </tr>
                                    <tr>
                                        <th class="border">1</th>
                                        <th class="border">2</th>
                                        <th class="border">3</th>
                                        <th class="border">4</th>
                                        <th class="border">5</th>
                                    </tr>

                                    <tr>
                                        <td class="border">The employees demonstrate honesty, justice, fairness and trustworthiness. <br><span class="fst-italic">Matapat, makatarungan, mapagkakatiwalaan at tapat ang mga kawani.</span></td>
                                        <td class="border text-center"><input name="intg-1" id="intg-1" value="<?php echo $integrity_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="intg-2" id="intg-2" value="<?php echo $integrity_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="intg-3" id="intg-3" value="<?php echo $integrity_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="intg-4" id="intg-4" value="<?php echo $integrity_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="intg-5" id="intg-5" value="<?php echo $integrity_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="intg-mean" id="intg-mean" value="<?php echo $intgMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="intg-rate" id="intg-rate" value="<?php echo AdRating($intgMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr class="text-center fw-bold">
                                        <td class="border" colspan="6">Mean Rating for Integrity (Integridad)</td>
                                        <td class="border"><input name="integ-mean" id="integ-mean" value="<?php echo $intgMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- ASSURANCE -->
                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">VII. ASSURANCE (KASIGURUHAN)</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border">
                                    <tr>
                                        <th class="border" rowspan=3>ASSURANCE (KASIGURUHAN)</th>
                                        <th class="border" colspan="5">Frequency Ratings</th>
                                        <th class="border" rowspan="3">MEAN</th>
                                        <th class="border" rowspan="3">ADJECTIVAL RATING</th>
                                    </tr>
                                    <tr>
                                        <th class="border">NI</th>
                                        <th class="border">F</th>
                                        <th class="border">G</th>
                                        <th class="border">VG</th>
                                        <th class="border">E</th>
                                    </tr>
                                    <tr>
                                        <th class="border">1</th>
                                        <th class="border">2</th>
                                        <th class="border">3</th>
                                        <th class="border">4</th>
                                        <th class="border">5</th>
                                    </tr>

                                    <tr>
                                        <td class="border">The frontline staff are knowledegable, helpful, courteous and understand client needs. <br><span class="fst-italic">Maalam, matukunngin, magalang at maunawain sa mga pangangailangan ng kliyente ang mga pangunang empleyado.</span></td>
                                        <td class="border text-center"><input name="asrc-1" id="asrc-1" value="<?php echo $assurance_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="asrc-2" id="asrc-2" value="<?php echo $assurance_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="asrc-3" id="asrc-3" value="<?php echo $assurance_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="asrc-4" id="asrc-4" value="<?php echo $assurance_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="asrc-5" id="asrc-5" value="<?php echo $assurance_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="asrc-mean" id="asrc-mean" value="<?php echo $asrMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="asrc-rate" id="asrc-rate" value="<?php echo AdRating($asrMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr class="text-center fw-bold">
                                        <td class="border" colspan="6">Mean Rating for Assurance (Kasiguruhan)</td>
                                        <td class="border"><input name="asr-mean" id="asr-mean" value="<?php echo $asrMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- OUTCOME -->
                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">VIII. OUTCOME (RESULTA)</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border">
                                    <tr>
                                        <th class="border" rowspan=3>OUTCOME (RESULTA)</th>
                                        <th class="border" colspan="5">Frequency Ratings</th>
                                        <th class="border" rowspan="3">MEAN</th>
                                        <th class="border" rowspan="3">ADJECTIVAL RATING</th>
                                    </tr>
                                    <tr>
                                        <th class="border">NI</th>
                                        <th class="border">F</th>
                                        <th class="border">G</th>
                                        <th class="border">VG</th>
                                        <th class="border">E</th>
                                    </tr>
                                    <tr>
                                        <th class="border">1</th>
                                        <th class="border">2</th>
                                        <th class="border">3</th>
                                        <th class="border">4</th>
                                        <th class="border">5</th>
                                    </tr>

                                    <tr>
                                        <td class="border">The desired service is achieved. <br><span class="fst-italic">Naabot ang ninanais na serbisyo.</span></td>
                                        <td class="border text-center"><input name="out-1" id="out-1" value="<?php echo $outcome_1; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="out-2" id="out-2" value="<?php echo $outcome_2; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="out-3" id="out-3" value="<?php echo $outcome_3; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="out-4" id="out-4" value="<?php echo $outcome_4; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="out-5" id="out-5" value="<?php echo $outcome_5; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="out-mean" id="out-mean" value="<?php echo $ocMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border text-center"><input name="out-rate" id="out-rate" value="<?php echo AdRating($ocMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                    </tr>
                                    <tr class="text-center fw-bold">
                                        <td class="border" colspan="6">Mean Rating for Outcome (Resulta)</td>
                                        <td class="border"><input name="oc-mean" id="oc-mean" value="<?php echo $ocMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        <td class="border"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">Rater's Comments / Suggestions</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <div class="ps-3 pe-3 border d-flex justify-content-center">
                                    <textarea value="<?php echo $all_Comments; ?>" name="comments" id="comments" rows="5" cols="" class="m-0 p-0 border-0 w-100 form-control"><?php echo $all_Comments; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">OFFICE FEEDBACK RATING</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <table class="table border">
                                    <thead>
                                        <th>Category</th>
                                        <th>Category Mean</th>
                                        <th>Adjectival Rating</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="border">I. RESPONSIVENESS (PAGTUGON)</td>
                                            <td class="border text-center"><input name="responsive-mean" id="responsive-mean" value="<?php echo $rsMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                            <td class="border text-center"><input name="responsive-rate" id="responsive-rate" value="<?php echo AdRating($rsMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border">II. RELIABILITY (PAGIGING MAAASAHAN)</td>
                                            <td class="border text-center"><input name="reliable-mean" id="reliable-mean" value="<?php echo $rlMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                            <td class="border text-center"><input name="reliable-rate" id="reliable-rate" value="<?php echo AdRating($rlMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border">III. ACCESS & FACILITIES (PASILIDAD)</td>
                                            <td class="border text-center"><input name="AcFc-mean" id="AcFc-mean" value="<?php echo $AFMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                            <td class="border text-center"><input name="AcFc-rate" id="AcFc-rate" value="<?php echo AdRating($AFMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border">IV. COMMUNICATION (KOMUNIKASYON)</td>
                                            <td class="border text-center"><input name="communicate-mean" id="communicate-mean" value="<?php echo $commMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                            <td class="border text-center"><input name="communicate-rate" id="communicate-rate" value="<?php echo AdRating($commMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border">V. COSTS (HALAGA)</td>
                                            <td class="border text-center"><input name="costs-mean" id="costs-mean" value="<?php echo "N/A"; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                            <td class="border text-center"><input name="costs-rate" id="costs-rate" value="<?php echo "N/A"; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border">VI. INTEGRITY (INTEGRIDAD)</td>
                                            <td class="border text-center"><input name="integrity-mean" id="integrity-mean" value="<?php echo $intgMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                            <td class="border text-center"><input name="integrity-rate" id="integrity-rate" value="<?php echo AdRating($intgMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border">VII. ASSURANCE (KASIGURUHAN)</td>
                                            <td class="border text-center"><input name="assurance-mean" id="assurance-mean" value="<?php echo $asrMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                            <td class="border text-center"><input name="assurance-rate" id="assurance-rate" value="<?php echo AdRating($asrMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border">VIII. OUTCOME (RESULTA)</td>
                                            <td class="border text-center"><input name="outcome-mean" id="outcome-mean" value="<?php echo $ocMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                            <td class="border text-center"><input name="outcome-rate" id="outcome-rate" value="<?php echo AdRating($ocMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border text-end">TOTAL CATEGORY MEAN</td>
                                            <td class="border text-center" colspan="2"><input name="total-mean" id="total-mean" value="<?php echo $totalMean; ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                        <tr>
                                            <td class="border text-end">ADJECTIVAL RATING</td>
                                            <td class="border text-center" colspan="2"><input name="total-rate" id="total-rate" value="<?php echo AdRating($ocMean); ?>" class="form-control m-0 p-0 border-0 text-center"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="container ps-5 pe-5">
                                <div class="border col-4 ps-3">
                                    <table class="">
                                        <tr>
                                            <td>
                                                <p>Rating Scale:</p>
                                            </td>
                                        </tr>
                                        <tr class="m-0 p-0">
                                            <td class="m-0 p-0">4.21 - 5.00 - Excellent</td>
                                        </tr>
                                        <tr class="m-0 p-0">
                                            <td class="m-0 p-0">3.41 - 4.20 - Very Good</td>
                                        </tr>
                                        <tr class="m-0 p-0">
                                            <td class="m-0 p-0">2.61 - 3.40 - Good</td>
                                        </tr>
                                        <tr class="m-0 p-0">
                                            <td class="m-0 p-0">1.81 - 2.60 - Fair</td>
                                        </tr>
                                        <tr class="m-0 p-0">
                                            <td class="m-0 p-0">1.00 - 1.80 - Needs Improvement</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">Discussion Results</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <div class="ps-3 pe-3 border d-flex justify-content-center">
                                    <textarea name="discussion" id="discussion" rows="5" cols="" class="m-0 p-0 border-0 w-100 form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">Conclusion</h6>
                            </div>
                            <div class="container ps-5 pe-5">
                                <div class="ps-3 pe-3 border d-flex justify-content-center">
                                    <textarea name="conclusion" id="conclusion" rows="5" cols="" class="m-0 p-0 border-0 w-100 form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <h6 class="mt-2 mb-2 fw-bold">Action taken on comments / suggestions (where applicable)</h6>
                            </div>
                            <div class="container ps-5 pe-5 h-25">
                                <div class="ps-3 pe-3 border d-flex justify-content-center">
                                    <textarea name="action" id="action" rows="5" cols="" class="m-0 p-0 border-0 w-100 form-control"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 pt-4">
                            <div class="container ps-5 pe-5">
                                <table>

                                    <tr>
                                        <td>
                                            <div class="mt-5 mb-5">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <span class="fw-bold">Prepared By:&nbsp;</span>
                                                        <input name="name1" id="name1" class="m-0 p-0 border-0 fw-bold" value="ROLANDO A. DIZON">
                                                    </div>
                                                    <div class="d-flex">
                                                        <span class="fw-bold">Attested:&nbsp;</span>
                                                        <input name="name2" id="name2" class="border-0 m-0 p-0 fw-bold" value="DR. EVARISTO A. ABELLA">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex justify-content-end">
                                                        <input name="position1" id="position1" class="m-0 p-0 border-0 text-end fw-bold" value="Chief, ERMS">
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <input name="position2" id="position2" class="border-0 m-0 p-0 fw-bold" value="VP for Administration">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr>
                                        <td>
                                            <div class="mt-3 mb-3">
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex">
                                                        <span class="fw-bold">Reviewed By:&nbsp;</span>
                                                        <input name="name3" id="name3" class="m-0 p-0 border-0 fw-bold" value="CARLO RAUL C. DIVINA">
                                                    </div>
                                                    <div class="d-flex">
                                                        <input name="name4" id="name4" class="border-0 m-0 p-0 fw-bold" value="DR. EDGAR A. ORDEN">
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div class="d-flex justify-content-center">
                                                        <input name="position3" id="position3" class="m-0 p-0 ms-5 ps-4 border-0 text-end fw-bold" value="Acting Director, PPSDS">
                                                    </div>
                                                    <div class="d-flex justify-content-end">
                                                        <input name="position4" id="position4" class="border-0 m-0 p-0 fw-bold" value="University President">
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                </table>
                            </div>
                        </div>

                        <div class="container mt-3 pt-4">
                            <div class="d-flex justify-content-between">
                                <a href="admin.php" id="back" class="btn btn-danger fsz">Cancel</a>
                                <button name="get-select-report" id="get-month-report" class="btn btn-primary fsz">Generate Report</button>
                            </div>
                        </div>

                    </form>
                
                </div>
            </section>
        </div>

<?php } ?>

    <?php include '../include/scripts.php'; ?>

    </body>

    </html>