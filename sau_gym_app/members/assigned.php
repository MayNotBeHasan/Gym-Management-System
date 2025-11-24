<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['trainer']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$user_id = $_SESSION['user_id'];

// STEP 1: find trainer_id from trainers table
$q = mysqli_query($conn, "SELECT trainer_id FROM trainers WHERE user_id = $user_id");
$trainer = mysqli_fetch_assoc($q);

if (!$trainer) {
    echo "<h3 class='text-danger text-center mt-4'>No trainer profile found.</h3>";
    include "../includes/footer.php";
    exit;
}

$trainer_id = $trainer['trainer_id'];

// STEP 2: get all members assigned to this trainer
$sql = "
    SELECT u.name, u.email, u.phone, m.start_date, m.end_date
    FROM memberships m
    JOIN users u ON m.member_id = u.user_id
    WHERE m.trainer_id = $trainer_id
";

$result = mysqli_query($conn, $sql);
?>

<div class="container mt-4">
    <h2>Assigned Members</h2>
    <hr>

    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Membership Start</th>
            <th>Membership End</th>
        </tr>

        <?php if (mysqli_num_rows($result) == 0) { ?>
            <tr><td colspan="5" class="text-center text-danger">No members assigned.</td></tr>
        <?php } ?>

        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['phone'] ?></td>
            <td><?= $row['start_date'] ?></td>
            <td><?= $row['end_date'] ?></td>
        </tr>
        <?php } ?>
    </table>
</div>

<?php include "../includes/footer.php"; ?>
