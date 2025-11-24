<?php
include "../config/db.php";

$members = $conn->query("SELECT user_id, name FROM users WHERE role='member'");
$plans = $conn->query("SELECT * FROM membership_plans");
$trainers = $conn->query("
    SELECT t.trainer_id, u.name 
    FROM trainers t 
    JOIN users u ON t.user_id = u.user_id
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member = $_POST["member_id"];
    $plan = $_POST["plan_id"];
    $trainer = $_POST["trainer_id"];
    $start = $_POST["start_date"];
    $end = $_POST["end_date"];
    $price = $_POST["price"];
    $status = $_POST["status"];

    $stmt = $conn->prepare("
        INSERT INTO memberships 
        (member_id, plan_id, trainer_id, start_date, end_date, price, status)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("iiissds", 
        $member, $plan, $trainer, $start, $end, $price, $status);
    $stmt->execute();

    header("Location: list.php");
    exit;
}

include "../includes/header.php";
include "../includes/sidebar.php";
?>

<div class="container mt-4">
    <h2>Add Membership</h2>

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
            <label>Plan</label>
            <select name="plan_id" class="form-control">
                <?php while($p = $plans->fetch_assoc()) { ?>
                    <option value="<?= $p['plan_id'] ?>"><?= $p['plan_name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Trainer (Optional)</label>
            <select name="trainer_id" class="form-control">
                <option value="">None</option>
                <?php while($t = $trainers->fetch_assoc()) { ?>
                    <option value="<?= $t['trainer_id'] ?>"><?= $t['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" class="form-control" step="0.01">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="expired">Expired</option>
                <option value="cancelled">Cancelled</option>
            </select>
        </div>

        <button class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
