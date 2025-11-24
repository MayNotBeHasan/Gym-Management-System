<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <h2>Admin Dashboard</h2>
    <p>Hello, <strong><?= $_SESSION['name']; ?></strong> (Admin)</p>
    <hr>

    <div class="row">

        <!-- Members -->
        <div class="col-md-3">
            <div class="card p-4 bg-info text-white text-center shadow-sm">
                <h4>Members</h4>
                <a href="../members/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Trainers -->
        <div class="col-md-3">
            <div class="card p-4 bg-secondary text-white text-center shadow-sm">
                <h4>Trainers</h4>
                <a href="../trainers/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Plans -->
        <div class="col-md-3">
            <div class="card p-4 bg-warning text-white text-center shadow-sm">
                <h4>Plans</h4>
                <a href="../plans/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Equipment -->
        <div class="col-md-3">
            <div class="card p-4 bg-dark text-white text-center shadow-sm">
                <h4>Equipment</h4>
                <a href="../equipment/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Attendance -->
        <div class="col-md-3 mt-3">
            <div class="card p-4 bg-success text-white text-center shadow-sm">
                <h4>Attendance</h4>
                <a href="../attendance/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Diet -->
        <div class="col-md-3 mt-3">
            <div class="card p-4 bg-danger text-white text-center shadow-sm">
                <h4>Diet Logs</h4>
                <a href="../diet/meals.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Assign Trainer (NEW) -->
        <div class="col-md-3 mt-3">
            <div class="card p-4 bg-info text-white text-center shadow-sm">
                <h4>Assign Trainer</h4>
                <a href="../members/assign_trainer.php" class="btn btn-light mt-2">Assign</a>
            </div>
        </div>

        <!-- Reports -->
        <div class="col-md-3 mt-3">
            <div class="card p-4 bg-primary text-white text-center shadow-sm">
                <h4>Reports</h4>
                <a href="../reports/index.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>
