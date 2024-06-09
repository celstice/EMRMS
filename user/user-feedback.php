<?php 
// USER: ADD Feedback
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
if (isset($_GET['id'])) {
    $request = $_GET['id'];
    $sql = mysqli_query($connect, "SELECT * FROM job_request WHERE job_id = $request");
}
$data = mysqli_fetch_array($sql);
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
        <section id="" class="">
            <div id="content" class="content mt-5 pb-3">

                <a href="user-jobrequest.php" id="back" class="fst-italic ms-3 text-decoration-none text-dark">
                    <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to previous page</span>
                </a>
                
                <div class="container overflow-auto">
                    <form method="post" action="../config/getfeedback.php" id="feedbackForm" onsubmit="loading()">
                        <div class="feedback-header overflow-auto ">
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
                                            <div class="d-flex flex-column justify-content-center align-items-center ms-5 me-5 ps-5 pe-5">
                                                <label for="office-rated" class="p-1">Office Rated: </label>
                                                <input type="text" class="form-control form-control-sm" name="office-rated" id="office-rated" value="ERMS" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col text-start d-flex align-items-center p-0 m-0">
                                        <h6 class="fw-bolder">Feedback No.&nbsp;<?php echo $data['feedback_number'] ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid">
                            <table class="table border-0 ">
                                <tr class="border-0">
                                    <td class="m-1 h6 border-0 d-flex align-items-center">
                                        <label for="transaction" class="me-2 fst-italic">Type of Transaction / Service: </label>
                                        <input type="text" name="transaction" id="transaction" class="border-0 bg-transparent" value="<?php echo $data['job_service'] ?>" required>
                                    </td>
                                    <td class="m-1 h6 border-0 d-flex align-items-center">
                                        <label for="employee" class="me-2 fst-italic d-flex align-items-center">Name of Employee:&nbsp;</label>
                                        <span><?php echo $data['requesting_official']?></span>
                                    </td>
                                    <td class="m-1 h6 border-0 ">
                                        <label for="date" class="mb-2">Date: </label>
                                        <input type="date" name="date" id="date" class="form-control form-control-sm" required>
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="container-fluid mb-5">
                            <table class="table">
                                <thead class="text-center text-dark border">
                                    <th class="border-end bg-light fsz" colspan="">Service Quality</th>
                                    <th class="border-end bg-light fsz">Needs Improvement (1)</th>
                                    <th class="border-end bg-light fsz">Fair (2)</th>
                                    <th class="border-end bg-light fsz">Good (3)</th>
                                    <th class="border-end bg-light fsz">Very Good (4)</th>
                                    <th class="border-end bg-light fsz">Excellent (5)</th>
                                </thead>
                                <input hidden name="job-id" id="job-id" value="<?php echo $data['job_id']; ?>">
                                <input hidden name="job-ctrl" id="job-ctrl" value="<?php echo $data['job_control_number']; ?>">
                                <input hidden name="feedback-number" id="feedback-number" value="<?php echo $data['feedback_number']; ?>">
                                <tbody class="" id="">
                                    <tr class="border">
                                        <td colspan="6" class="m-1 p-2 text-center fsz">Responsiveness</td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">1. The service is provided promptly / timely.
                                            <span class="fst-italic tg-text">Mabilis ang serbisyo at nasa tamang oras.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive1" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive1" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive1" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive1" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive1" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">2. The personnel show willingness to help the client.
                                            <span class="fst-italic tg-text">Nagpapakita ng kagustuhang maglingkod ang mga kawani.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive2" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive2" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive2" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive2" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="responsive2" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td colspan="6" class="m-1 p-2 text-center fsz">Reliability</td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">1. The service exhibits quality and high standard.
                                            <span class="fst-italic tg-text">Nagpapamalas ng kalidad at mataas na pamnatayan ang serbisyo.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability1" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability1" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability1" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability1" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability1" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">2. The service meets the expectation of the client.
                                            <span class="fst-italic tg-text">Nakapaglilingkod nang ayon sa inaasahan ng kliyente.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability2" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability2" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability2" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability2" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="reliability2" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td colspan="6" class="m-1 p-2 text-center fsz">Access and Facilities</td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">1. The facilities are clean, organized and accessible.
                                            <span class="fst-italic tg-text">Malinis, maayos at madaling marating ang pasilidad.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="facility" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="facility" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="facility" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="facility" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="facility" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">2. Online Services are made available.
                                            <span class="fst-italic tg-text">Mayroong serbisyong online.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="access" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="access" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="access" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="access" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="access" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td colspan="6" class="m-1 p-2 text-center fsz">Communication</td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">1. The instructions and information are clear.
                                            <span class="fst-italic tg-text">Malinaw ang mga tagubilin at impormasyon.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication1" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication1" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication1" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication1" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication1" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">2. The personnel explains te service effectively.
                                            <span class="fst-italic tg-text">Naipaliliwanag nang mabisa ng mga kawani ang kanilang serbisyo.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication2" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication2" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication2" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication2" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="communication2" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td colspan="6" class="m-1 p-2 text-center fsz">Cost</td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">1. The billing process, method and payment are timely and appropriate.
                                            <span class="fst-italic tg-text">Nasa oras at angkop ang proseso ng paniningil at metodo ng pagbabayad.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost1" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost1" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost1" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost1" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost1" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">2. The cost of service is fair and reasonable.
                                            <span class="fst-italic tg-text">Angkop at makatwiran ang halaga ng serbisyo.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost2" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost2" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost2" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost2" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" name="cost2" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td colspan="6" class="m-1 p-2 text-center fsz">Integrity</td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">The employees demonstrate honesty, justice, fairness and trustworthiness.
                                            <span class="fst-italic tg-text">Matapat, makatarungan, mapagkakatiwalaan at tapat ang mga kawani.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="integrity" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="integrity" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="integrity" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="integrity" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="integrity" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td colspan="6" class="m-1 p-2 text-center fsz">Assurance</td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">The frontline staff are knowledgeable, helpful, courteous and understand client needs.
                                            <span class="fst-italic tg-text">Maalam, matulungin, magalang at maunawain sa mga pangangailangan ng kliyente ang mga pangunang empleyado.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="assurance" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="assurance" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="assurance" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="assurance" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="assurance" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td colspan="6" class="m-1 p-2 text-center fsz">Outcome</td>
                                    </tr>
                                    <tr class="border">
                                        <td class="border-0 d-flex flex-column">The desired service is achieved.
                                            <span class="fst-italic tg-text">Naabot ang ninanais na serbisyo.</span>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="outcome" value="1"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="outcome" value="2"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="outcome" value="3"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="outcome" value="4"></div>
                                        </td>
                                        <td class="border">
                                            <div class="radio text-center"><input type="radio" id="" required name="outcome" value="5"></div>
                                        </td>
                                    </tr>
                                    <tr class="border">
                                        <td colspan="6">
                                            <label for="comments">Comment / Suggestion for Improvement: </label>
                                            <textarea class="form-control mb-3" name="comments" rows="2"></textarea>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="mt-3">
                                <div class="d-flex justify-content-center align-items-center"><button type="submit" name="feedback" id="feedback" class="btn btn-warning">SUBMIT</button></div>
                            </div>
                        </div>
                        
                    </form>
                </div>

            </div>
        </section>
    </div>

    <script>
        function loading() {
            Swal.fire({
                title: 'Sending Feedback...',
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
    </script>

    <?php include '../include/scripts.php'; ?>

</body>

</html>