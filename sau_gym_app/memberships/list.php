<?php
include "../config/db.php";
include "../includes/header.php";
include "../includes/sidebar.php";

$query = "
    SELECT m.*, u.name AS member_name, p.plan_name, t.trainer_id, u2.name AS trainer_name
    FROM memberships m
    JOIN users u ON m.member_id = u.user_id
    JOIN membership_plans p ON m.plan_id = p.plan_id
    LEFT JOIN trainers t ON m.trainer_id = t.trainer_id
    LEFT JOIN users u2 ON t.user_id = u2.user_id
    ORDER BY m.membership_id DESC
";

$result = $conn->query($query);
?>

<div class="container mt-4">
    <h2>Memberships</h2>

    <a href="add.php" class="btn btn-primary mb-3">Add Membership</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Member</th>
                <th>Plan</th>
                <th>Trainer</th>
                <th>Start</th>
                <th>End</th>
                <th>Status</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['member_name'] ?></td>
                <td><?= $row['plan_name'] ?></td>
                <td><?= $row['trainer_name'] ?? 'None' ?></td>
                <td><?= $row['start_date'] ?></td>
                <td><?= $row['end_date'] ?></td>
                <td><?= $row['status'] ?></td>
                <td><?= $row['price'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['membership_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['membership_id'] ?>" 
                       onclick="return confirm('Delete membership?')"
                       class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>

    </table>
</div>

<?php include "../includes/footer.php"; ?>
