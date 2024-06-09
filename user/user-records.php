<?php
// USER: EQUIPMENT RECORDS 
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
		<section id="" class="">
			<div id="content" class="content mt-5 pb-5">

				<div class="">

					<div class="pt-3">
						<div class="content-title d-flex justify-content-center">
							<h2>Equipment Records</h2>
						</div>
					</div>

					<div id="custom-tabs" class="custom-tabs bg-dangerx d-flex">
						<div class="d-flex justify-content-between align-items-center  pt-3 ps-5 pe-5">
							<div class="d-flex p-1">
								<a href="user-records.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 border-start border-5 border-primary rounded-0 bg-primary bg-opacity-25">
									<i class="fa-solid fa-screwdriver-wrench icon p-1"></i>
									<h6 class="fw-mediumm p-1 fsz">Equipments</h6>
								</a>
								<a href="user-schedule.php" class="text-decoration-none btn border-0 text-dark d-flex align-items-center justify-content-between ms-1 me-1 p-2 opacity-75 border-start border-2 rounded-0">
									<i class="fa-solid fa-calendar icon p-1"></i>
									<h6 class="fw-lighter p-1 fsz">Maintenance Schedules</h6>
								</a>
							</div>
						</div>
					</div>


					<div class="container-fluid ps-3 pe-3">
						<div class="table-div h-100x borderx ps-5 pe-5 pt-3 pb-5 overflow-auto">

							<div id="add-equipment" class="d-flex mt-3 mb-3">
								<a href="user-add.php" class="btn btn-primary fsz">Add Equipment record</a>
							</div>

							<table id="equipment-tbl" class="table pt-3">
								<thead class="text-center border-bottom border-dark fw-bolder">
									<tr class="">
										<th hidden class="border-end th-bg">ID</th>
										<th class="border-end th-bg">Name</th>
										<th class="border-end th-bg">Category</th>
										<th class="border-end th-bg">Status</th>
										<th class="border-end th-bg">Last Maintenance</th>
										<th class="border-end th-bg">Next Maintenance</th>
										<th class="border-end th-bg">End-User</th>
										<th class="th-bg">...</th>
									</tr>
								</thead>
								<tbody class="text-center">
									<?php
									$select = "SELECT equipments.equipment_id, equipments.equip_name, equipments.category, equipments.equip_status, equipments.assigned_person, latest_maintenance.last_mnt, latest_maintenance.next_mnt FROM equipments LEFT JOIN ( SELECT equipment_id, MAX(last_mnt) AS last_mnt, MAX(next_mnt) AS next_mnt FROM maintenance_records GROUP BY equipment_id ) AS latest_maintenance ON equipments.equipment_id = latest_maintenance.equipment_id WHERE equipments.userID = '$user' AND equipments.archive = 0 ORDER BY equipments.equipment_id";
									$result = mysqli_query($connect, $select);
									if (mysqli_num_rows($result) > 0) {
										while ($row = mysqli_fetch_assoc($result)) { ?>
											<tr>
												<td hidden><?php echo $row['equipment_id']; ?></td>
												<td><?php echo htmlspecialchars($row['equip_name'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($row['equip_status'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php if (!empty($row['last_mnt']) && $row['last_mnt'] !== "0000-00-00") {echo date("F j, Y", strtotime($row['last_mnt']));} else {echo "None";} ?></td>
												<td><?php if (!empty($row['next_mnt']) && $row['next_mnt'] !== "0000-00-00") {echo date("F j, Y", strtotime($row['next_mnt']));} else {echo "Not set";} ?></td>
												<td><?php echo htmlspecialchars($row['assigned_person'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td class="align-content-center">
													<div class="d-flex justify-content-around">
														<a href="equipment-record.php?id=<?php echo $row['equipment_id']; ?>" class="btn btn-success fsz">View</a>
													</div>
												</td>
											</tr>
									<?php } } ?>
								</tbody>
							</table>
						</div>
					</div>

				</div>

			</div>
		</section>
	</div>

	<script>
		$(document).ready(function() {
			$('#equipment-tbl').DataTable({
				"order": [
					[0, "desc"]
				]
			});
		});
	</script>

	<?php include '../include/scripts.php'; ?>

</body>

</html>