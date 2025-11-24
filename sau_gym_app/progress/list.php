<?php
include "../config/db.php";
include "../includes/header.php";
include "../includes/sidebar.php";

$query = "
    SELECT p.*, u1.name AS member_name, u2.name AS trainer_name
    FROM progress_tracking p
    JOIN users u1 ON p.member_id = u1.user_id
    JOIN trainers t ON p.trainer_id = t.trainer_id
    JOIN users u2 ON t.user_id = u2.user_id
    ORDER BY p.date_recorded DESC
";

$result = $conn->query($query);
?>

<div class="container mt-4">
    <h2>Progress Tracking</h2>
    <a href="add.php" class="btn btn-primary mb-3">Add Progress Entry</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Member</th>
                <th>Trainer</th>
                <th>Weight</th>
                <th>Height</th>
                <th>Body Fat %</th>
                <th>Muscle Mass</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
        <?php while($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['member_name'] ?></td>
                <td><?= $row['trainer_name'] ?></td>
                <td><?= $row['weight'] ?> kg</td>
                <td><?= $row['height'] ?> cm</td>
                <td><?= $row['body_fat'] ?>%</td>
                <td><?= $row['muscle_mass'] ?> kg</td>
                <td><?= $row['date_recorded'] ?></td>
                <td>
                    <a href="edit.php?id=<?= $row['progress_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete.php?id=<?= $row['progress_id'] ?>" 
                       onclick="return confirm('Delete this entry?')"
                       class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

</div>

<?php include "../includes/footer.php"; ?>
