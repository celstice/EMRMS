<?php
// ADMIN INVENTORY interface
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
					<a href="admin-inventory.php" class="list-group-item  py-2 ripple active-btn">
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
			<div class="content mt-5" id="content">

				<div class="container-fluid overflow-auto pb-5">
					<div id="adm-inv" class="content-title d-flex justify-content-between m-3">
						<h3>Aircon Inventory Records</h3>
						<div class="addinvbtn d-flex">
							<form method="post" action="../config/generate-reports.php">
								<button name="download" id="download" class="btn btn-primary fsz text-uppercase ms-1 me-1">Download</button>
								<a href="admin-add-inv.php" class="btn btn-warning text-uppercase fsz ms-1 me-1">Add Inventory</a>
							</form>
						</div>
					</div>

					<div class="container p-0 overflow-auto w-100 pb-5">
						<table class="table overflow-auto mt-1 mb-3 border border-dark shadow-sm bg-body rounded rounded-1">
							<thead class="text-center bg-">
								<tr>
									<th rowspan="4" class="bg-light text-dark border border-1 border-dark th-bg">Actions</th>
									<th rowspan="4" class="bg-light text-dark border border-1 border-dark th-bg">Area</th>
									<th rowspan="4" class="bg-light text-dark border border-1 border-dark th-bg">Floor Area</th>
									<th colspan="2" rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">type</th>
									<th rowspan="4" class="bg-light text-dark border border-1 border-dark th-bg">Status</th>
									<th colspan="2" rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">Quantity</th>
									<th colspan="2" rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">Category</th>
									<th colspan="4" rowspan="" class="bg-light text-dark border border-1 border-dark th-bg">Nameplate Rating</th>
									<th rowspan="4" colspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Year of Purchase</th>
									<th colspan="2" rowspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Operation</th>
								</tr>
								<tr>
									<th rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">Cooling Capacity</th>
									<th rowspan="3" class="bg-light text-dark border border-1 border-dark th-bg">Capacity Rating</th>
									<th colspan="2" rowspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Energy Efficiency Ratio</th>
								</tr>
								<tr>
									<th rowspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Hours per Day</th>
									<th rowspan="2" class="bg-light text-dark border border-1 border-dark th-bg">Days per Week</th>
								</tr>
								<tr>
									<th class="bg-light text-dark border border-1 border-dark th-bg">ST</th>
									<th class="bg-light text-dark border border-1 border-dark th-bg">WT</th>
									<th class="bg-light text-dark border border-1 border-dark th-bg">ST</th>
									<th class="bg-light text-dark border border-1 border-dark th-bg">WT</th>
									<th class="bg-light text-dark border border-1 border-dark th-bg">ST</th>
									<th class="bg-light text-dark border border-1 border-dark th-bg">WT</th>
									<th class="bg-light text-dark border border-1 border-dark th-bg">ST</th>
									<th class="bg-light text-dark border border-1 border-dark th-bg">WT</th>
								</tr>
							</thead>
							<tbody class="text-center">
								<?php
								$inv = mysqli_query($connect, "SELECT * FROM admin_inventory WHERE archive=0");
								if (mysqli_num_rows($inv) > 0) {
									while ($row = mysqli_fetch_assoc($inv)) {
										$year = htmlspecialchars($row['year_purchase'], ENT_QUOTES, 'UTF-8');
										$date = htmlspecialchars(date("F Y", strtotime($year)), ENT_QUOTES, 'UTF-8'); ?>
										<tr class="border border-1 border-dark tr">
											<td class="  border border-1 border-dark">
												<div class="dropdown">
													<a class="btn btn-success fsz dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
														Actions
													</a>
													<ul class="dropdown-menu m-0 p-0">
														<li><a href="admin-update-inv.php? id=<?php echo $row['admin_inv_id'] ?>" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#mnt-done<?php echo $mntID; ?>">Update</a></li>
														<li><a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-placement="top" title="Archive" data-bs-toggle="modal" data-bs-target="#archiveINV<?php echo $row['admin_inv_id']; ?>">Archive</a></li>
													</ul>
												</div>

												<!-- ARCHIVE-INV MODAL -->
												<div class="modal fade" id="archiveINV<?php echo $row['admin_inv_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="card text-center border-0 m-5 d-flex justify-content-center">
																<div class="mb-4">
																	<h5>Archive Inventory Record</h5>
																	<p>Are you sure you want to archive this inventory record?</p>
																</div>
																<div class="d-flex justify-content-center">
																	<button type="button" class="btn btn-warning me-3" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
																	<button type="button" name="archiveAdminINV" id="<?php echo $row['admin_inv_id']; ?>" class="btn btn-success archiveAdminINV"><i class="fa-solid fa-square-check p-1"></i>Yes</button>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- ARCHIVE-INV MODAL END -->

											</td>
											
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['area'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['ac_floor_area'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php if ($row['type_st'] == "Split Type") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></td>
											<td class="border border-1 border-dark"><?php if ($row['type_wt'] == "Window Type") {echo '<i class="fa-solid fa-check"></i>';} else {echo '';} ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['qty_st'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['qty_wt'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['category_st'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="text-nowrap border border-1 border-dark"><?php echo htmlspecialchars($row['category_wt'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['cooling_capacity'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['capacity_rating'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['energy_st'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['energy_wt'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td colspan="2" class="text-nowrap border border-1 border-dark"><?php echo ($year != null ? $date : ''); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['operation_hours'], ENT_QUOTES, 'UTF-8'); ?></td>
											<td class="border border-1 border-dark"><?php echo htmlspecialchars($row['operation_days'], ENT_QUOTES, 'UTF-8'); ?></td>
										</tr>
								<?php  }
								} else {
									echo "<tr class='text-center'><td colspan='22'>no records</td></tr>";
								} ?>
							</tbody>
						</table>
					</div>
				</div>

			</div>
		</section>
	</div>

	<?php include '../include/scripts.php'; ?>

	<script>
		// archive button
		$(document).ready(function() {
			$('.archiveAdminINV').on('click', function() {
				var adminINV = $(this).attr('id');
				$.ajax({
					url: '../config/admin-archive.php',
					type: 'POST',
					data: {
						adminINV: adminINV
					},
					success: function(response) {
						console.log(response);
						Swal.fire({
							title: 'Archiving...',
							allowOutsideClick: false,
							showConfirmButton: false,
						});
						window.location.reload();
						$(".tr" + adminINV).empty();
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