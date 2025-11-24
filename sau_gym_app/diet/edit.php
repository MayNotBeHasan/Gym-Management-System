<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'cafeteria']);

include "../config/db.php";

$id = $_GET["id"];
$log = $conn->query("SELECT * FROM diet_log WHERE log_id=$id")->fetch_assoc();

$members = $conn->query("SELECT user_id, name FROM users WHERE role='member'");
$meals = $conn->query("SELECT * FROM meal");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $member = $_POST["member_id"];
    $meal = $_POST["meal_id"];
    $qty = $_POST["quantity"];
    $date = $_POST["date_taken"];

    $stmt = $conn->prepare("UPDATE diet_log SET member_id=?, meal_id=?, quantity=?, date_taken=? WHERE log_id=?");
    $stmt->bind_param("iiisi", $member, $meal, $qty, $date, $id);
    $stmt->execute();

    header("Location: list.php");
    exit;
}

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">
    <h2>Edit Diet Log</h2>

    <form method="POST">
        <label>Member</label>
        <select name="member_id" class="form-control">
            <?php while($m = $members->fetch_assoc()) { ?>
                <option value="<?= $m['user_id'] ?>" <?= $m['user_id']==$log['member_id']?'selected':'' ?>>
                    <?= $m['name'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Meal</label>
        <select name="meal_id" class="form-control">
            <?php while($m = $meals->fetch_assoc()) { ?>
                <option value="<?= $m['meal_id'] ?>" <?= $m['meal_id']==$log['meal_id']?'selected':'' ?>>
                    <?= $m['food_name'] ?>
                </option>
            <?php } ?>
        </select><br>

        <label>Quantity</label>
        <input type="number" name="quantity" value="<?= $log['quantity'] ?>" class="form-control"><br>

        <label>Date</label>
        <input type="date" name="date_taken" value="<?= $log['date_taken'] ?>" class="form-control"><br>

        <button class="btn btn-primary">Update</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
