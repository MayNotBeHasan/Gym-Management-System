<?php
// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$role = $_SESSION['role'] ?? '';
$name = $_SESSION['name'] ?? 'User';

// --------------------------
// DYNAMIC DASHBOARD REDIRECT
// --------------------------
$brandLink = "../dashboard/index.php";

if ($role === 'admin') {
    $brandLink = "../dashboard/admin_dashboard.php";
}
elseif ($role === 'trainer') {
    $brandLink = "../dashboard/trainer_dashboard.php";
}
elseif ($role === 'member') {
    $brandLink = "../dashboard/member_dashboard.php";
}
elseif ($role === 'cafeteria') {
    $brandLink = "../dashboard/cafe_dashboard.php";
}
?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">

    <!-- Dynamic Brand Link -->
    <a class="navbar-brand" href="<?= $brandLink ?>">SAU Gym</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">

      <ul class="navbar-nav me-auto">

        <!-- ===================== ADMIN MENU ===================== -->
        <?php if ($role === 'admin') { ?>
          <li class="nav-item"><a class="nav-link" href="../members/list.php">Members</a></li>
          <li class="nav-item"><a class="nav-link" href="../trainers/list.php">Trainers</a></li>
          <li class="nav-item"><a class="nav-link" href="../plans/list.php">Plans</a></li>
          <li class="nav-item"><a class="nav-link" href="../equipment/list.php">Equipment</a></li>
          <li class="nav-item"><a class="nav-link" href="../attendance/list.php">Attendance</a></li>
          <li class="nav-item"><a class="nav-link" href="../diet/meals.php">Diet</a></li>
          <li class="nav-item"><a class="nav-link" href="../reports/index.php">Reports</a></li>
        <?php } ?>

        <!-- ===================== TRAINER MENU ===================== -->
        <?php if ($role === 'trainer') { ?>
          <li class="nav-item"><a class="nav-link" href="../members/assigned.php">Assigned Members</a></li>
          <li class="nav-item"><a class="nav-link" href="../workout_plans/list.php">Workout Plans</a></li>
          <li class="nav-item"><a class="nav-link" href="../attendance/list.php">Attendance</a></li>
          <li class="nav-item"><a class="nav-link" href="../reports/trainer_workload.php">Workload</a></li>
        <?php } ?>

        <!-- ===================== MEMBER MENU ===================== -->
        <?php if ($role === 'member') { ?>
          <li class="nav-item"><a class="nav-link" href="../workout_plans/list.php">Workout Plans</a></li>
          <li class="nav-item"><a class="nav-link" href="../diet/diet_log.php">My Diet Log</a></li>
        <?php } ?>

        <!-- ===================== CAFETERIA MENU ===================== -->
        <?php if ($role === 'cafeteria') { ?>
          <li class="nav-item"><a class="nav-link" href="../diet/meals.php">Meals</a></li>
          <li class="nav-item"><a class="nav-link" href="../diet/log_meal.php">Log Meal</a></li>
        <?php } ?>

      </ul>

      <!-- Username + Logout -->
      <span class="navbar-text text-white me-3">
         <?= htmlspecialchars($name) ?> (<?= htmlspecialchars($role) ?>)
      </span>

      <a href="../auth/logout.php" class="btn btn-danger">Logout</a>

    </div>
  </div>
</nav>
