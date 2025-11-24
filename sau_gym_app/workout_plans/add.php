<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

// FIX: Load real trainer IDs (trainer_id NOT user_id)
$trainers = mysqli_query($conn, "
    SELECT trainers.trainer_id, users.name
    FROM trainers
    JOIN users ON trainers.user_id = users.user_id
");

// Members stay same
$members = mysqli_query($conn, "SELECT user_id, name FROM users WHERE role='member'");

if (isset($_POST['save'])) {

    $member = $_POST['member_id'];
    $trainer = $_POST['trainer_id'];  // Now correct trainer_id
    $plan_name = $_POST['plan_name'];
    $description = $_POST['description'];

    $exercise_text = $_POST['exercises'];
    $exercises = json_encode(explode(",", $exercise_text));

    $start = $_POST['start_date'];
    $end = $_POST['end_date'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("
        INSERT INTO workout_plans 
        (member_id, trainer_id, plan_name, description, exercises, start_date, end_date, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("iissssss",
        $member,
        $trainer,
        $plan_name,
        $description,
        $exercises,
        $start,
        $end,
        $status
    );

    $stmt->execute();

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Create Workout Plan</h2>

    <form method="POST">

        <label>Member</label>
        <select name="member_id" class="form-control" required>
            <?php while ($m = mysqli_fetch_assoc($members)) { ?>
                <option value="<?= $m['user_id'] ?>"><?= $m['name'] ?></option>
            <?php } ?>
        </select><br>

        <label>Trainer</label>
        <select name="trainer_id" class="form-control" required>
            <?php while ($t = mysqli_fetch_assoc($trainers)) { ?>
                <option value="<?= $t['trainer_id'] ?>"><?= $t['name'] ?></option>
            <?php } ?>
        </select><br>

        <label>Plan Name</label>
        <input type="text" name="plan_name" class="form-control" required><br>

        <label>Description</label>
        <textarea name="description" class="form-control"></textarea><br>

        <label>Exercises (comma separated)</label>
        <input type="text" name="exercises" class="form-control" placeholder="Bench Press, Squats"><br>

        <label>Start Date</label>
        <input type="date" name="start_date" class="form-control" required><br>

        <label>End Date</label>
        <input type="date" name="end_date" class="form-control"><br>

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="paused">Paused</option>
            <option value="completed">Completed</option>
        </select><br>

        <button class="btn btn-success" name="save">Save Plan</button>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
