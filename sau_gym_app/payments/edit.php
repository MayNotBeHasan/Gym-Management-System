<?php
include "../config/db.php";

$id = $_GET["id"];
$payment = $conn->query("SELECT * FROM payments WHERE payment_id=$id")->fetch_assoc();

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
        UPDATE payments SET 
            member_id=?, 
            membership_id=?, 
            amount=?, 
            payment_method=?, 
            status=?, 
            payment_date=?, 
            transaction_id=?
        WHERE payment_id=?
    ");

    $stmt->bind_param("iidssssi",
        $member, $membership, $amount, $method, $status, $date, $transaction, $id);

    $stmt->execute();

    header("Location: list.php");
    exit;
}

include "../includes/header.php";
include "../includes/sidebar.php";
?>

<div class="container mt-4">
    <h2>Edit Payment</h2>

    <form method="POST">

        <div class="mb-3">
            <label>Member</label>
            <select name="member_id" class="form-control">
                <?php while($m = $members->fetch_assoc()) { ?>
                <option value="<?= $m['user_id'] ?>"
                    <?= $m['user_id']==$payment['member_id']?'selected':'' ?>>
                    <?= $m['name'] ?>
                </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Membership</label>
            <select name="membership_id" class="form-control">
                <?php while($m = $memberships->fetch_assoc()) { ?>
                    <option value="<?= $m['membership_id'] ?>"
                    <?= $m['membership_id']==$payment['membership_id']?'selected':'' ?>>
                    <?= $m['member_name'] ?> (<?= $m['plan_name'] ?>)
                </option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Amount</label>
            <input type="number" name="amount" step="0.01" 
                value="<?= $payment['amount'] ?>" 
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Payment Method</label>
            <select name="payment_method" class="form-control">
                <option value="cash" <?= $payment['payment_method']=='cash'?'selected':'' ?>>Cash</option>
                <option value="card" <?= $payment['payment_method']=='card'?'selected':'' ?>>Card</option>
                <option value="online" <?= $payment['payment_method']=='online'?'selected':'' ?>>Online</option>
                <option value="bank_transfer" <?= $payment['payment_method']=='bank_transfer'?'selected':'' ?>>Bank Transfer</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="paid" <?= $payment['status']=='paid'?'selected':'' ?>>Paid</option>
                <option value="pending" <?= $payment['status']=='pending'?'selected':'' ?>>Pending</option>
                <option value="failed" <?= $payment['status']=='failed'?'selected':'' ?>>Failed</option>
            </select>
        </div>

        <div class="mb-3">
            <label>Payment Date</label>
            <input type="date" name="payment_date" 
                value="<?= $payment['payment_date'] ?>" 
                class="form-control">
        </div>

        <div class="mb-3">
            <label>Transaction ID</label>
            <input type="text" name="transaction_id" 
                value="<?= $payment['transaction_id'] ?>" 
                class="form-control">
        </div>

        <button class="btn btn-warning">Update</button>
        <a href="list.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
