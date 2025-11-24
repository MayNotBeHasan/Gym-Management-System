<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$sql = "
    SELECT p.plan_name, COUNT(m.membership_id) AS total_members
    FROM membership_plans p
    LEFT JOIN memberships m ON p.plan_id = m.plan_id
    GROUP BY p.plan_id
";

$data = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>Membership Statistics</h2>
    <hr>

    <table class="table table-bordered">
        <tr>
            <th>Plan Name</th>
            <th>Total Members</th>
        </tr>

        <?php while ($row = mysqli_fetch_assoc($data)) { ?>
        <tr>
            <td><?= $row['plan_name'] ?></td>
            <td><?= $row['total_members'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php include "../includes/footer.php"; ?>
