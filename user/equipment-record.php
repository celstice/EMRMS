<?php 
// EQUIPMENT RECORD interface
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
$currentDate = date('Y-m-d');

if (isset($_GET['id'])) {
	$id = $_GET['id'];
	$sql = mysqli_query($connect, "SELECT * FROM equipments WHERE equipment_id = '$id'");
} else{ header('location:../error.php');}
$data = mysqli_fetch_array($sql);
$eqname = $data['equip_name'];
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
		<section id="section" class="">
			<div id="content" class="content mt-5">

				<div class="container overflow-auto pb-5">

					<!-- TITLE -->
					<div id="eq-title" class="d-flex justify-content-between m-3">
						<h2><?php echo htmlspecialchars($data['equip_name'], ENT_QUOTES, 'UTF-8'); ?></h2>
					</div>
					<div id="eq-btn" class="d-flex justify-content-end m-1">
						<!-- update -->
						<a href="user-update.php?id=<?php echo $data['equipment_id']; ?>" class="btn btn-success fsz m-1 d-flex align-items-center">Update</a>
						
						<!-- generate record -->
						<form method="post" action="../config/generate-record.php">
							<input hidden name="eq-id" id="eq-id" value="<?php echo $data['equipment_id']; ?>">
							<button type="submit" name="generate-dox" id="generate-dox" class="btn btn-warning m-1 fsz">Generate Record</button>
						</form>

						<!-- create qr -->
						<form method="post" action="../config/create-qr.php">
							<input hidden name="equip-id" id="equip-id" value="<?php echo $data['equipment_id']; ?>">
							<input hidden name="name" id="name" value="<?php echo $data['equip_name']; ?>">
							<button type="submit" name="download-qr" id="download-qr" class="btn btn-primary m-1 fsz">Create QR</button>
						</form>
					</div>

					<!-- EQUIPMENT INFO -->
					<div class="container-fluid mb-5">
						<div class="pb-2 text-center">
							<span class=" text-uppercase fw-bold h6">Equipment Information</span>
						</div>
						<table class=" mb-5 border">
							<tr class="border">
								<td scope="col" class="col-5 border">Name of equipment / device:</td>
								<td><?php echo htmlspecialchars($data['equip_name'], ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
							<tr class="border">
								<td scope="col" class="col-5 border">Category:</td>
								<td><?php echo htmlspecialchars($data['category'], ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
							<tr class="border">
								<td scope="col" class="col-5 border">Equipment Model:</td>
								<td><?php echo htmlspecialchars($data['equip_model'], ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
							<tr class="border">
								<td scope="col" class="col-5 border">Brand / Label:</td>
								<td><?php echo htmlspecialchars($data['brand_label'], ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
							<tr class="border">
								<td scope="col" class="col-5 border">Property Number:</td>
								<td><?php echo htmlspecialchars($data['property_number'], ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
							<tr class="border">
								<td scope="col" class="col-5 border">Location:</td>
								<td><?php echo htmlspecialchars($data['equip_location'], ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
							<tr class="border">
								<td scope="col" class="col-5 border">Status:</td>
								<td><?php echo htmlspecialchars($data['equip_status'], ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
							<tr class="border">
								<td scope="col" class="col-5 border">Date put into Service:</td>
								<td><?php echo htmlspecialchars(date("F j, Y", strtotime($data['date_service'])), ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
							<tr class="border">
								<td scope="col" class="col-5 border">Person Responsible for the Equipment:</td>
								<td><?php echo htmlspecialchars($data['assigned_person'], ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
						</table>

						<div class="pb-2 text-center">
							<span class=" text-uppercase fw-bold h6">Purchase Details</span>
						</div>
						<table class="mb-5 border">
							<tr class="border">
								<td scope="col" class="col-5 border">Date Purchased:</td>
								<td><?php echo htmlspecialchars(date("F j, Y", strtotime($data['date_purchased'])), ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
							<tr class="border">
								<td scope="col" class="col-5 border">Price:</td>
								<td><?php echo htmlspecialchars(number_format($data['price'], 2, '.', ','), ENT_QUOTES, 'UTF-8'); ?></td>
							</tr>
						</table>

						<div class="row">
							<div class="col-6 mb-3">
								<label for="warranty" class="fst-italic">Remarks:</label>
								<div class="d-flex">
									<?php echo htmlspecialchars($data['notes_remarks'], ENT_QUOTES, 'UTF-8'); ?>
								</div>
							</div>
						</div>

						<div class="mt-3 d-flex justify-content-end">
							<button type="button" name="archiveEq" id="<?php echo $data['equipment_id']; ?>" class="btn btn-outline-danger archive fsz d-flex align-items-center" data-bs-toggle="modal" data-bs-target="#archiveEquip<?php echo $data['equipment_id']; ?>"><i class="fa-solid fa-trash me-2"></i>Archive Record</button>
							
							<!-- ARCHIVE-Equipment MODAL -->
							<div class="modal fade" id="archiveEquip<?php echo $data['equipment_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="card text-center border-0 m-5 d-flex justify-content-center">
											<div class="mb-4">
												<h5>Archive Equipment Record</h5>
												<p>Are you sure you want to archive this equipment record?</p>
											</div>
											<div class="d-flex justify-content-center">
												<button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
												<button type="button" name="archiveEQ" id="<?php echo $data['equipment_id']; ?>" class="btn btn-success archiveEQ"><i class="fa-solid fa-square-check p-1"></i>Yes</button>
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- ARCHIVE-Equipment MODAL END -->

						</div>
						<hr>

						<div class="pb-2 text-center">
							<span class=" text-uppercase fw-bold h6">Maintenance Records</span>
						</div>
						<?php
						$eqID = $data['equipment_id'];
						$sql = mysqli_query($connect, "SELECT * FROM maintenance_records WHERE equipment_id = '$eqID' AND userID = '$user' ORDER BY mnt_id DESC LIMIT 1");
						$mnt = mysqli_fetch_assoc($sql);
						$id1 = $eqID; ?>

						<!-- LAST MNT -->
						<!-- <div class="d-flex align-items-center lh-1 mt-3 text-muted"> -->
						<!-- <button class="border-0 m-0 p-1 bg-transparent text-muted opacity-50" data-bs-toggle="modal" data-bs-target="#add-last"><i class="fa-solid fa-edit"></i></button> -->
						<!-- EDIT LAST MNT MODAL -->
						<!-- <div class="modal fade" id="add-last" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header text-dark">
											<h5 class="modal-title" id="exampleModalLabel">Edit Last Maintenance</h5>
											<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
										</div>
										<div class="m-3">
											<form method="post" action="../config/set.php">
												<input hidden name="eq-id" value="<?php echo $mnt['equipment_id'] ?>" required>
												<label class="fst-italic mb-2">Last Maintenance Schedule:</label>
												<input type="date" name="last" id="last" class="form-control mb-3 col-sm" value="<?php echo $mnt['last_mnt'] ?>" required>
												<button type="submit" class="btn btn-secondary" id="add-last" name="add-last">Save</button>
											</form>

										</div>
									</div>
								</div>
							</div> -->
						<!-- EDIT LAST MNT MODAL end -->

						<!-- LAST MNT INFO -->
						<!-- <p class="p-1 fst-italic">Last Maintenance Schedule: &nbsp;</p>
							<h6 class="p-1">
								<?php 
								if (!empty($mnt['last_mnt']) && $mnt['last_mnt'] !== "0000-00-00") {
									echo "<span class='fw-bold'>" . date("F j, Y", strtotime($mnt['last_mnt'])) . "</span>";
								} else {
									echo "<span class='text-primary'>No record</span>";
								} 
								?>
							</h6> -->
						<!-- </div> -->

						<!-- NEXT MNT -->
						<div class="d-flex justify-content-start mt-3 align-items-center mb-4">
							<h5 class="p-1">Next Maintenance Schedule: &nbsp;</h5>
							<h6 class="p-1">
								<?php if (!empty($mnt['next_mnt']) && $mnt['next_mnt'] !== "0000-00-00") {
									echo "<span class='fw-bold'>" . htmlspecialchars(date("F j, Y", strtotime($mnt['next_mnt'])), ENT_QUOTES, 'UTF-8') . "</span>";
								} else {
									echo "<button href='user-schedule.php' class='text-decoration-none btn btn-primary' data-bs-toggle='modal' data-bs-target='#set" . $eqID . "'>Set Maintenance Schedule</button>";
								}
								?>
							</h6>
						</div>

						<!-- MAINTENANCE INFO -->
						<div class="overflow-auto">
							<table class="border text-center">
								<thead class="border-bottom">
									<th class="th-bg">Maintenance Date</th>
									<th class="th-bg">Maintained By</th>
									<th class="th-bg">Description</th>
									<th class="th-bg">Notes/Remarks</th>
								</thead>
								<?php

								$eqID = $data['equipment_id'];
								$select = "SELECT * FROM maintenance_records WHERE equipment_id='$eqID' AND userID = '$user' AND last_mnt IS NOT NULL ORDER BY mnt_id DESC";
								$result2 = mysqli_query($connect, $select);
								if ($result2 && mysqli_num_rows($result2) > 0) {
									while ($row2 = mysqli_fetch_assoc($result2)) { ?>
										<tr class="border">
											<td><?php if (!empty($row2['last_mnt']) && $row2['last_mnt'] !== "0000-00-00") { echo htmlspecialchars(date("F j, Y", strtotime($row2['last_mnt'])), ENT_QUOTES, 'UTF-8'); } else { echo "None"; } ?></td>
											<td><?php echo htmlspecialchars($row2['maintained_by'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td><?php echo htmlspecialchars($row2['mnt_description'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td><?php echo htmlspecialchars($row2['notes_remarks'], ENT_QUOTES, 'UTF-8'); ?></td>
										</tr>
								<?php }
								} else {
									echo "<tr class='text-center'><td colspan='6'>no records</td></tr>";
								} ?>
							</table>
						</div>
					</div>

				</div>

			</div>
		</section>
	</div>

	<!-- SET MAINTENANCE MODAL -->
	<div class="modal fade" id="set<?php echo $eqID; ?>" aria-hidden="true">
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
							<select name="equip-id" id="equip-id" class="form-select pe-none" placeholder="..." required>
								<option selected class="text-muted" value="<?php echo $eqID; ?>"><?php echo $eqname; ?></option>
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
						<button type="submit" name="set-mnt" class="btn btn-info">Set Schedule</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- SET MAINTENANCE MODAL END -->

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
			$('#saveRecord').on('click', function() {
				var id = $(this).data('id');
				$.ajax({
					url: '../config/save-record.php',
					method: 'POST',
					data: {
						id: id
					},
					success: function(response) {
						console.log(response);
						window.location.reload();
					},
					error: function(xhr, status, error) {
						console.error(error);
					}
				});
			});

			$('.archiveEQ').on('click', function() {
				var archiveEQ = $(this).attr('id');
				$.ajax({
					type: "POST",
					url: "../config/archive.php",
					data: {
						archiveEQ: archiveEQ
					},
					success: function(response) {
						console.log(response);
						Swal.fire({
							title: 'Archiving...',
							allowOutsideClick: false,
							showConfirmButton: false,

						});
						window.location.href = 'user-records.php'
					},
					error: function(xhr, status, error) {
						console.error(error);
					}
				});
			});
		});
	</script>

</body>

</html>