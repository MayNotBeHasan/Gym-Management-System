<?php
include "../config/db.php";
include "../includes/header.php";
include "../includes/sidebar.php";

$query = "
    SELECT p.*, u.name AS member_name, m.plan_name
    FROM payments p
    LEFT JOIN users u ON p.member_id = u.user_id
    LEFT JOIN memberships mb ON p.membership_id = mb.membership_id
    LEFT JOIN membership_plans m ON mb.plan_id = m.plan_id
    ORDER BY p.payment_date DESC
";

$result = $conn->query($query);
?>

<div class="container mt-4">
    <h2>Payments</h2>

    <a href="add.php" class="btn btn-primary mb-3">Add Payment</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Member</th>
                <th>Plan</th>
                <th>Amount</th>
                <th>Method</th>
                <th>Status</th>
                <th>Date</th>
                <th>Transaction</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['member_name'] ?></td>
                <td><?= $row['plan_name'] ?></td>
                <td><?= $row['amount'] ?></td>
                <td><?= $row['payment_method'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['payment_date'] ?></td>
                <td><?= $row['transaction_id'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['payment_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['payment_id'] ?>" 
                       onclick="return confirm('Delete payment?')"
                       class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>

</div>

<?php include "../includes/footer.php"; ?>
