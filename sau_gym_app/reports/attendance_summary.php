<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$sql = "
    SELECT u.name AS member, COUNT(a.attendance_id) AS visits 
    FROM attendance a
    JOIN users u ON u.user_id = a.member_id
    GROUP BY a.member_id
    ORDER BY visits DESC
";

$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>Attendance Summary</h2>
    <hr>

    <table class="table table-bordered">
        <tr>
            <th>Member</th>
            <th>Total Visits</th>
        </tr>

        <?php while ($r = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $r['member'] ?></td>
            <td><?= $r['visits'] ?></td>
        </tr>
        <?php } ?>
    </table>

</div>

<?php include "../includes/footer.php"; ?>
