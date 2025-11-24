<?php
include "../config/db.php";

$members = $conn->query("SELECT user_id, name FROM users WHERE role='member'");
$trainers = $conn->query("
    SELECT t.trainer_id, u.name 
    FROM trainers t 
    JOIN users u ON t.user_id = u.user_id
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member = $_POST["member_id"];
    $trainer = $_POST["trainer_id"];
    $weight = $_POST["weight"];
    $height = $_POST["height"];
    $bodyfat = $_POST["body_fat"];
    $muscle = $_POST["muscle_mass"];
    $notes = $_POST["notes"];
    $date = $_POST["date_recorded"];

    $stmt = $conn->prepare("
        INSERT INTO progress_tracking 
        (member_id, trainer_id, weight, height, body_fat, muscle_mass, notes, date_recorded)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("iidddsss", 
        $member, $trainer, $weight, $height, $bodyfat, $muscle, $notes, $date);
    $stmt->execute();

    header("Location: list.php");
    exit;
}

include "../includes/header.php";
include "../includes/sidebar.php";
?>

<div class="container mt-4">
    <h2>Add Progress Record</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Member</label>
            <select name="member_id" class="form-control">
                <?php while($m = $members->fetch_assoc()) { ?>
                <option value="<?= $m['user_id'] ?>"><?= $m['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Trainer</label>
            <select name="trainer_id" class="form-control">
                <?php while($t = $trainers->fetch_assoc()) { ?>
                <option value="<?= $t['trainer_id'] ?>"><?= $t['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Weight (kg)</label>
            <input type="number" step="0.1" name="weight" class="form-control">
        </div>

        <div class="mb-3">
            <label>Height (cm)</label>
            <input type="number" step="0.1" name="height" class="form-control">
        </div>

        <div class="mb-3">
            <label>Body Fat (%)</label>
            <input type="number" step="0.1" name="body_fat" class="form-control">
        </div>

        <div class="mb-3">
            <label>Muscle Mass (kg)</label>
            <input type="number" step="0.1" name="muscle_mass" class="form-control">
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Date Recorded</label>
            <input type="date" name="date_recorded" class="form-control" required>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
