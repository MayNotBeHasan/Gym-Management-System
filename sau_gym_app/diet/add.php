<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'cafeteria']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$members = $conn->query("SELECT user_id, name FROM users WHERE role='member'");
$meals = $conn->query("SELECT * FROM meal");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $member = $_POST["member_id"];
    $meal = $_POST["meal_id"];
    $qty = $_POST["quantity"];
    $date = $_POST["date_taken"];

    $stmt = $conn->prepare("INSERT INTO diet_log (member_id, meal_id, quantity, date_taken)
                            VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iiis", $member, $meal, $qty, $date);
    $stmt->execute();

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Add Diet Log</h2>

    <form method="POST">
        <label>Member</label>
        <select name="member_id" class="form-control" required>
            <?php while($m = $members->fetch_assoc()) { ?>
                <option value="<?= $m['user_id'] ?>"><?= $m['name'] ?></option>
            <?php } ?>
        </select><br>

        <label>Meal</label>
        <select name="meal_id" class="form-control" required>
            <?php while($m = $meals->fetch_assoc()) { ?>
                <option value="<?= $m['meal_id'] ?>"><?= $m['food_name'] ?></option>
            <?php } ?>
        </select><br>

        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" required><br>

        <label>Date</label>
        <input type="date" name="date_taken" class="form-control" required><br>

        <button class="btn btn-success">Save</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
