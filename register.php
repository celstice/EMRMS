<?php
require_once('config/signup.php');
?>

<!DOCTYPE html>
<html>

<head>
    <title>Register</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="assets/css/login.css" rel="stylesheet">

    <style>
        #locations-container {
            position: absolute;
            display: none;
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            z-index: 1;
            background: white;

        }

        .loc {
            padding: 8px;
            cursor: pointer;
        }

        .loc:hover {
            background: #D4F6CC;
        }
    </style>
</head>

<body>
    <div class="container-fluid ps-md-0">
        <div class="row g-0">

            <div id="left" class="d-none d-md-flex col-md-4 col">
                <div id="leftside" class="container d-flex flex-column justify-content-center align-items-center position-fixed">
                    <div id="logo" class="d-flex"><img class="logo-img" src="assets/img/clsu-logo.png">
                        <section class="logo-text">CLSU</section>
                    </div>
                    <p class=""><span></span>Equipment<span></span>Repair and<span></span> Maintenance<span></span> Services</p>
                </div>
            </div>

            <div id="" class="col-md-8 col-lg-8">
                
                <a href="index.php" id="back" class="fst-italic ms-3 me-3 mt-2 text-decoration-none text-dark">
                    <i class="fa-solid fa-circle-chevron-left"></i>&nbsp;<span>Go back to index page</span>
                </a>

                <div class="login d-flex align-items-center py- ">
                    <div class="container col-md-7">
                        <div class="row">
                            <div class="col-md-9 col-lg-8 mx-auto">
                                <h2 class="login-heading mb-4 mt-3">REGISTER</h2>

                                <!-- Sign In Form -->
                                <form action="" method="post" name="register-form" id="register-form" onsubmit="loading()">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="firstname" class="form-control" id="floatFName" placeholder="First Name" autofocus value="<?= htmlspecialchars($_POST['firstname'] ?? ""); ?>">
                                        <label for="floatFName">Name <span class="text-danger">*</span></label>
                                        <?php if (isset($errors['firstname'])) : ?>
                                            <div class="text-danger text-center m-1" id="errortext"><?= $errors['firstname'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="lastname" class="form-control" id="floatLName" placeholder="Last Name" autofocus value="<?= htmlspecialchars($_POST['lastname'] ?? "") ?>">
                                        <label for=" floatLName">Surname <span class="text-danger">*</span></label>
                                        <?php if (isset($errors['lastname'])) : ?>
                                            <div class="text-danger text-center m-1" id="errortext"><?= $errors['lastname'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email" class="form-control" id="floatEmail" placeholder="Email" autofocus value="<?= htmlspecialchars($_POST['email'] ?? "") ?>">
                                        <label for=" floatEmail">Email <span class="text-danger">*</span></label>
                                        <?php if (isset($errors['email'])) : ?>
                                            <div class="text-danger text-center m-1" id="errortext"><?= $errors['email'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="location" name="location" class="form-control" id="floatLocation" oninput="getLocations(this.value)" placeholder="ex.(ERMS, CLIRDEC, PPSDS etc.)" autofocus value="<?= htmlspecialchars($_POST['location'] ?? "") ?>">
                                        <label for=" floatLocation">Location / Office: <span class="text-danger">*</span></label>
                                        <div id="locations-container" class="mt-2 shadow-sm rounded hover"></div>
                                        <?php if (isset($errors['location'])) : ?>
                                            <div class="text-danger text-center m-1" id="errortext"><?= $errors['location'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="username" class="form-control" id="floatUsername" placeholder="Username" autofocus value="<?= htmlspecialchars($_POST['username'] ?? "") ?>">
                                        <label for=" floatUsername">Username <span class="text-danger">*</span></label>
                                        <?php if (isset($errors['username'])) : ?>
                                            <div class="text-danger text-center m-1" id="errortext"><?= $errors['username'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" name="password" class="form-control" id="floatPassword" placeholder="Password" autofocus value="<?= htmlspecialchars($_POST['password'] ?? "") ?>">
                                        <label for=" floatPassword">Password <span class="text-danger">*</span></label>
                                        <?php if (isset($errors['password'])) : ?>
                                            <div class="text-danger text-center m-1" id="errortext"><?= $errors['password'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="password" name="cpass" class="form-control" id="floatCpassword" placeholder="Password" autofocus value="<?= htmlspecialchars($_POST['cpass'] ?? "") ?>">
                                        <label for=" floatCpassword">Confirm Password <span class="text-danger">*</span></label>
                                        <?php if (isset($errors['cpass'])) : ?>
                                            <div class="text-danger text-center m-1" id="errortext"><?= $errors['cpass'] ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex flex-column justify-content-start mb-3">
                                        <div class="d-flex justify-content-start">
                                            <input type="checkbox" class="form-check-input border-dark me-2" name="terms" id="terms">
                                            <a href="terms.php" class="text-decoration-none text-dark">Agree to <span class="text-decoration-underline">Terms and Conditions</span><span class="text-danger">*</span></a>
                                        </div>
                                        <?php if (isset($errors['terms'])) : ?>
                                            <span class="text-danger text-center m-1" id="errortext"><?= $errors['terms'] ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="d-flex justify-content-end mb">
                                        <button type="submit" name="register" id="register" class="btn btn-lg btn-warning btn-login text-uppercase fw-bold mb-2" disabledd>REGISTER</button>
                                    </div>
                                    <div class="text-center mt-3 mb-3">
                                        <a href="login.php" class="small text-center text-success fst-italic m-3 text-decoration-none">Already have an account? Login</a>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>
        document.getElementById('terms').addEventListener('change', function() {
            var button = document.getElementById('register');
            button.disabled = !this.checked;
        });

        function loading() {
            Swal.fire({
                title: 'Creating account...',
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

        function getLocations(query) {
            if (query.length === 0) {
                document.getElementById('locations-container').style.display = 'none';
                return;
            }

            fetch('config/fetch-location.php?q=' + query)
                .then(response => response.json())
                .then(data => showLocations(data));
        }

        function showLocations(locs) {
            const container = document.getElementById('locations-container');
            container.innerHTML = '';

            if (locs.length === 0) {
                container.style.display = 'none';
                return;
            }

            locs.forEach(loc => {
                const locationDiv = document.createElement('div');
                locationDiv.className = 'loc';
                locationDiv.textContent = loc;

                locationDiv.addEventListener('click', function() {
                    document.getElementById('floatLocation').value = loc;
                    container.style.display = 'none';
                });

                container.appendChild(locationDiv);
            });

            container.style.display = 'block';

            document.body.addEventListener('click', function(event) {
                const isClickInsideContainer = container.contains(event.target);

                if (!isClickInsideContainer) {
                    container.style.display = 'none';
                }
            });
        }
    </script>
</body>

</html>