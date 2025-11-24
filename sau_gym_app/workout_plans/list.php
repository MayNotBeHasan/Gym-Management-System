<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// =============================
// MEMBER → sees only their plans
// =============================
if ($role == 'member') {

    $sql = "
        SELECT wp.*, u.name AS trainer_name
        FROM workout_plans wp
        JOIN users u ON wp.trainer_id = u.user_id
        WHERE wp.member_id = $user_id
        ORDER BY wp.start_date DESC
    ";
}

// =============================
// TRAINER → sees only assigned members
// =============================
elseif ($role == 'trainer') {

    // 1. Find trainer_id from trainers table
    $tid_query = mysqli_query($conn, "
        SELECT trainer_id FROM trainers WHERE user_id = $user_id
    ");
    $tid_data = mysqli_fetch_assoc($tid_query);
    $trainer_id = $tid_data['trainer_id'];

    // 2. Show workout plans where this trainer is assigned
    $sql = "
        SELECT wp.*, m.name AS member_name
        FROM workout_plans wp
        JOIN users m ON wp.member_id = m.user_id
        WHERE wp.trainer_id = $trainer_id
        ORDER BY wp.start_date DESC
    ";
}

// =============================
// ADMIN → sees all plans
// =============================
else {
    allow_role(['admin']);

    $sql = "
        SELECT wp.*, 
               m.name AS member_name, 
               t.name AS trainer_name
        FROM workout_plans wp
        JOIN users m ON wp.member_id = m.user_id
        JOIN users t ON wp.trainer_id = t.user_id
        ORDER BY wp.start_date DESC
    ";
}

$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>Workout Plans</h2>

    <?php if ($role == 'admin' || $role == 'trainer') { ?>
        <a href="add.php" class="btn btn-primary mb-3">Create Workout Plan</a>
    <?php } ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Member</th>
                <th>Trainer</th>
                <th>Plan Name</th>
                <th>Duration</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['member_name'] ?? 'You' ?></td>
                <td><?= $row['trainer_name'] ?? 'Your Trainer' ?></td>

                <td><?= $row['plan_name'] ?></td>

                <td>
                    <?= $row['start_date'] ?> → 
                    <?= $row['end_date'] ?: 'Ongoing' ?>
                </td>

                <td><?= ucfirst($row['status']) ?></td>

                <td>
                    <a href="edit.php?id=<?= $row['workout_id'] ?>" class="btn btn-warning btn-sm">
                        View / Edit
                    </a>

                    <?php if ($role == 'admin' || $role == 'trainer') { ?>
                        <a onclick="return confirm('Delete this plan?')"
                           href="delete.php?id=<?= $row['workout_id'] ?>"
                           class="btn btn-danger btn-sm">
                            Delete
                        </a>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php include "../includes/footer.php"; ?>
