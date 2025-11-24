<?php
include "../config/db.php";

$id = $_GET["id"];
$record = $conn->query("SELECT * FROM progress_tracking WHERE progress_id=$id")->fetch_assoc();

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
        UPDATE progress_tracking SET 
        member_id=?, trainer_id=?, weight=?, height=?, body_fat=?, muscle_mass=?, notes=?, date_recorded=?
        WHERE progress_id=?
    ");

    $stmt->bind_param("iidddsssi",
        $member, $trainer, $weight, $height, $bodyfat, $muscle, $notes, $date, $id);
    $stmt->execute();

    header("Location: list.php");
    exit;
}

include "../includes/header.php";
include "../includes/sidebar.php";
?>

<div class="container mt-4">
    <h2>Edit Progress Record</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Member</label>
            <select name="member_id" class="form-control">
                <?php while($m = $members->fetch_assoc()) { ?>
                <option value="<?= $m['user_id'] ?>" 
                    <?= $m['user_id']==$record['member_id']?'selected':'' ?>>
                    <?= $m['name'] ?>
                </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Trainer</label>
            <select name="trainer_id" class="form-control">
                <?php while($t = $trainers->fetch_assoc()) { ?>
                <option value="<?= $t['trainer_id'] ?>"
                    <?= $t['trainer_id']==$record['trainer_id']?'selected':'' ?>>
                    <?= $t['name'] ?>
                </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Weight (kg)</label>
            <input type="number" step="0.1" name="weight" value="<?= $record['weight'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Height (cm)</label>
            <input type="number" step="0.1" name="height" value="<?= $record['height'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Body Fat (%)</label>
            <input type="number" step="0.1" name="body_fat" value="<?= $record['body_fat'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Muscle Mass (kg)</label>
            <input type="number" step="0.1" name="muscle_mass" value="<?= $record['muscle_mass'] ?>" class="form-control">
        </div>

        <div class="mb-3">
            <label>Notes</label>
            <textarea name="notes" class="form-control"><?= $record['notes'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Date Recorded</label>
            <input type="date" name="date_recorded" value="<?= $record['date_recorded'] ?>" class="form-control">
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
