<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

// ROLE RESTRICTIONS
$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

if ($role === 'member') {
    // member sees ONLY own logs
    $query = "
        SELECT dl.*, m.food_name, u.name AS member_name
        FROM diet_log dl
        JOIN meal m ON dl.meal_id = m.meal_id
        JOIN users u ON dl.member_id = u.user_id
        WHERE dl.member_id = $user_id
        ORDER BY dl.date_taken DESC
    ";
} else {
    // admin, cafeteria, trainer see all
    $query = "
        SELECT dl.*, m.food_name, u.name AS member_name, m.calories, m.protein, m.carbs, m.fats
        FROM diet_log dl
        JOIN meal m ON dl.meal_id = m.meal_id
        JOIN users u ON dl.member_id = u.user_id
        ORDER BY dl.date_taken DESC, dl.log_id DESC
    ";
}

$result = $conn->query($query);
?>

<div class="container mt-4">
    <h2>Diet Logs</h2>

    <?php if ($role == 'admin' || $role == 'cafeteria') { ?>
        <a href="add.php" class="btn btn-primary mb-3">Add Diet Entry</a>
    <?php } ?>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Member</th>
                <th>Meal</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Calories</th>
                <th>Protein</th>
                <th>Carbs</th>
                <th>Fats</th>
                <?php if ($role == 'admin' || $role == 'cafeteria') { ?>
                <th>Actions</th>
                <?php } ?>
            </tr>
        </thead>

        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['member_name'] ?></td>
                <td><?= $row['food_name'] ?></td>
                <td><?= $row['quantity'] ?></td>
                <td><?= $row['date_taken'] ?></td>
                <td><?= $row['calories'] * $row['quantity'] ?></td>
                <td><?= $row['protein'] * $row['quantity'] ?></td>
                <td><?= $row['carbs'] * $row['quantity'] ?></td>
                <td><?= $row['fats'] * $row['quantity'] ?></td>

                <?php if ($role == 'admin' || $role == 'cafeteria') { ?>
                <td>
                    <a href="edit.php?id=<?= $row['log_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a onclick="return confirm('Delete this entry?')"
                       href="delete.php?id=<?= $row['log_id'] ?>"
                       class="btn btn-danger btn-sm">Delete</a>
                </td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<?php include "../includes/footer.php"; ?>
