<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer', 'cafeteria']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$sql = "
    SELECT 
        u.name AS member,
        SUM(m.calories * d.quantity) AS calories,
        SUM(m.protein * d.quantity) AS protein,
        SUM(m.carbs * d.quantity) AS carbs,
        SUM(m.fats * d.quantity) AS fats
    FROM diet_log d
    JOIN users u ON u.user_id = d.member_id
    JOIN meal m ON m.meal_id = d.meal_id
    GROUP BY d.member_id
    ORDER BY calories DESC
";

$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>Diet Summary (Total Intake)</h2>
    <hr>

    <table class="table table-bordered">
        <tr>
            <th>Member</th>
            <th>Calories</th>
            <th>Protein</th>
            <th>Carbs</th>
            <th>Fats</th>
        </tr>

        <?php while ($r = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $r['member'] ?></td>
            <td><?= $r['calories'] ?></td>
            <td><?= $r['protein'] ?></td>
            <td><?= $r['carbs'] ?></td>
            <td><?= $r['fats'] ?></td>
        </tr>
        <?php } ?>

    </table>

</div>

<?php include "../includes/footer.php"; ?>
