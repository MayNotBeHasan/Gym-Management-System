<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

// load attendance with member names
$sql = "SELECT a.*, u.name 
        FROM attendance a
        JOIN users u ON a.member_id = u.user_id
        ORDER BY check_in_time DESC";

$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>Attendance Records</h2>
    <a href="add.php" class="btn btn-primary mb-3">Add Check-in</a>

    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>Member</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Notes</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['attendance_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['check_in_time'] ?></td>
            <td><?= $row['check_out_time'] ?: "<span class='text-danger'>Not checked out</span>" ?></td>
            <td><?= $row['notes'] ?></td>

            <td>
                <!-- checkout only if no checkout time -->
                <?php if($row['check_out_time'] == null) { ?>
                    <a href="checkout.php?id=<?= $row['attendance_id'] ?>" class="btn btn-success btn-sm">Checkout</a>
                <?php } ?>

                <a onclick="return confirm('Delete this record?')"
                   href="delete.php?id=<?= $row['attendance_id'] ?>"
                   class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php } ?>

    </table>
</div>

<?php include "../includes/footer.php"; ?>
