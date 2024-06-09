<?php
include 'config/connect.php';
session_start();

if (!isset($_SESSION['user'])) {
  header('location:login.php');
}
$user = $_SESSION['user']['userID'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Verify Account</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
        <div class="login d-flex align-items-center py-5 ">
          <div class="container col-md-7">
            <div class="row">
              <div class="col-md-9 col-lg-8 mx-auto">

                <h2 class="login-heading mb-4">Verify Account</h2>

                <?php
                $user = $_SESSION['user']['userID'];
                $code = strtoupper(bin2hex(random_bytes(3)));
                $encode = $_SESSION['code'] = $code;

                $getEmail = mysqli_query($connect, "SELECT * FROM users WHERE userID ='$user'");
                $row = mysqli_fetch_assoc($getEmail);
                $email = $row['email'];
                ?>

                <div class=" mb-3">
                  <div>
                    <span class="">Click <span class="fw-bold text-success">Send</span> to send the verification code to your email.</span><br><br>
                    <div class="d-flex justify-content-between m-0">
                      <input name="user-mail" class="form-control-plaintext fw-bold fst-italic" value="<?php echo $email; ?>">
                      <button type="button" name="codex" id="<?php echo $encode; ?>" class="btn btn-success codex">Send</button>
                    </div>
                  </div>
                </div>

                <form method="post" action="" id="verification-form">
                  <div class="form-floating mb-3 ">
                    <input hidden name="encode" id="encode" class="encode" value="<?php echo $encode; ?>">
                    <input type="text" class="form-control" id="vcode" name="vcode" placeholder="" autofocus>
                    <label for="v-code">Verification Code</label>
                  </div>
                  <div class="d-grid justify-content-end">
                    <button type="submit" name="verify" id="verify" class="btn btn-lg verify btn-warning btn-login text-uppercase fw-bold mb-2">OK</button>
                  </div>
                </form>

              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>


  <script type="text/javascript">
    $(document).ready(function() {
      $('.codex').on('click', function() {
        var codex = $(this).attr('id');
        Swal.fire({
          title: 'Sending Verification Code',
          text: 'Please wait...',
          showConfirmButton: false,
          allowOutsideClick: false,
          didOpen: () => {
            // Perform the AJAX request to send the code
            $.ajax({
              type: "POST",
              url: "config/v-code.php",
              data: {
                codex: codex
              },
              success: function(response) {
                console.log(response);
                Swal.fire({
                  title: 'Success',
                  text: 'Verification code sent.',
                  icon: 'success'
                });
              },
              error: function(xhr, status, error) {
                console.error(error);
                Swal.fire({
                  title: 'Error',
                  text: 'An error occurred while sending the verification code',
                  icon: 'error'
                });
              }
            });
          }
        });
      });

      $('.verify').on('click', function() {
        event.preventDefault();
        var encode = $('#encode').val();
        var vcode = $('#vcode').val();

          if (vcode === encode) {
            $.ajax({
              type: "POST",
              url: "config/verification.php",
              data: {
                encode: encode,
                vcode: vcode
              },
              success: function(response) {
                console.log(response);
                Swal.fire({
                  title: 'Account Verified',
                  text: 'Please Login',
                  icon: 'success',
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  allowEnterKey: false,
                  showConfirmButton: false,
                  persistent: true,
                  footer: '<form method="post" action="config/redirect-login.php"><input hidden name="userID" value="<?php echo $user; ?>"><button name="redirect-login" class="btn btn-success">LOGIN</button></form>',
                });
              },
              error: function(xhr, status, error) {
                console.error(error);
                Swal.fire({
                  title: 'Error',
                  text: 'An error occurred. Try again.',
                  icon: 'error'
                });
                window.location.reload();
              }
            });
            console.log('encode:', encode);
            console.log('vcode:', vcode);
          } else {
            Swal.fire({
              title: 'Error',
              text: 'Error. Invalid code. Try again.',
              icon: 'error'
            });
          }
          
      });
    });
  </script>
</body>

</html>