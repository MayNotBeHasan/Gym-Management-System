<?php
// Check if logged in
include "../auth/check_login.php";

// Load header and navbar
include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <h2>Welcome to SAU Gym & Wellness Dashboard</h2>
    <p>Hello, <strong><?php echo $_SESSION['name']; ?></strong> (<?php echo $_SESSION['role']; ?>)</p>
    <hr>

    <div class="row">

        <!-- Members -->
        <div class="col-md-3">
            <div class="card p-4 bg-info text-white text-center">
                <h4>Members</h4>
                <a href="../members/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Diet Logs -->
        <div class="col-md-3">
            <div class="card p-4 bg-warning text-white text-center">
                <h4>Diet Logs</h4>
                <a href="../diet/meals.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Workout Plans -->
        <div class="col-md-3">
            <div class="card p-4 bg-success text-white text-center">
                <h4>Workout Plans</h4>
                <a href="../workout_plans/list.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Reports -->
        <div class="col-md-3">
            <div class="card p-4 bg-primary text-white text-center">
                <h4>Reports</h4>
                <a href="../reports/index.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>
