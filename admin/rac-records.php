<?php 
// ADMIN: View RAC CLEANING records
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
					<a href="admin-jobrequest.php" class="list-group-item  py-2 ripple">
						<i class="fa-solid fa-toolbox icon"></i>
						<span class="nav-text">Job Request</span>
					</a>
					<a href="admin-records.php" class="list-group-item  py-2 ripple active-btn">
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
		<section id="records" class="records">
			<div id="content" class="content mt-5 pb-5">

				<div class="container-fluid overflow-auto pb-5">

					<div class="pt-3">
						<div class="content-title d-flex justify-content-center">
							<h2>Maintenance Records</h2>
						</div>
					</div>

					<div id="custom-tabs" class="custom-tabs bg-dangerx d-flex">
						<div class="d-flex justify-content-between align-items-center  pt-3 ps-5 pe-5">
							<div class="d-flex p-1">
								<a href="admin-records.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 opacity-75 border-end border-2 rounded-0">
									<i class="fa-solid fa-screwdriver-wrench icon p-1"></i>
									<h6 class="fw-lighter p-1 fsz">Troubleshoot and Repair / Installation</h6>
								</a>
								<a href="rac-records.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 border-start border-5 border-primary rounded-0 bg-primary bg-opacity-25">
									<i class="fa-brands fa-intercom fa-rotate-90 icon p-1"></i>
									<h6 class="fw-mediumm p-1 fsz">RAC Cleaning Records</h6>
								</a>
							</div>
						</div>
					</div>

					<div class="table-div h-100x borderx ps-3 pe-3 pt-3 pb-3 bg-body overflow-auto">
						<table id="racrecords-tbl" class="table pt-3">
							<thead class="text-center border-bottom border-dark fw-bold">
								<tr>
									<th hidden class="border-end th-bg">ID</th>
									<th class="border-end th-bg">Location</th>
									<th class="border-end th-bg">Unit</th>
									<th class="border-end th-bg">Equipment</th>
									<th class="border-end th-bg">Job Rendered</th>
									<th class="border-end th-bg">Time Started</th>
									<th class="border-end th-bg">Time Finished</th>
									<th class="border-end th-bg">Date</th>
									<th class="border-end th-bg">Job Control Number</th>
									<th class="border-end th-bg">Status</th>
									<th class="th-bg">Actions</th>
								</tr>
							</thead>
							<tbody class="text-center">
								<?php
								include '../config/connect.php';
								include 'repair-type.php';
								$repairs = mysqli_query($connect, "SELECT * FROM repair_records WHERE archive=0 AND done=1 AND repair_type='1'");
								if (mysqli_num_rows($repairs) > 0) {
									while ($row = mysqli_fetch_assoc($repairs)) {
								?>
										<tr class="row1">
											<td hidden class=""><?php echo $row['repair_id']; ?></td>
											<td class=""><?php echo $row['repair_location']; ?></td>
											<td class=""><?php echo $row['repair_unit']; ?></td>
											<td class=""><?php echo $row['equipment_device']; ?></td>
											<td class=""><?php repairType($row['repair_type']); ?></td>
											<td class="">
												<?php if (!empty($row['start_time']) && $row['start_time'] !== "00:00:00") {echo date("h:i A", strtotime($row['start_time']));} else {echo "";} ?>
											</td>
											<td class="">
												<?php if (!empty($row['finish_time']) && $row['finish_time'] !== "00:00:00") {echo date("h:i A", strtotime($row['finish_time']));} else {echo "";} ?>
											</td>
											<td class="">
												<?php if (!empty($row['date_finish']) && $row['date_finish'] !== "0000-00-00") {echo date("F j, Y", strtotime($row['date_finish']));} else {echo "";} ?>
											</td>
											<td class=""><?php echo $row['job_number']; ?></td>
											<td>
												<?php if ($row['done'] == 0) {
													echo "<h6 class='bg-secondary bg-opacity-25 text-muted rounded-1 p-1 fsz'>Scheduled</h6>";
												} else {
													echo "<h6 class='bg-primary bg-opacity-25 text-primary rounded-1 p-1 fsz'>Completed</h6>";
												} ?>
											</td>
											<td class="" class="">
												<div class="dropdown">
													<a class="btn btn-success fsz dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
														Actions
													</a>
													<ul class="dropdown-menu m-0 p-0">
														<li>
															<?php if ($row['done'] == "0") {
																echo '<a type="button" disabled class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" style="opacity:0.7 !important;">Update</a>';
															} else {
																echo '<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#edit-record' . $row['repair_id'] . '">Update</a>';
															} ?>
														</li>
														<li>
															<a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden archiveRepairs" name="archiveRepairs" id="archiveRepairs" data-bs-toggle="modal" data-bs-target="#archiveRecord<?php echo $row['repair_id']; ?>">Archive</a>
														</li>
													</ul>
												</div>
											</td>
										</tr>

										<!-- MODAL UPDATE -->
										<div id="edit-record<?php echo $row['repair_id'] ?>" aria-hidden="true" class="modal">
											<div class="modal-dialog">
												<div class="modal-content rounded-0">
													<div class="modal-header border-0 text-center d-flex justify-content-center align-items-center tea-green-bgx">
														<h6 class="text-uppercase fw-bold">Update Maintenance Record</h6>
													</div>
													<form method="post" action="../config/mnt-records.php" onsubmit="updaterecord()">
														<input hidden name="repair-id" id="repair-id" value="<?php echo $row['repair_id']; ?>">
														<div class="modal-body pt-0 pb-0 m-1 d-flex flex-column">
															<div class="borders">
																<div class="">
																	<div class="border-bottom p-2 d-flex flex-column justify-content-center tea-green-bg">
																		<span class="tg-text text-uppercase fw-bold text-center">Job Control Number:&nbsp;</span>
																		<input class="form-control" id="job-number" name="job-number" value="<?php echo $row['job_number']; ?>">
																	</div>
																	<div class="borderx p-2 d-flex flex-column text-center">
																		<span class="fst-italic fw-bold tg-text">Location:</span>
																		<input type="text" class="form-control" name="job-location" id="job-location" value="<?php echo $row['repair_location']; ?>" required>
																	</div>
																	<div class="borderx p-2 d-flex flex-column text-center">
																		<span class="fst-italic fw-bold tg-text">Unit:</span>
																		<input type="text" class="form-control" name="unit" id="unit" value="<?php echo $row['repair_unit']; ?>" required>
																	</div>
																	<div class="borderx p-2 d-flex flex-column text-center">
																		<span class="fst-italic fw-bold tg-text">Equipment / Device:</span>
																		<input type="text" class="form-control" name="equipment-device" id="equipment-device" value="<?php echo $row['equipment_device']; ?>" required>
																	</div>
																	<div class="borderx p-2 d-flex flex-column text-center">
																		<span class="fst-italic fw-bold tg-text">Job Rendered:</span>
																		<select name="job-render" id="job-render" class="form-control" required>
																			<option selected class="fst-italic text-secondary text-muted" value="<?php echo $row['repair_type']; ?>"><?php echo repairType($row['repair_type']); ?></option>
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
																	<div class="borderx p-2 d-flex flex-column text-center">
																		<span class="fst-italic fw-bold tg-text">Time Started:</span>
																		<input type="time" class="form-control" name="start-time" id="start-time" value="<?php echo $row['start_time']; ?>" required>
																	</div>
																	<div class="borderx p-2 d-flex flex-column text-center">
																		<span class="fst-italic fw-bold tg-text">Time Finished:</span>
																		<input type="time" class="form-control" name="finish-time" id="finish-time" value="<?php echo $row['finish_time']; ?>" required>
																	</div>
																	<div class="borderx p-2 d-flex flex-column text-center">
																		<span class="fst-italic fw-bold tg-text">Date Started:</span>
																		<input type="date" class="form-control" name="dateStart" id="dateStart" value="<?php echo $row['date_start']; ?>" required>
																	</div>
																	<div class="borderx p-2 d-flex flex-column text-center">
																		<span class="fst-italic fw-bold tg-text">Date Finished:</span>
																		<input type="date" class="form-control" name="dateFinish" id="dateFinish" value="<?php echo $row['date_finish']; ?>" required>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer border-0">
															<div class="d-flex justify-content-center">
																<div class="m-1 d-flex">
																	<button type="submit" name="edit-repair" id="edit-repair" class="btn btn-warning text-uppercase">Save</button>
																</div>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
										<!-- MODAL UPDATE END -->

										<!-- ARCHIVE-RECORD MODAL -->
										<div class="modal fade" id="archiveRecord<?php echo $row['repair_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="card text-center border-0 m-5 d-flex justify-content-center">
														<div class="mb-4">
															<h5>Archive Record</h5>
															<p>Are you sure you want to archive this record?</p>
														</div>
														<div class="d-flex justify-content-center">
															<button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
															<button type="button" name="archiveRepair" id="<?php echo $row['repair_id']; ?>" class="btn btn-success archiveRepair"><i class="fa-solid fa-square-check p-1"></i>Yes</button>
														</div>
													</div>
												</div>
											</div>
										</div>
										<!-- ARCHIVE-RECORD MODAL END -->

								<?php } } ?>
							</tbody>
						</table>
					</div>

				</div>

			</div>
		</section>
	</div>

	<?php include '../include/scripts.php'; ?>
	<script>
		$(document).ready(function() {
			// datatable
			$('#racrecords-tbl').DataTable({
				"order": [
					[0, "desc"]
				]
			});

			// ARCHIVE RECORD
			$('.archiveRepair').on('click', function() {
				var archiveRepair = $(this).attr('id');
				$.ajax({
					type: "POST",
					url: "../config/admin-archive.php",
					data: {
						archiveRepair: archiveRepair
					},
					success: function(response) {
						console.log(response);
						Swal.fire({
							title: 'Archiving...',
							allowOutsideClick: false,
							showConfirmButton: false,

						});
						window.location.href = "rac-records.php";
						$(".row1" + archiveRepair).empty();
					},
					error: function(xhr, status, error) {
						console.error(error);
					}
				});
			});
		});

		function copyDate(rowId) {
			var dateStart = document.getElementById('dateStart' + rowId).value;
			var dateFinish = document.getElementById('dateFinish' + rowId);
			var sameDate = document.getElementById('sameDate' + rowId);
			if (sameDate.checked) {} else {
				dateFinish.value = '';
			}
		}

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

</body>

</html>