<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <h2>Reports Dashboard</h2>
    <hr>

    <div class="row">

        <div class="col-md-4 mb-3">
            <a href="membership_stats.php" class="btn btn-primary w-100 p-3">Membership Statistics</a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="attendance_summary.php" class="btn btn-danger w-100 p-3">Attendance Summary</a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="diet_summary.php" class="btn btn-info w-100 p-3">Diet Summary</a>
        </div>

        <div class="col-md-4 mb-3">
            <a href="trainer_workload.php" class="btn btn-secondary w-100 p-3">Trainer Workload</a>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>
