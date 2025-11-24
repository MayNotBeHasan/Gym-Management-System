<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['member']);

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <h2>Member Dashboard</h2>
    <p>Hello, <strong><?= $_SESSION['name']; ?></strong> (Member)</p>
    <hr>

    <div class="row">

        <!-- Workout Plan -->
        <div class="col-md-4">
            <div class="card p-4 bg-success text-white text-center">
                <h4>Workout Plans</h4>
                <a href="../workout_plans/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Diet Log -->
        <div class="col-md-4">
            <div class="card p-4 bg-danger text-white text-center">
                <h4>My Diet Log</h4>
                <a href="../diet/diet_log.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Attendance -->
        <div class="col-md-4">
            <div class="card p-4 bg-warning text-white text-center">
                <h4>My Attendance</h4>
                <a href="../attendance/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>
