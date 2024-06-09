<?php
$users = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM users WHERE userID = '$user'"));
?>
<!-- UDPATE PROFILE DIV -->
<div class="container">
    <div class="container" id="profile">
        <div class="tea-green-bgx cardx rounded border border-success shadow">
            <div class="">
                <div class="border-bottomx border-success border-4 pt-2x">
                    <div class="d-flex justify-content-center  pt-3x bg-success">
                        <img src="../assets/img/clsu-logo1.png" id="profile-img" class="rounded-circle bg-white" />
                    </div>
                </div>
            </div>

            <form method="post" action="" onsubmit="updating();">
                <div class="form-div d-flex flex-column justify-content-center pt-5">
                    <div class="text-center">
                        <h5 class="fw-bold mt-2">Update Profile:</h5>
                    </div>
                    <div class="pt-3 d-flex flex-column justify-content-center ps-5 pe-5" id="">
                        <span class="fw-bold mb-1">Name</span>
                        <?php if (isset($errors['firstname'])) : ?>
                            <span class="text-danger text-center m-1" id="errortext"><?= $errors['firstname'] ?></span>
                        <?php endif; ?>
                        <input type="text" class="form-control form-control-lgx" name="fn" id="fn" autofocus value="<?= htmlspecialchars($_POST['fn'] ?? $users['firstname']) ?>">
                    </div>
                    <div class=" pt-3 d-flex flex-column justify-content-center ps-5 pe-5" id="">
                        <span class="fw-bold mb-1">Surname</span>
                        <?php if (isset($errors['lastname'])) : ?>
                            <span class="text-danger text-center m-1" id="errortext"><?= $errors['lastname'] ?></span>
                        <?php endif; ?>
                        <input type="text" class="form-control form-control-lgx" name="ln" id="ln" autofocus value="<?= htmlspecialchars($_POST['ln'] ?? $users['lastname']) ?>">
                    </div>
                    <div class="pt-3 d-flex flex-column justify-content-center ps-5 pe-5" id="">
                        <span class="fw-bold mb-1">Email</span>
                        <?php if (isset($errors['email'])) : ?>
                            <span class="text-danger text-center m-1" id="errortext"><?= $errors['email'] ?></span>
                        <?php endif; ?>
                        <input type="email" class="form-control form-control-lgx" name="email" id="email" autofocus value="<?= htmlspecialchars($_POST['email'] ?? $users['email']) ?>">
                    </div>

                    <span class="fw-bold pt-3 ps-5 pe-5 mb-1">Username</span>
                    <?php if (isset($errors['username'])) : ?>
                        <span class="text-danger text-center m-1" id="errortext"><?= $errors['username'] ?></span>
                    <?php endif; ?>
                    <div class="input-group ps-5 pe-5">
                        <span class="input-group-text border" id="basic-addon1">@</span>
                        <input type="text" class="form-control form-control-lgx border" name="username" id="username" autofocus value="<?= htmlspecialchars($_POST['username'] ?? $users['username']) ?>">
                    </div>
                    <div class="pt-3 d-flex flex-column justify-content-center ps-5 pe-5" id="">
                        <span class="fw-bold mb-1">Location / Office</span>
                        <?php if (isset($errors['location'])) : ?>
                            <span class="text-danger text-center m-1" id="errortext"><?= $errors['location'] ?></span>
                        <?php endif; ?>
                        <input type="" class="form-control form-control-lgx border" name="location" id="location" autofocus value="<?= htmlspecialchars($_POST['location'] ?? $users['user_location']) ?>">
                    </div>

                    <div class="mt-4 pb-4 ps-5 pe-5 d-flex justify-content-around align-items-center" id="update-divbtn">
                        <div class="ps-5 pe-5 mt-1 mb-1">
                            <a href="<?php if ($role === "user") {echo '../user/user-profile.php';} else if ($role === "admin") {echo '../admin/admin-profile.php';} ?>"" class=" ps-5 pe-5 btn btn-danger">CANCEL</a>
                        </div>
                        <div class="ps-5 pe-5 mt-1 mb-1">
                            <button type="submit" name="update-profile" id="update-profile" class="ps-5 pe-5 btn btn-success">SAVE</button>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
<script>
    function updating() {
        Swal.fire({
            title: 'Updating User Information...',
            allowOutsideClick: false,
            showConfirmButton: false,
            didOpen: () => {
                Swal.updating();
            },
        });
    }

    function hideLoading() {
        Swal.close();
    }
</script>