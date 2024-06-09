<?php 
// ADMIN: DASHBOARD
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

	<div id="header">
		<?php include '../include/profile.php'; ?>
		<hr class="text-dark w-75 m-auto">
		<div class="top">

			<nav id="nav" class="menu">
				<div class="list-group list-group-flush mx-3 mt-3 mb-3">
					<a href="admin.php" class="list-group-item py-2 ripple active-btn">
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
		<section id="dashboard" class="dashboard">
			<div id="content" class="content mt-5 ps-5 pe-5 pt-3">

				<div class="container-fluid pt-3 ps-5 pe-5 pb-3 container-w">
					<div class="d-flex justify-content-start align-items-center bg-body">
						<div class="h5">
							<?php echo $_SESSION['user']['firstname'] . " " . $_SESSION['user']['lastname']; ?>
						</div>
					</div>
				</div>

				<!-- THIS WEEK -->
				<div class="container-fluid ps-5 pe-5  pb-3 " id="this-week">
					<div class="mt-3">
						<h3>This Week</h3>
					</div>

					<!-- REQUEST -->
					<div class="row">
						<a href="admin-jobrequest.php" class="col-lg-4 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark">
							<div class="rounded border border-primary shadow-sm p-2 bg-primary bg-gradient rounded">
								<div class="p-3">
									<div class="row">
										<div class="col">
											<div class="text-sm mb-0 font-weight-bold text-light" id="title">
												<p class="h4">New Requests</p>
											</div>
											<div class="d-flex justify-content-between text-light">
												<div class="">
													<?php
													$currentDate = date('Y-m-d');
													$start = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));
													$end = date('Y-m-d', strtotime('next saturday', strtotime($start)));

													$n = mysqli_query($connect, "SELECT * FROM job_request WHERE date_requested BETWEEN '$start' AND '$end' AND confirmed=0");
													$new = mysqli_num_rows($n);
													echo "<h1>" .htmlspecialchars( $new, ENT_QUOTES, 'UTF-8'). "</h1>";
													?>
												</div>
												<div class="bg-dangerd m-2 d-flex align-items-end h3 ">
													<i class="fa-solid fa-toolbox text-light"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>

						<!-- REPAIRS -->
						<a href="admin-records.php" class="col-lg-4 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark">
							<div class="rounded border border-warning shadow-sm p-2 bg-warning bg-gradient rounded">
								<div class="p-3">
									<div class="row">
										<div class="col">
											<div class="text-sm mb-0 font-weight-bold text-dark" id="title">
												<p class="h4">Repairs</p>
											</div>
											<div class="d-flex justify-content-between text-dark">
												<div class="">
													<?php
													$currentDate = date('Y-m-d');
													$start = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));
													$end = date('Y-m-d', strtotime('next saturday', strtotime($start)));
													$r = mysqli_query($connect, "SELECT * FROM repair_records WHERE date_finish BETWEEN '$start' AND '$end'");
													$repair = mysqli_num_rows($r);
													echo "<h1>" .htmlspecialchars( $repair, ENT_QUOTES, 'UTF-8'). "</h1>";
													?>
												</div>
												<div class="bg-dangerd m-2 d-flex align-items-end h3">
													<i class="fa-solid fa-screwdriver-wrench text-dark"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>

						<!-- SCHEDULES -->
						<a href="admin-notice.php" class="col-lg-4 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark">
							<div class="rounded border border-danger shadow-sm p-2 bg-danger bg-gradient rounded">
								<div class="p-3">
									<div class="row">
										<div class="col">
											<div class="text-sm mb-0 font-weight-bold text-light" id="title">
												<p class="h4">Schedules</p>
											</div>
											<div class="d-flex justify-content-between text-light">
												<div class="">
													<?php
													$currentDate = date('Y-m-d');
													$start = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));
													$end = date('Y-m-d', strtotime('next saturday', strtotime($start)));
													$s = mysqli_query($connect, "SELECT * FROM sched_records WHERE sched_render BETWEEN '$start' AND '$end'");
													$sched = mysqli_num_rows($s);
													echo "<h1>" .htmlspecialchars( $sched, ENT_QUOTES, 'UTF-8'). "</h1>";
													?>
												</div>
												<div class="bg-dangerd m-2 d-flex align-items-end h3">
													<i class="fa-solid fa-calendar-day text-light"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</a>

					</div>

				</div>
				
				<hr>

				<!-- WEEKLY RESPONSE -->
				<div class="container-fluid ps-5 pe-5 pb-5" id="weekly">
					<div class="row">
						
						<div class="col-lg-8 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark ">
							<div class="rounded-0 border border-success shadow-sm p-2 bg-body rounded">
								<div class="p-3">
									<div class="row">
										<div class="col">
											<div class="text-sm mb-0 font-weight-bold" id="title">
												<p class="h4 pb-3 text-center">Average Feedback Responses Weekly</p>
											</div>
											<div class="d-flex justify-content-between">
												<canvas class="graph1 w-100" id="graph1"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="col-lg-4 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark h-100">
							<div class="rounded-0 border border-success shadow-sm p-3 bg-body rounded">
								<div class="row">
									<div class="col">
										<div class="text-sm mb-0 font-weight-bold" id="title">
											<p class="h3 pt-2 pb-2 text-center">User Ratings</p>
										</div>
										<p class="h6 text-center pb-1">Weekly Rates Summary</p>
										<div class="d-flex justify-content-between">
											<canvas class="graph2 w-100" id="graph2"></canvas>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<!-- MONTHLY -->
				<div class="container-fluid ps-5 pe-5" id="monthly">
					<div class="row">

						<div class="mb-2 text-start">
							<h2>Maintenance Records Summary</h2>
						</div>

						<!-- AC INV -->
						<div class="col-lg-4 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark h-100">
							<div class="rounded-0 border border-success shadow-sm ps-3 pe-3 pt-1 pb-3 bg-body rounded">
								<div class="text-sm mb-0 font-weight-bold p-2" id="title">
									<p class=" p-0 text-start fw-bold">Aircon Inventory</p>
								</div>
								<div class="p-2">
									<div class="row">
										<div class="col">
											<div class="d-flex flex-column justify-content-center charcoal-text text-center mb-3 rounded">
												<p class="h6 fw-light fst-italic m-0 pt-1">Total Number of</p>
												<h5 class="text-uppercase">Air Conditioners</h5>
												<h1 class="pt-2 pb-2 fw-bold"><?php $stwt = mysqli_fetch_assoc(mysqli_query($connect, "SELECT SUM(qty_st+qty_wt) as stwt FROM `admin_inventory` WHERE archive=0"));
																				echo htmlspecialchars($stwt['stwt'], ENT_QUOTES, 'UTF-8'); ?></h1>
											</div>
											<div class="rounded sea-green-text mt- mb-">
												<div class="d-flex flex-column justify-content-center mt-2 text-center p-2">
													<!-- <p>Total Number of</p> -->
													<h6 class="">Split Type</h6>
												</div>
												<div class="ps-3 pe-3 pb-3 text-center">
													<h1 class="fw-bold"><?php $st = mysqli_fetch_assoc(mysqli_query($connect, "SELECT SUM(qty_st) as st FROM `admin_inventory` WHERE archive=0"));
																		echo htmlspecialchars($st['st'], ENT_QUOTES, 'UTF-8'); ?></h1>
												</div>
											</div>
											<div class="rounded persian-green-text mt- mb-">
												<div class="d-flex flex-column justify-content-center mt-2 text-center p-2">
													<!-- <p>Total Number of</p> -->
													<h6 class="">Window Type</h6>
												</div>
												<div class="ps-3 pe-3 pb-3 text-center">
													<h1 class="fw-bold"><?php $wt = mysqli_fetch_assoc(mysqli_query($connect, "SELECT SUM(qty_wt) as wt FROM `admin_inventory` WHERE archive=0"));
																		echo htmlspecialchars($wt['wt'], ENT_QUOTES, 'UTF-8'); ?></h1>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- MONTH FEEDBACK -->
						<div class="col-lg-8 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark ">
							<div class="rounded-0 border border-success shadow-sm p-2 bg-body rounded">
								<div class="p-3">
									<div class="row">
										<div class="col">
											<div class="text-sm mb-0 font-weight-bold" id="title">
												<p class="h4 pb-3 text-center">Average Feedback Responses Monthly</p>
											</div>
											<div class="d-flex justify-content-between">
												<canvas class="graph3 w-100" id="graph3"></canvas>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<!-- REPORTS -->
				<div class="container-fluid ps-5 pe-5 pb-5 " id="reports">
					<div class="row d-flex">

						<div class="d-flex align-items-center justify-content-between">
							<div class="d-flex justify-content-center mt-5 mb-2">
								<h5 class="text-uppercase fw-bold">REPORTS</h5>
							</div>
						</div>

						<!-- MONTH -->
						<div class="col-lg-6 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark h-100">
							<div class="rounded-0 border border-success shadow-sm p-3 bg-body rounded">
								<div class="text-sm mb-0 font-weight-bold" id="title">
									<h6 class=" pt-2 pb-2 text-center">OFFICE FEEDBACK REPORTS</h6>
								</div>
								<div class="mb-3 ms-3 me-3">
									<div class="d-flex justify-content-center mt-3">
										<h5 class="text-uppercase fw-bold m-3 text-center">Monthly Report</h5>
									</div>
									<form method="post" action="month-report.php">
										<div href="" class="month mb-3 ms-3 me-3 text-decoration-none text-dark">
											<div class="d-flex justify-content-start align-items-center mt-3 month-flex1">

												<div class="p-3 rounded shadow-sm text-center charcoal-text fw-bolder charcoal-border" id="charcoal">
													<i class="fa-solid fa-file-lines fa-2xl p-1"></i>
												</div>

												<div class="text-sm mb-0 font-weight-bold text-start p-3m  text-dark w-100" id="office-report">
													<h5 class="fw-bold ms-3 me-3">Office Feedback Reports</h5>
													<div name="" class="border-0 bg-transparent rounded ms-1 me-1 d-flex justify-content-between align-items-center w-100">
														<div class="d-flex justify-content-between w-100 this-month">
															<select class="form-select m-1" name="this-month" id="this-month" required>
																<option disabled selected value="" class="fst-italic text-secondary text-muted">Select month</option>
																<option value="January">January</option>
																<option value="February">February</option>
																<option value="March">March</option>
																<option value="April">April</option>
																<option value="May">May</option>
																<option value="June">June</option>
																<option value="July">July</option>
																<option value="August">August</option>
																<option value="September">September</option>
																<option value="October">October</option>
																<option value="November">November</option>
																<option value="December">December</option>
															</select>
															<select class="form-select m-1" name="this-year" id="this-year" required>
																<option disabled selected value="" class="fst-italic text-secondary text-muted">Select year</option>
																<?php
																$startYear = 2020; // Start year
																$endYear = date('Y'); // Current year
																for ($year = $endYear; $year >= $startYear; $year--) {
																	echo '<option value="' . $year . '">' . $year . '</option>';
																} ?>
															</select>
														</div>
													</div>
												</div>
											</div>
											<div class="d-flex justify-content-center mt-5">
												<button type="submit" name="month-report" id="month-report" class="btn btn-primary fsz">Generate Report</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						<!-- SELECTED PERIOD -->
						<div class="col-lg-6 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark h-100">
							<div class="rounded-0 border border-success shadow-sm p-3 bg-body rounded">
								<div class="mb-3 ms-3 me-3 select">
									<span class="fw- fst-italic ms-2 me-2">Office Feedback Reports in selected Evaluation Period</span>
									<div class="d-flex justify-content-start offce-report">
										<h5 class="text-uppercase fw-bold m-2">Select Evaluation Period:</h5>
									</div>
									<form method="post" action="select-report.php">
										<div class="from ms-3 me-3 month-flex2">
											<label>FROM:</label>
											<div class="d-flex justify-content-around from-month">
												<select class="form-select m-1" name="from-month" id="from-month" required>
													<option disabled selected value="" class="fst-italic text-secondary text-muted">Select month</option>
													<option value="01">January</option>
													<option value="02">February</option>
													<option value="03">March</option>
													<option value="04">April</option>
													<option value="05">May</option>
													<option value="06">June</option>
													<option value="07">July</option>
													<option value="08">August</option>
													<option value="09">September</option>
													<option value="10">October</option>
													<option value="11">November</option>
													<option value="12">December</option>
												</select>
												<select class="form-select m-1" name="from-year" id="from-year" required>
													<option disabled selected value="" class="fst-italic text-secondary text-muted">Select year</option>
													<?php
													$startYear = 2020; // Start year
													$endYear = date('Y'); // Current year
													for ($year = $endYear; $year >= $startYear; $year--) {
														echo '<option value="' . $year . '">' . $year . '</option>';
													} ?>
												</select>
											</div>
										</div>
										<div class="to ms-3 me-3 mt-2">
											<label>TO:</label>
											<div class="d-flex justify-content-around to-month">
												<select class="form-select m-1" name="to-month" id="to-month" required>
													<option disabled selected value="" class="fst-italic text-secondary text-muted">Select month</option>
													<option value="01">January</option>
													<option value="02">February</option>
													<option value="03">March</option>
													<option value="04">April</option>
													<option value="05">May</option>
													<option value="06">June</option>
													<option value="07">July</option>
													<option value="08">August</option>
													<option value="09">September</option>
													<option value="10">October</option>
													<option value="11">November</option>
													<option value="12">December</option>
												</select>
												<select class="form-select m-1" name="to-year" id="to-year" required>
													<option disabled selected value="" class="fst-italic text-secondary text-muted">Select year</option>
													<?php
													$startYear = 2020; // Start year
													$endYear = date('Y'); // Current year

													for ($year = $endYear; $year >= $startYear; $year--) {
														echo '<option value="' . $year . '">' . $year . '</option>';
													} ?>
												</select>
											</div>
										</div>
										<div class="ms-3 me-3 mt-3">
											<div class="d-flex justify-content-center">
												<button type="submit" name="select-report" id="select-report" class="btn btn-primary fsz">Generate Report</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>

					</div>
				</div>

			</div>
		</section>
	</div>

	<?php include '../include/scripts.php'; ?>
	<script>
		$(document).ready(function() {
			// graph1
			$.ajax({
				url: '../config/graph1.php',
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					console.log(data);
					var categories = Object.keys(data);
					var values = Object.values(data);
					var ctx = document.getElementById('graph1').getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ['Responsive', 'Reliability', 'Access and Facility', 'Communication', 'Cost', 'Integrity', 'Assurance', 'Outcome'],
							datasets: [{
								label: '',
								data: values,
								backgroundColor: ['#264653', '#1a936f', '#2a9d8f', '#e9c46a', '#f4a261', '#e76f51', '#9b2226', '#772f1a'],
							}]
						},
						options: {
							scales: {
								y: {
									beginAtZero: true
								}
							},
							plugins: {
								legend: {
									display: false, // Disable the legend
									position: 'top',
								},
							}
						}
					});
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});

			// graph2
			$.ajax({
				url: '../config/graph2.php',
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					console.log(data);
					var categories = Object.keys(data);
					var values = Object.values(data);
					var ctx = document.getElementById('graph2').getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'doughnut',
						data: {
							datasets: [{
								label: '',
								data: values,
								backgroundColor: ['#264653', '#2a9d8f', '#e9c46a', '#f4a261', '#e76f51'],
								borderWidth: 1
							}],
							labels: ['Excellent', 'Very Good', 'Good', 'Fair', 'Needs Improvement']
						},
						options: {
							plugins: {
								legend: {
									display: true, // Disable the legend
									position: 'bottom',
									align: 'start',
									padding: 30,
									labels: {
										padding: 15,
										boxWidth: 15,
									}
								},
							},
						}
					});
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});

			// graph3 | monthly feedbacks
			$.ajax({
				url: '../config/graph3.php',
				method: 'GET',
				dataType: 'json',
				success: function(data) {
					console.log(data);
					var categories = Object.keys(data);
					var values = Object.values(data);
					var ctx = document.getElementById('graph3').getContext('2d');
					var myChart = new Chart(ctx, {
						type: 'bar',
						data: {
							labels: ['Responsive', 'Reliability', 'Access and Facility', 'Communication', 'Cost', 'Integrity', 'Assurance', 'Outcome'],
							datasets: [{
								label: '',
								data: values,
								backgroundColor: ['#264653', '#1a936f', '#2a9d8f', '#e9c46a', '#f4a261', '#e76f51', '#9b2226', '#772f1a'],
							}]
						},
						options: {
							scales: {
								y: {
									beginAtZero: true
								}
							},
							plugins: {
								legend: {
									display: false, // Disable the legend
									position: 'top',
								},
							}
						}
					});
				},
				error: function(xhr, status, error) {
					console.error(error);
				}
			});

		});
	</script>

</body>

</html>