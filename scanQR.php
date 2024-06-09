<?php
include 'config/connect.php';
?>

<!DOCTYPE HTML>

<html>

<head>
	<title>QR SCANNER</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
	<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
	<script src="assets/js/qr-scanner.min.js"></script>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="assets/css/main.css" />
	<link rel="stylesheet" href="assets/downloads/fontawesome-web/css/all.min.css">
	<style>
		#scanqr {
			background-color: #24fe86;
			background-image: linear-gradient(180deg, #24fe86 19%, #FFFB7D 100%);
			background-repeat: no-repeat;
			background-size: cover;
		}

		#qr {
			font-size: 20rem !important;
			z-index: 1 !important;
		}

		.logo-qr {
			z-index: -1000 !important;
			width: 5rem !important;
			height: 5rem !important;
		}

		.icon-container {
			position: relative;
			width: 50px;
			/* Set the width of your container */
			height: 50px;
			background-image: url('assets/img/clsu-logo.png');
			z-index: 1 !important;

			/* Set the height of your container */
		}
	</style>
</head>

<body id="" class="is-preload h-100">

	<!-- Main -->
	<div id="">
		<section id="" class="">
			<div id="" class="content pt-3">

				<div class="float-left">
					<a href="index.php" id="back" class="fst-italic ms-3 text-decoration-none text-dark">
						<i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to previous page</span>
					</a>
				</div>

				<div class="card pb-5 border-0" id="">

					<div class="card-header d-flex justify-content-center align-items-center border-0 bg-transparent">
						<section class="fw-bold text-uppercase text-center d-flex justify-content-center align-items-center ">
							<h1 class="m-3">QR SCANNER</h1>
						</section>
					</div>
					<div class="d-flex justify-content-center align-items-center flex-column">
						<div id="" class="d-flex justify-content-center align-items-center text-decoration-none text-dark mb-3"></div>
					</div>

					<div id="result"></div>

					<div class="d-flex justify-content-center ">
						<div class="container border-5 border border-success rounded m-0 p-0">
							<div id="reader" width="600px"></div>
							<!-- <video id="preview" class="bg-danger" width="100%"></video> -->
						</div>
					</div>

				</div>
			</div>
		</section>

	</div>

	<script>
		$(document).ready(function() {

			function hideIconContainer() {
				// $('#icon-container').hide();
				$('#icon-container').css('display', 'none');
			}

			// Function to show the icon container
			function showIconContainer() {
				// $('#icon-container').show();
				$('#icon-container').css('display', 'flex');
			}

			function onScanSuccess(decodedText, decodedResult) {
				console.log(decodedText);
				console.log(decodedResult);

				//  OPTION #1
				// window.open(decodedText, '_blank');

				//  OPTION #2
				try {
					window.location.href = decodedText;
					window.open(decodedText, '_blank');
				} catch (error) {
					console.error("Error parsing QR code data:", error);
				}
			}

			function onScanFailure(error) {
				console.warn(`Code scan error = ${error}`);
				console.error("Failed to scan QR code:", error);
			}

			const html5QrcodeScanner = new Html5QrcodeScanner(
				"reader", {
					fps: 20,
					qrbox: {
						width: 500,
						height: 500
					}
				},
				verbose = false);
			html5QrcodeScanner.render(onScanSuccess, onScanFailure);
		});
	</script>

	<?php include 'include/scripts.php'; ?>

</body>

</html>