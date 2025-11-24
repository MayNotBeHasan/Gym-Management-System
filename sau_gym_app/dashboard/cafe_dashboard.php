<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['cafeteria']);

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <h2>Cafeteria Dashboard</h2>
    <p>Hello, <strong><?= $_SESSION['name']; ?></strong> (Cafeteria Staff)</p>
    <hr>

    <div class="row">

        <!-- Meals -->
        <div class="col-md-4">
            <div class="card p-4 bg-info text-white text-center">
                <h4>Meals</h4>
                <a href="../diet/meals.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Log Meal -->
        <div class="col-md-4">
            <div class="card p-4 bg-success text-white text-center">
                <h4>Log Meal</h4>
                <a href="../diet/log_meal.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

        <!-- Diet Summary -->
        <div class="col-md-4">
            <div class="card p-4 bg-warning text-white text-center">
                <h4>Diet Summary</h4>
                <a href="../reports/diet_summary.php" class="btn btn-light mt-2">Open</a>
            </div>
        </div>

    </div>
</div>

<?php include "../includes/footer.php"; ?>
