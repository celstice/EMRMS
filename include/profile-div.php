<?php 
$users=mysqli_fetch_assoc(mysqli_query($connect,"SELECT * FROM users WHERE userID = '$user'"));
?>
<!-- PROFILE INFO DIV -->
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

            <div class="d-flex flex-column justify-content-center pt-5">
                <div class="pt-3 d-flex flex-column justify-content-center ps-5 pe-5" id="">
                    <span class="fw-bold mb-1">Name</span>
                    <h2 class="form-control form-control-lgx"><?php echo $users['firstname']; ?></h2>
                </div>

                <div class="pt-3 d-flex flex-column justify-content-center ps-5 pe-5" id="">
                    <span class="fw-bold mb-1">Surname</span>
                    <h2 class="form-control form-control-lgx"><?php echo $users['lastname']; ?></h2>
                </div>

                <div class="pt-3 d-flex flex-column justify-content-center ps-5 pe-5" id="">
                    <span class="fw-bold mb-1">Email</span>
                    <h6 class="form-control form-control-lgx"><?php echo $users['email']; ?></h6>
                </div>

                <span class="fw-bold pt-3 ps-5 pe-5 mb-1">Username</span>
                <div class="input-group ps-5 pe-5">
                    <span class="input-group-text border" id="basic-addon1">@</span>
                    <h5 class="form-control form-control-lgx border"><?php echo $users['username']; ?></h5>
                </div>
                                        
                <div class="pt-3 d-flex flex-column justify-content-center ps-5 pe-5" id="">
                    <span class="fw-bold mb-1">Location / Office</span>
                    <h2 class="form-control form-control-lgx border"><?php echo $users['user_location']; ?></h2>
                </div>

                <div class="mt-4 pb-4 ps-5 pe-5 d-flex justify-content-around" id="">
                    <div class="ps-5 pe-5">
                        <a href="<?php if ($role === "user") { echo '../user/user-update-profile.php'; } else if ($role === "admin") { echo '../admin/admin-update-profile.php'; } ?>" class="ps-5 pe-5 btn btn-success">UPDATE</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>