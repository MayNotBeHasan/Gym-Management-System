<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['trainer']);

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <h2>Trainer Dashboard</h2>
    <p>Hello, <strong><?= $_SESSION['name']; ?></strong></p>
    <hr>

    <div class="row">
        
        <div class="col-md-4">
            <div class="card p-4 bg-info text-white text-center">
                <h4>Assigned Members</h4>
                <a href="../members/assigned.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 bg-success text-white text-center">
                <h4>Workout Plans</h4>
                <a href="../workout_plans/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-4 bg-warning text-white text-center">
                <h4>Attendance</h4>
                <a href="../attendance/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>
