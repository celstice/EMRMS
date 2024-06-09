<?php 
// ADMIN: VIEW LOGS interface (can view user logs)
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
					<a href="admin-logs.php" class="list-group-item  py-2 ripple active-btn">
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
			<div class="content mt-5" id="content">

				<div class="container-fluid overflow-auto pb-5">

					<div class="pt-3">
						<div class="content-title d-flex justify-content-center">
							<h2>Log Records</h2>
						</div>
					</div>

					<div class="container-fluid ps-5 pe-5">
						<div class="table-div ps-5 pe-5 pt-3 pb-2 bg-body">
							<table id="adminlogs-tbl" class="table pt-3">
								<thead class="text-center border-bottom border-dark fw-bold">
									<tr>
										<th hidden class="th-bg border-end">ID</th>
										<th class="th-bg border-end">User</th>
										<th class="th-bg border-end">Action</th>
										<th class="th-bg border-end">Date</th>
										<th class="th-bg">Time</th>
									</tr>
								</thead>
								<tbody class="text-center">
									<?php
									$logs = mysqli_query($connect, "SELECT system_logs.*,users.username FROM system_logs JOIN users ON system_logs.userID=users.userID ORDER BY timestamp DESC");
									while ($log = mysqli_fetch_assoc($logs)) {
										$timestamp = htmlspecialchars(strtotime($log['timestamp']), ENT_QUOTES, 'UTF-8');
										$date = htmlspecialchars(date("F j, Y", $timestamp), ENT_QUOTES, 'UTF-8');
										$time = htmlspecialchars(date("h:i A", $timestamp), ENT_QUOTES, 'UTF-8'); ?>
										<tr>
											<td hidden class="border-end"><?php echo $log['log_id']; ?></td>
											<td class="border-end"><?php echo htmlspecialchars($log['username'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border-end"><?php echo htmlspecialchars($log['action_type'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border-end"><?php echo $date; ?></td>
											<td class=""><?php echo $time; ?></td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>

				</div>

			</div>
		</section>
	</div>

	<script>
		// datatable
		$(document).ready(function() {
			$('#adminlogs-tbl').DataTable({
				"order": [
					[0, "desc"]
				]
			});
		});
	</script>
	<?php include '../include/scripts.php'; ?>

</body>

</html>