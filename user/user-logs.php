<?php 
// USER: LOGS interface
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
					<a href="user-logs.php" class="list-group-item  py-2 ripple active-btn">
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
			<div class="content mt-5 pb-5" id="content">

				<div class="">

					<div class="pt-3">
						<div class="content-title d-flex justify-content-center">
							<h2>Log Records</h2>
						</div>
					</div>

					<div class="container-fluid ps-5 pe-5">
						<div class="table-div h-100x borderx ps-5 pe-5 pt-3 pb-3 overflow-auto">

							<table id="userlogs-tbl" class="table pt-3">
								<thead class="text-center border-bottom border-dark fw-bold">
									<tr>
										<th hidden class="border-end th-bg">ID</th>
										<th class="border-end th-bg">User</th>
										<th class="border-end th-bg">Action</th>
										<th class="border-end th-bg">Date</th>
										<th class="th-bg">Time</th>
									</tr>
								</thead>
								<tbody class="text-center">
									<?php
									$logs = mysqli_query($connect, "SELECT system_logs.*,users.username FROM system_logs JOIN users ON system_logs.userID=users.userID WHERE system_logs.userID='$user' ORDER BY timestamp DESC");
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
		$(document).ready(function() {
			$('#userlogs-tbl').DataTable({
				"order":[[0,"desc"]]
			});
		});
	</script>

	<?php include '../include/scripts.php'; ?>

</body>

</html>