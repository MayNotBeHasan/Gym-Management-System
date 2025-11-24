<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$sql = "SELECT t.*, u.name, u.email, u.phone 
        FROM trainers t 
        JOIN users u ON t.user_id = u.user_id";

$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>Trainers</h2>
    <a href="add.php" class="btn btn-primary mb-3">Add New Trainer</a>

    <table class="table table-striped">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Specialization</th>
            <th>Experience</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['trainer_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['specialization'] ?></td>
            <td><?= $row['experience_years'] ?> years</td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td>
                <a href="edit.php?id=<?= $row['trainer_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a onclick="return confirm('Delete this trainer?')" 
                   href="delete.php?id=<?= $row['trainer_id'] ?>" 
                   class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php } ?>

    </table>
</div>

<?php include "../includes/footer.php"; ?>
