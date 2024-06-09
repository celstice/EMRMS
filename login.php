<?php
require_once 'config/signin.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>USER login</title>
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
        <div id="leftside" class="container d-flex flex-column justify-content-center align-items-center">
          <div id="logo" class="d-flex"><img class="logo-img" src="assets/img/clsu-logo.png">
            <section class="logo-text">CLSU</section>
          </div>
          <p id="sidetext"><span></span>Equipment<span></span>Repair and<span></span> Maintenance<span></span> Services</p>
        </div>
      </div>

      <div id="" class="col-md-8 col-lg-8">

        <a href="index.php" id="back" class="fst-italic ms-3 me-3 mt-2 text-decoration-none text-dark">
          <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to index page</span>
        </a>

        <div class="login d-flex align-items-center py-5 ">
          <div class="container col-md-7">
            <div class="row">
              <div class="col-md-9 col-lg-8 mx-auto">
                
                <h2 class="login-heading mb-4">LOGIN</h2>

                <!-- Sign In Form -->
                <form method="post" action="" onsubmit="loading()">
                  
                  <div class="form-floating mb-3 ">
                    <input type="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" autofocus value="<?= htmlspecialchars($_POST['email'] ?? ""); ?>" placeholder="">
                    <?php if (isset($errors['email'])) : ?>
                      <div id="errortext" class="d-flex justify-content-center">
                        <span class="text-danger text-center m-1 p-1"><?= $errors['email'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></span>
                      </div>
                    <?php endif; ?>
                    <label for="floatingInput">Email</label>
                  </div>

                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password" autofocus value="<?= htmlspecialchars($_POST['password'] ?? ""); ?>">
                    <label for="floatingPassword">Password</label>
                    <?php if (isset($errors['password'])) : ?>
                      <div class="text-danger text-center m-1" id="errortext"><?= $errors['password'] ?><i class="fa-solid fa-circle-exclamation ms-1"></i></div>
                    <?php endif; ?>
                  </div>

                  <div class="d-grid justify-content-end">
                    <button type="submit" name="login" class="btn btn-lg btn-warning btn-login text-uppercase fw-bold mb-2">LOGIN</button>
                  </div>

                </form>

                <div class="d-flex flex-column text-center justify-content-center mt-3">
                  <div class="m-1">
                    <a href="config/reset-pw.php" class="small text-decoration-none fst-italic text-success">Forgot Password.</a>
                  </div>
                  <div class="m-1">
                    <a href="register.php" class="small text-decoration-none fst-italic text-success">Don't have an account? Register</a>
                  </div>
                </div>

              </div>
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