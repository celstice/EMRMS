<?php 
// USER DASHBOARD
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
$role = $_SESSION['user']['role'];
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
					<a href="user-index.php" class="list-group-item  py-2 ripple active-btn">
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
		<section id="dashboar" class="dashboar">
			<div id="content" class="content mt-5 ps-5 pe-5 pt-3">

				<div class="container-fluid pt-3 ps-5 pe-5 pb-3 rs-1">
					<div class="d-flex justify-content-between align-items-center bg-body" id="user-name">
						<div class="h5">
							<?php echo $_SESSION['user']['firstname'] . " " . $_SESSION['user']['lastname']; ?>
						</div>
						<a href="../scanQR.php" id="user-qr" target="_blank" class="rounded border-0 border-success shadow-sm bg-body text-decoration-none text-center text-dark d-flex justify-content-center align-items-center">
							<h2 data-bs-placement="top" title="Scan QR Code"><i class="fa-solid fa-qrcode text-success"></i></h2>
						</a>
					</div>
				</div>

				<!-- EQUIPMENTS BLOCK -->
				<div class="container-fluid ps-5 pe-5 pb-4" id="equipments">
					<div class="row">

						<div class="mb-2 text-center mt-3">
							<h2>Equipments</h2>
						</div>

						<?php
						$e= mysqli_query($connect, "SELECT * FROM equipments WHERE userID='$user' AND archive=0");
						$equip = mysqli_num_rows($e);
						$o = mysqli_query($connect, "SELECT equip_status FROM equipments WHERE userID='$user' AND archive=0 AND equip_status LIKE '%operational%'");
						$operational = mysqli_num_rows($o);
						$n = mysqli_query($connect, "SELECT equip_status FROM equipments WHERE userID='$user' AND archive=0 AND equip_status LIKE '%non-operational%'");
						$non = mysqli_num_rows($n);
						$c = mysqli_query($connect, "SELECT equip_status FROM equipments WHERE userID='$user' AND archive=0 AND equip_status LIKE '%condemn%'");
						$condemn = mysqli_num_rows($c);
						?>

						<!-- EQUIPMENTS -->
						<div href="" class="col-lg-3 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark">
							<div class="rounded-0 shadow border-5 border-start border-primary bg-light p-2">
								<div class="p-2">
									<div class="row">
										<div class="col">
											<div class="text-sm mb-0 " id="title">
												<p class="h5 text-center">Equipments</p>
											</div>
											<div class="d-flex justify-content-center">
												<div class="text-primary">
													<h1 class="display-4 fw-bold"><?php echo htmlspecialchars($equip, ENT_QUOTES,'UTF-8'); ?></h1>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- OPERATIONAL -->
						<div href="" class="col-lg-3 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark">
							<div class="rounded-0 shadow border-5 border-start border-warning bg-light p-2 ">
								<div class="p-2">
									<div class="row">
										<div class="col">
											<div class="text-sm mb-0" id="title">
												<p class="h5 text-center">Operational</p>
											</div>
											<div class="d-flex justify-content-center">
												<div class="text-warning">
													<h1 class="display-4 fw-bold"><?php echo htmlspecialchars($operational, ENT_QUOTES, 'UTF-8'); ?></h1>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- NON-OPERATIONAL -->
						<div href="" class="col-lg-3 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark">
							<div class="rounded-0 shadow border-5 border-start border-danger bg-light p-2 ">
								<div class="p-2">
									<div class="row">
										<div class="col">
											<div class="text-sm mb-0" id="title">
												<p class="h5 text-center text-truncate">Non-Operational</p>
											</div>
											<div class="d-flex justify-content-center">
												<div class="text-danger">
													<h1 class="display-4 fw-bold"><?php echo htmlspecialchars($non, ENT_QUOTES, 'UTF-8'); ?></h1>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- CONDEMN -->
						<div href="" class="col-lg-3 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark">
							<div class="rounded-0 shadow border-5 border-start border-secondary bg-light p-2 ">
								<div class="p-2">
									<div class="row">
										<div class="col">
											<div class="text-sm mb-0" id="title">
												<p class="h5 text-center">Condemn</p>
											</div>
											<div class="d-flex justify-content-center">
												<div class="text-secondary">
													<h1 class="display-4 fw-bold"><?php echo htmlspecialchars($condemn, ENT_QUOTES, 'UTF-8'); ?></h1>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>

				<!-- #2 BLOCK -->
				<div class="container-fluid ps-5 pe-5 pb-4" id="block2">
					<div class="row">

						<!-- PREVENTIVE MANITENANCE -->
						<div class="col-lg-6 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark">
							<div class="rounded-0 p-2">
								<div class="text-sm mb-0 font-weight-bold" id="title">
									<p class="h4 pb-1 text-start">Preventive Maintenance Schedule</p>
								</div>
								<?php
								$sched = mysqli_query($connect, "SELECT * FROM sched_records WHERE done=0 AND userID='$user' AND archive=0 ORDER BY sched_render");
								if (mysqli_num_rows($sched) > 0) {
									while ($data = mysqli_fetch_assoc($sched)) { ?>
										<a class="text-decoration-none text-dark rounded shadow-sm border-5 border-start border-danger bg-light mt-3 mb- d-flex flex-column">
											<div id="user-notice" class="d-flex justify-conte align-items-center">
												<div class="p-2 m-3 text-center text-dark fw-bolder border-danger rounded ms- d-flex justify-conte align-items-center" id="user-">
													<h3 class="text-danger"><i class="fa-solid fa-circle-exclamation p-1"></i></h3>
												</div>
												<div class="d-flex flex-column p-3">
													<h6 class="fw-bold"><?php echo htmlspecialchars($data['job_render'], ENT_QUOTES, 'UTF-8'); ?></h6>
													<p class="pt-1 opacity-75"><?php echo htmlspecialchars(date("F j, Y", strtotime($data['sched_render'])), ENT_QUOTES, 'UTF-8'); ?></p>
												</div>
											</div>
										</a>
								<?php }
								} else {
									echo "<section class='d-flex justify-content-center align-items-center charcoal-border bg-light rounded'>
											<span class='p-3 d-flex justify-content-center align-items-center'>No upcoming schedule.</span>
										  </section>";
								} ?>
							</div>
						</div>

						<!-- SCHEDULE -->
						<div class="col-lg-6 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark ">
							<div class="rounded-0 p-2 bg-infox">
								<div class="text-sm mb-0 font-weight-bold" id="title">
									<p class="h4 pb-3 text-start">Equipment Maintenance Schedule</p>
								</div>

								<div class="text-start">
									<h5 class="mb-2 p-0">This Week</h5>
								</div>
								<?php
								$currentDate = date('Y-m-d');
								$start = date('Y-m-d', strtotime('last sunday', strtotime($currentDate)));
								$end = date('Y-m-d', strtotime('next saturday', strtotime($start)));

								$week = "SELECT maintenance_records.*, equipments.equip_name
									FROM maintenance_records
									JOIN equipments ON maintenance_records.equipment_id = equipments.equipment_id
									WHERE next_mnt BETWEEN '$start' AND '$end' 
									AND maintenance_records.userID = '$user' AND done=0
									ORDER BY next_mnt;";

								$resultWeek = mysqli_query($connect, $week);

								if ($resultWeek && mysqli_num_rows($resultWeek) > 0) {
									while ($row = $resultWeek->fetch_assoc()) { ?>
										<div class="rounded border-5 border-start charcoal-border-l  mt-3 mb-3">
											<a id="equipment-this-week" href="equipment-record.php?id=<?php echo $row['equipment_id']; ?>" class="d-flex justify-conte align-items-center text-decoration-none text-dark">
												<div class="p-2 m-3 text-center text-dark fw-bolder charcoal-border rounded ms- d-flex justify-conte align-items-center" id="">
													<h3 class="display"><i class="fa-solid fa-screwdriver-wrench p-1"></i></h3>
												</div>
												<div class="d-flex flex-column">
													<h6 class="fw-bold"><?php echo htmlspecialchars($row['equip_name'], ENT_QUOTES, 'UTF-8'); ?></h6>
													<p><?php echo htmlspecialchars(date("F j, Y", strtotime($row['next_mnt'])), ENT_QUOTES, 'UTF-8'); ?></p>
												</div>
											</a>
										</div>
								<?php }
								} else {
									echo "<div class='d-flex justify-content-center align-items-center charcoal-border bg-light rounded'><div class='p-3 d-flex justify-content-center align-items-center'>No schedule for this Week.</div></div>";
								} ?>
							</div>
						</div>

					</div>
				</div>

				<!-- #3 BLOCK  -->
				<div class="container-fluid ps-5 pe-5 pb-5" id="block3">
					<div class="row">

						<!-- INVENTORY -->
						<div id="user-inv" class="col-lg-6 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark ">
							<div class="rounded-0 p-2 bg-infox">
								<div class="text-sm mb-0 font-weight-bold" id="title">
									<p class="h4 pb-1 text-start">Inventory</p>
								</div>
								<div class="rounded shadow-smx  bg-lightx mt-3 mb-3">
									<div class="p-3">
										<div class="">
											<h6 class="fst-italic">Total number of Inventory: </h6>
										</div>

										<div class="d-flex justify-content-centerr align-items-center p--3">
											<div class="m-3 text-center text-dark fw-bolder  rounded ms- d-flex justify-content align-items-center" id="">
												<div>
													<img src="../assets/img//icons/inventory.png" id="inv" />
												</div>
											</div>
											<div class="d-flex flex-column m-3">
												<?php
												$total = mysqli_query($connect, "SELECT SUM(quantity) AS inv FROM user_inventory WHERE userID='$user' AND archive=0;");
												$inv = mysqli_fetch_assoc($total);
												echo "<h1 class='fw-bold'>" . htmlspecialchars(($inv['inv'] == null ? '0' : $inv['inv']), ENT_QUOTES, 'UTF-8')  . "</h1>";	?>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<!-- DOWNLOADS -->
						<div class="col-lg-6 col-md-6 mb-xl-0 mb-4 mt-4 text-decoration-none text-dark ">
							<div class="rounded p-2 bg-body rounded">
								<div class="text-sm mb-0 font-weight-bold" id="title">
									<p class="h4 pb-3 text-start">Download records</p>
								</div>
								<form method="post" action="../config/generate-reports.php" class="d-flex flex-column">
									<div class="">
										<div href="" class="col-lg-4 col-md-6 mb-xl-0 text-decoration-none text-dark mt-1 mb-1 w-100">
											<div class="rounded p--2">
												<div class="d-flex align-items-center recorddownloads">
													<div class="p-2 m-3 rounded shadow-sm text-center text-light fw-bolder border charcoal-border" id="charcoal">
														<button class="h5 text-dark p-0 m-0 bg-transparent border-0" name="equipments">
															<i class="fa-solid fa-download p-1"></i>
														</button>
													</div>
													<div class="d-flex flex-column">
														<div class="text-sm mb-0 font-weight-bold text-start">
															<h5 class="fw-bold text-start d-flex">Equipments</h5>
														</div>
														<div class="rounded d-flex align-items-center justify-content-start p-2 ">
															<h6 class="fst-italic opacity-50"><?php echo date('F Y'); ?></h6>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>

									<div class="">
										<div href="" class="col-lg-4 col-md-6 mb-xl-0 text-decoration-none text-dark mt-1 mb-1 w-100">
											<div class="rounded p--2">
												<div class="d-flex align-items-center recorddownloads">
													<div class="p-2 m-3 rounded shadow-sm text-center text-light fw-bolder border charcoal-border" id="charcoal">
														<button class="h5 text-dark p-0 m-0 bg-transparent border-0" name="user-inv">
															<i class="fa-solid fa-download p-1"></i>
														</button>
													</div>
													<div class="d-flex flex-column">
														<div class="text-sm mb-0 font-weight-bold text-start">
															<h5 class="fw-bold text-start d-flex">Inventory</h5>
														</div>
														<div class="rounded d-flex align-items-center justify-content-start p-2 ">
															<h6 class="fst-italic opacity-50"><?php echo date('F Y'); ?></h6>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>

					</div>
				</div>

			</div>
		</section>
	</div>

	<?php include '../include/scripts.php'; ?>

</body>

</html>