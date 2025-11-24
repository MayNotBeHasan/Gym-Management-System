<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$id = $_GET['id'];

// Fetch the plan
$plan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM workout_plans WHERE workout_id = $id"));

// Load members
$members = mysqli_query($conn, "SELECT user_id, name FROM users WHERE role='member'");

// Load correct trainer IDs
$trainers = mysqli_query($conn, "
    SELECT trainers.trainer_id, users.name
    FROM trainers
    JOIN users ON trainers.user_id = users.user_id
");

$ex = json_decode($plan['exercises'], true);

if (isset($_POST['update'])) {

    $member = $_POST['member_id'];
    $trainer = $_POST['trainer_id'];
    $plan_name = $_POST['plan_name'];
    $description = $_POST['description'];
    $exercise_text = $_POST['exercises'];
    $exercises = json_encode(explode(",", $exercise_text));
    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $status = $_POST['status'];

    // SAFE UPDATE
    $stmt = $conn->prepare("
        UPDATE workout_plans SET
        member_id = ?, 
        trainer_id = ?, 
        plan_name = ?, 
        description = ?, 
        exercises = ?, 
        start_date = ?, 
        end_date = ?, 
        status = ?
        WHERE workout_id = ?
    ");

    $stmt->bind_param("iissssssi", 
        $member,
        $trainer,
        $plan_name,
        $description,
        $exercises,
        $start,
        $end,
        $status,
        $id
    );

    $stmt->execute();

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Edit Workout Plan</h2>

    <form method="POST">

        <label>Member</label>
        <select name="member_id" class="form-control">
            <?php while($m = mysqli_fetch_assoc($members)) { ?>
                <option value="<?= $m['user_id'] ?>" <?= $m['user_id']==$plan['member_id']?'selected':'' ?>>
                    <?= $m['name'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Trainer</label>
        <select name="trainer_id" class="form-control">
            <?php while($t = mysqli_fetch_assoc($trainers)) { ?>
                <option value="<?= $t['trainer_id'] ?>" <?= $t['trainer_id']==$plan['trainer_id']?'selected':'' ?>>
                    <?= $t['name'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Plan Name</label>
        <input type="text" name="plan_name" class="form-control" value="<?= $plan['plan_name'] ?>"><br>

        <label>Description</label>
        <textarea name="description" class="form-control"><?= $plan['description'] ?></textarea><br>

        <label>Exercises</label>
        <input type="text" name="exercises" class="form-control"
               value="<?= implode(',', $ex ?? []) ?>"><br>

        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control" value="<?= $plan['start_date'] ?>"><br>

        <label>End Date</label>
        <input type="date" name="end_date" class="form-control" value="<?= $plan['end_date'] ?>"><br>

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" <?= $plan['status']=='active'?'selected':'' ?>>Active</option>
            <option value="paused" <?= $plan['status']=='paused'?'selected':'' ?>>Paused</option>
            <option value="completed" <?= $plan['status']=='completed'?'selected':'' ?>>Completed</option>
        </select><br>

        <button class="btn btn-primary" name="update">Update Plan</button>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
