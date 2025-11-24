<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$sql = "SELECT * FROM users WHERE role='member'";
$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>Members</h2>
    <a href="add.php" class="btn btn-primary mb-3">Add New Member</a>

    <table class="table table-striped">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['user_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['status'] ?></td>

            <td>
                <a href="edit.php?id=<?= $row['user_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a onclick="return confirm('Delete this member?')" 
                   href="delete.php?id=<?= $row['user_id'] ?>" 
                   class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php include "../includes/footer.php"; ?>
