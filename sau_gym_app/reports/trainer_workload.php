<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

// Correct workload query
$sql = "
    SELECT 
        t.trainer_id,
        u.name AS trainer_name,
        COUNT(wp.workout_id) AS total_plans
    FROM trainers t
    JOIN users u ON t.user_id = u.user_id
    LEFT JOIN workout_plans wp 
        ON wp.trainer_id = t.trainer_id
    GROUP BY t.trainer_id, u.name
";

$result = mysqli_query($conn, $sql);
?>

<div class='container mt-4'>
    <h2>Trainer Workload Report</h2>
    <hr>

    <table class='table table-bordered'>
        <tr>
            <th>Trainer</th>
            <th>Total Workout Plans Created</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= $row['trainer_name'] ?></td>
                <td><?= $row['total_plans'] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>

<?php include "../includes/footer.php"; ?>
