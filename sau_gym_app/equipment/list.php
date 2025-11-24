<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$sql = "SELECT * FROM equipment";
$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>Equipment List</h2>
    <a href="add.php" class="btn btn-primary mb-3">Add Equipment</a>

    <table class="table table-striped">
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Category</th>
            <th>Condition</th>
            <th>Purchase Date</th>
            <th>Next Maintenance</th>
            <th>Actions</th>
        </tr>

        <?php while($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['equipment_id'] ?></td>
            <td><?= $row['name'] ?></td>
            <td><?= $row['category'] ?></td>
            <td><?= ucfirst($row['equipment_condition']) ?></td>
            <td><?= $row['purchase_date'] ?></td>
            <td><?= $row['maintenance_date'] ?></td>

            <td>
                <a href="edit.php?id=<?= $row['equipment_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a onclick="return confirm('Delete this equipment?')" 
                   href="delete.php?id=<?= $row['equipment_id'] ?>" 
                   class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php } ?>

    </table>
</div>

<?php include "../includes/footer.php"; ?>
