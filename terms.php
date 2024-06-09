<?php
require_once 'config/signin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Terms and Conditions</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="assets/css/login.css" rel="stylesheet">
</head>

<body>

  <div class="container-fluid ps-md-0">
    <div class="row g-0">
      
      <div id="left" class="d-none d-md-flex col-md-4 col">
        <div class="container d-flex flex-column justify-content-center align-items-center">
          <div id="logo" class="d-flex"><img class="logo-img" src="assets/img/clsu-logo.png">
            <section class="logo-text">CLSU</section>
          </div>
          <p><span></span>Equipment<span></span>Repair and<span></span> Maintenance<span></span> Services</p>
        </div>
      </div>

      <div id="" class="col-md-8 col-lg-8">

        <a href="register.php" id="back" class="fst-italic ms-3 me-3 mt-2 text-decoration-none text-dark">
          <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to index page</span>
        </a>

        <div class="login d-flex align-items-center overflow-auto">
          <div class="container col-md-9 overflow-auto">
            <h3 class="login-heading mb-3 text-uppercase text-center">Terms and Conditions</h3>
            <div class="row">
              <p>These terms and conditions govern your use of the website and registration process. By registering on this website, you agree to comply with these Terms.

              <br><br><span class="fw-bold fst-italic">User Eligibility:</span>

              You must be at least 18 years old to register on this website.
              By registering, you confirm that you have the legal capacity to enter into a binding agreement.

              <br><br><span class="fw-bold fst-italic">Registration Information:</span>

              You agree to provide accurate, current, and complete information during the registration process.
              You are responsible for maintaining the confidentiality of your account credentials and for all activities that occur under your account.
                  
              <br><br><span class="fw-bold fst-italic">User Content:</span>

              You are solely responsible for any content you submit, post, or display on the website.
                  
              <br><br><span class="fw-bold fst-italic">Website Access:</span>

              We reserve the right to modify, suspend, or discontinue the website or any part of it at any time without notice.
              We may restrict access to certain features or parts of the website to registered users.

              <br><br><span class="fw-bold fst-italic">Termination:</span>

              We reserve the right to terminate or suspend your account at our discretion without notice, for any reason, including violation of these Terms.

              <br><br><span class="fw-bold fst-italic">Changes to Terms:</span>

              We reserve the right to update or modify these Terms at any time without prior notice. It is your responsibility to review these Terms periodically.
                  
              <br><br>By registering on this website, you acknowledge that you have read, understood, and agree to be bound by these Terms and any future modifications. If you have any questions regarding these Terms, please contact us at caps19.0867@gmail.com.</p>

            </div>
          </div>
        </div>

      </div>

    </div>
  </div>
  
</body>
<script>
  function loading() {
    Swal.fire({
      title: 'Logging in...',
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
</script>

</html>