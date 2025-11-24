<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$sql = "
    SELECT m.membership_id, u.name AS member_name, t.name AS trainer_name,
           mp.plan_name, m.start_date, m.end_date
    FROM memberships m
    JOIN users u ON m.member_id = u.user_id
    JOIN trainers tr ON m.trainer_id = tr.trainer_id
    JOIN users t ON tr.user_id = t.user_id
    JOIN membership_plans mp ON m.plan_id = mp.plan_id
";

$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>All Assigned Trainers</h2>
    <a href="assign_trainer.php" class="btn btn-primary mb-3">Assign New</a>

    <?php if (isset($_GET['success'])) { ?>
        <div class="alert alert-success">Trainer Assigned Successfully!</div>
    <?php } ?>

    <table class="table table-bordered">
        <tr>
            <th>Member</th>
            <th>Trainer</th>
            <th>Plan</th>
            <th>Start</th>
            <th>End</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['member_name'] ?></td>
                <td><?= $row['trainer_name'] ?></td>
                <td><?= $row['plan_name'] ?></td>
                <td><?= $row['start_date'] ?></td>
                <td><?= $row['end_date'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php include "../includes/footer.php"; ?>
