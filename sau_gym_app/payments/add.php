<?php
include "../config/db.php";

$members = $conn->query("SELECT user_id, name FROM users WHERE role='member'");
$memberships = $conn->query("
    SELECT m.membership_id, u.name AS member_name, p.plan_name 
    FROM memberships m
    JOIN users u ON m.member_id = u.user_id
    JOIN membership_plans p ON m.plan_id = p.plan_id
");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $member = $_POST["member_id"];
    $membership = $_POST["membership_id"];
    $amount = $_POST["amount"];
    $method = $_POST["payment_method"];
    $status = $_POST["status"];
    $date = $_POST["payment_date"];
    $transaction = $_POST["transaction_id"];

    $stmt = $conn->prepare("
        INSERT INTO payments 
        (member_id, membership_id, amount, payment_method, status, payment_date, transaction_id)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("iidssss", 
        $member, $membership, $amount, $method, $status, $date, $transaction);

    $stmt->execute();

    header("Location: list.php");
    exit;
}

include "../includes/header.php";
include "../includes/sidebar.php";
?>

<div class="container mt-4">
    <h2>Add Payment</h2>

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
            <label>Membership</label>
            <select name="membership_id" class="form-control">
                <?php while($m = $memberships->fetch_assoc()) { ?>
                    <option value="<?= $m['membership_id'] ?>">
                        <?= $m['member_name'] ?> (<?= $m['plan_name'] ?>)
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Payment Method</label>
            <select name="payment_method" class="form-control">
                <option value="cash">Cash</option>
                <option value="card">Card</option>
                <option value="online">Online</option>
                <option value="bank_transfer">Bank Transfer</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="paid">Paid</option>
                <option value="pending">Pending</option>
                <option value="failed">Failed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="payment_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Transaction ID</label>
            <input type="text" name="transaction_id" class="form-control">
        </div>

        <button class="btn btn-success">Save</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>

    </form>

</div>

<?php include "../includes/footer.php"; ?>
