<?php $role = $_SESSION['user']['role']; ?>
<div class="text-center text-dark mt-2 mb-2 d-flex justify-content-around align-items-center">
    <div class="d-flex align-items-center"><i class="fa-solid fa-circle-user text-dark"></i>&nbsp;<?php echo $_SESSION['user']['username']; ?></div>
    <div class="d-flex justify-content-around">
        <a  class="d-flex align-items-center text-dark text-decoration-none" href="<?php if ($role === "user") { echo '../user/user-profile.php'; } else if ($role === "admin") { echo '../admin/admin-profile.php'; } ?>">
            <i class="fa-solid fa-gear"></i>
        </a>
        <a  class="d-flex align-items-center text-dark m-2 text-decoration-none" href="<?php if ($role === "user") { echo '../user/user-notif.php'; } else if ($role === "admin") { echo '../admin/admin-notif.php'; } ?>">
            <i class="fa-solid fa-bell"></i>
            <section id="notif-counter" class="p-0 m-0"></section>
        </a>
    </div>
</div>