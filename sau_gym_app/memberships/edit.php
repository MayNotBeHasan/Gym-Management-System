<?php
include "../config/db.php";

$id = $_GET["id"];

// Fetch current membership info
$membership = $conn->query("
    SELECT * FROM memberships WHERE membership_id = $id
")->fetch_assoc();

// Fetch members
$members = $conn->query("SELECT user_id, name FROM users WHERE role='member'");

// Fetch plans
$plans = $conn->query("SELECT * FROM membership_plans");

// Fetch trainers
$trainers = $conn->query("
    SELECT t.trainer_id, u.name 
    FROM trainers t 
    JOIN users u ON t.user_id = u.user_id
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $member = $_POST["member_id"];
    $plan = $_POST["plan_id"];
    $trainer = $_POST["trainer_id"] ?: NULL;  // allow NULL
    $start = $_POST["start_date"];
    $end = $_POST["end_date"];
    $price = $_POST["price"];
    $status = $_POST["status"];

    $stmt = $conn->prepare("
        UPDATE memberships SET 
        member_id=?, 
        plan_id=?, 
        trainer_id=?, 
        start_date=?, 
        end_date=?, 
        price=?, 
        status=?
        WHERE membership_id=?
    ");

    $stmt->bind_param(
        "iiissdsi",
        $member, 
        $plan, 
        $trainer, 
        $start, 
        $end, 
        $price, 
        $status,
        $id
    );

    $stmt->execute();

    header("Location: list.php");
    exit;
}

include "../includes/header.php";
include "../includes/sidebar.php";
?>

<div class="container mt-4">
    <h2>Edit Membership</h2>

    <form method="POST">

        <!-- Member -->
        <div class="mb-3">
            <label>Member</label>
            <select name="member_id" class="form-control">
                <?php while($m = $members->fetch_assoc()) { ?>
                <option value="<?= $m['user_id'] ?>"
                    <?= $m['user_id'] == $membership['member_id'] ? 'selected' : '' ?>>
                    <?= $m['name'] ?>
                </option>
                <?php } ?>
            </select>
        </div>

        <!-- Plan -->
        <div class="mb-3">
            <label>Membership Plan</label>
            <select name="plan_id" class="form-control">
                <?php while($p = $plans->fetch_assoc()) { ?>
                <option value="<?= $p['plan_id'] ?>"
                    <?= $p['plan_id'] == $membership['plan_id'] ? 'selected' : '' ?>>
                    <?= $p['plan_name'] ?>
                </option>
                <?php } ?>
            </select>
        </div>

        <!-- Trainer -->
        <div class="mb-3">
            <label>Trainer (Optional)</label>
            <select name="trainer_id" class="form-control">
                <option value="">None</option>
                <?php while($t = $trainers->fetch_assoc()) { ?>
                <option value="<?= $t['trainer_id'] ?>"
                    <?= $t['trainer_id'] == $membership['trainer_id'] ? 'selected' : '' ?>>
                    <?= $t['name'] ?>
                </option>
                <?php } ?>
            </select>
        </div>

        <!-- Start Date -->
        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control"
                value="<?= $membership['start_date'] ?>">
        </div>

        <!-- End Date -->
        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control"
                value="<?= $membership['end_date'] ?>">
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" class="form-control"
                value="<?= $membership['price'] ?>">
        </div>

        <!-- Status -->
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="active" <?= $membership['status']=='active'?'selected':'' ?>>Active</option>
                <option value="expired" <?= $membership['status']=='expired'?'selected':'' ?>>Expired</option>
                <option value="cancelled" <?= $membership['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>

    </form>

</div>

<?php include "../includes/footer.php"; ?>
