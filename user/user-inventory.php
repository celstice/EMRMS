<?php 
// USER: INV RECORDS
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
					<a href="user-records.php" class="list-group-item  py-2 ripple">
						<i class="fa-solid fa-folder icon"></i>
						<span class="nav-text">Equipment Records</span>
					</a>
					<a href="user-notice.php" class="list-group-item  py-2 ripple">
						<i class="fa-solid fa-snowflake icon"></i>
						<span class="nav-text">Aircon Maintenance</span>
					</a>
					<a href="user-inventory.php" class="list-group-item  py-2 ripple active-btn">
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
							<h2>Inventory</h2>
						</div>
					</div>

					<div class="container-fluid ps-3 pe-3">
						<div class="table-div h-100x borderx ps-5 pe-5 pt-3 pb-5 overflow-auto">
							
							<div id="add-inv" class="mt-3 mb-3">
								<a href="user-add-inv.php" class="btn btn-primary fsz">Add Inventory</a>
							</div>

							<table id="userinv-tbl" class="table pt-3">
								<thead class="text-center border-bottom border-dark fw-bolder">
									<tr>
										<th hidden class="border-end th-bg">ID</th>
										<th class="border-end th-bg">Equipment</th>
										<th class="border-end th-bg">Property Number</th>
										<th class="border-end th-bg">Quantity</th>
										<th class="border-end th-bg">Price</th>
										<th class="border-end th-bg">Total</th>
										<th class="border-end th-bg">Unit</th>
										<th class="border-end th-bg">Date Acquired</th>
										<th class="border-end th-bg">Location</th>
										<th class="border-end th-bg">Description</th>
										<th class="border-end th-bg">Remarks</th>
										<th class="th-bg">Actions</th>
									</tr>
								</thead>
								<tbody class="text-center">
									<?php
									$query = mysqli_query($connect, "SELECT * FROM user_inventory WHERE archive=0 AND userID = '$user'");
									if (mysqli_num_rows($query) > 0) {
										while ($row = mysqli_fetch_array($query)) { ?>
											<tr class="tr">
												<td hidden><?php echo $row['inv_id']; ?></td>
												<td><?php echo htmlspecialchars($row['inv_item'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($row['property_number'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($row['quantity'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars(number_format(($row['price']), 2, '.', ','), ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars(number_format(($row['total']), 2, '.', ','), ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($row['unit'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php if (!empty($row['date_acquired']) && $row['date_acquired'] !== "0000-00-00") {echo date("F j, Y", strtotime($row['date_acquired']));} else {echo "N/A";} ?></td>
												<td><?php echo htmlspecialchars($row['area_location'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td class="col-4"><?php echo htmlspecialchars(substr_replace($row['description'], ' ...', 50), ENT_QUOTES, 'UTF-8'); ?></td>
												<td><?php echo htmlspecialchars($row['remarks'], ENT_QUOTES, 'UTF-8'); ?></td>
												<td>
													<div class="dropdown">
														<a class="btn btn-success fsz dropdown-toggle m-1" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Actions</a>
														<ul class="dropdown-menu m-0 p-0">
															<li><a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-toggle="modal" data-bs-target="#view-details<?php echo $row['inv_id']; ?>">View</a></li>
															<li><a href="user-update-inv.php?id=<?php echo $row['inv_id']; ?>" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden">Update</a></li>
															<li><a type="button" class="list-group-item border-bottom d-flex justify-content-center ripple text-decoration-none p-2 fsz overflow-hidden" data-bs-placement="top" title="Archive" data-bs-toggle="modal" data-bs-target="#archiveINV<?php echo $row['inv_id']; ?>">Archive</a></li>
														</ul>
													</div>
												</td>
											</tr>

											<!-- ARCHIVE-INV MODAL -->
											<div class="modal fade" id="archiveINV<?php echo $row['inv_id']; ?>" tabindex="-1" aria-labelledby="" aria-hidden="true">
												<div class="modal-dialog">
													<div class="modal-content">
														<div class="card text-center border-0 m-5 d-flex justify-content-center">
															<div class="mb-4">
																<h5>Archive Inventory Record</h5>
																<p>Are you sure you want to archive this inventory record?</p>
															</div>
															<div class="d-flex justify-content-center">
																<button type="button" class="btn btn-warning me-3  d-flex align-items-center fsz" data-bs-dismiss="modal"><i class="fa-solid fa-square-xmark p-1"></i>No</button>
																<button type="button" name="archiveinv" id="<?php echo $row['inv_id']; ?>" class="btn btn-success archiveinv  d-flex align-items-center fsz"><i class="fa-solid fa-square-check p-1"></i>Yes</button>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- ARCHIVE-INV MODAL END -->

											<!-- MODAL VIEW DETAILS -->
											<div id="view-details<?php echo $row['inv_id'] ?>" aria-hidden="true" class="modal modal-md">
												<div class="modal-dialog">
													<div class="modal-content rounded-0">
														<div class="modal-header border-0 text-center d-flex justify-content-center align-items-center">
															<h6 class="text-uppercase fw-bold">Inventory Details</h6>
														</div>
														<div class="modal-body pt-0 pb-0 m-1 d-flex flex-column">
															<div class="border">
																<div class="d-flex justify-content-around flex-column">
																	<div class="border-bottom p-2 d-flex justify-content-center tea-green-bg">
																		<span class="fw-bold text-center"><?php echo $row['inv_item']; ?></span>
																	</div>
																	<div class=" d-flex bg-infox justify-content-evenly">
																		<div class="d-flex flex-column col-5 ">
																			<div class="borderx p-2 d-flex flex-column text-start border-bottom">
																				<span class="fst-italic fw-bold tg-text">Property Number:</span>
																				<span class=""><?php echo $row['property_number']; ?></span>
																			</div>
																			<div class="borderx p-2 d-flex flex-column text-start border-bottom">
																				<span class="fst-italic fw-bold tg-text">Quantity:</span>
																				<span class=""><?php echo $row['quantity']; ?></span>
																			</div>
																			<div class="borderx p-2 d-flex flex-column text-start border-bottom">
																				<span class="fst-italic fw-bold tg-text">Price:</span>
																				<span class=""><?php echo number_format(($row['price']), 2, '.', ','); ?></span>
																			</div>
																			<div class="borderx p-2 d-flex flex-column text-start border-bottom">
																				<span class="fst-italic fw-bold tg-text">Total:</span>
																				<span class=""><?php echo number_format(($row['total']), 2, '.', ','); ?></span>
																			</div>
																			<!-- <hr> -->
																			<div class="borderx p-2 d-flex flex-column text-start border-bottom">
																				<span class="fst-italic fw-bold tg-text">Unit:</span>
																				<span class=""><?php echo $row['unit']; ?></span>
																			</div>
																			<div class="borderx p-2 d-flex flex-column text-start border-bottom">
																				<span class="fst-italic fw-bold tg-text">Date Acquired:</span>
																				<span class=""><?php if (!empty($row['date_acquired']) && $row['date_acquired'] !== "0000-00-00") {echo date("F j, Y", strtotime($row['date_acquired']));} else {echo "N/A";} ?></span>
																			</div>
																			<div class="borderx p-2 d-flex flex-column text-start border-bottom">
																				<span class="fst-italic fw-bold tg-text">Location:</span>
																				<span class=""><?php echo $row['area_location']; ?></span>
																			</div>
																		</div>
																		<div class="d-flex bg-warningx flex-column col-5 ">
																			<div class="borderx p-2 d-flex flex-column text-center align-items-between">
																				<span class="fst-italic fw-bold tg-text">Description:</span>
																				<span class=""><?php echo $row['description']; ?></span>
																			</div>
																			<div class="borderx p-2 d-flex flex-column text-center">
																				<span class="fst-italic fw-bold tg-text">Remarks:</span>
																				<span class=""><?php echo $row['remarks']; ?></span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														<div class="modal-footer border-0 d-flex justify-content-center">
															<button class="tg-text text-upppercase btn btn-secondary bg-opacity-50 text-light fw-bold rounded-0" data-bs-dismiss="modal">CLOSE</button>
														</div>
													</div>
												</div>
											</div>
											<!-- MODAL VIEW DETAILS END -->

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

			$('#userinv-tbl').DataTable({
				"order": [
					[0, "desc"]
				]
			});

			// archive button
			$('.archiveinv').on('click', function() {
				var archiveINV = $(this).attr('id');
				$.ajax({
					url: '../config/archive.php',
					type: 'POST',
					data: {
						archiveINV: archiveINV
					},
					success: function(response) {
						console.log(response);
						Swal.fire({
							title: 'Archiving...',
							allowOutsideClick: false,
							showConfirmButton: false,
						});
						$(".tr" + archiveINV).empty();
						window.location.href = "user-inventory.php";
					},
					error: function(xhr, status, error) {
						console.error(error);
					}
				});
			});

		});
	</script>

	<?php include '../include/scripts.php'; ?>

</body>

</html>