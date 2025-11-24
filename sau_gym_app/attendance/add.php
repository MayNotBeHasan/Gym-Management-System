<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$members = mysqli_query($conn, "SELECT user_id, name FROM users WHERE role='member'");

if(isset($_POST['save'])){

    $member_id = $_POST['member_id'];
    $check_in = $_POST['check_in'];
    $notes = $_POST['notes'];

    $sql = "INSERT INTO attendance (member_id, check_in_time, notes)
            VALUES ($member_id, '$check_in', '$notes')";

    mysqli_query($conn, $sql);

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Add Attendance (Check-in)</h2>

    <form method="POST">

        <label>Member</label>
        <select class="form-control" name="member_id" required>
            <option value="">Select Member</option>
            <?php while($m = mysqli_fetch_assoc($members)) { ?>
                <option value="<?= $m['user_id'] ?>"><?= $m['name'] ?></option>
            <?php } ?>
        </select><br>

        <label>Check-in Time</label>
        <input type="datetime-local" name="check_in" class="form-control" required><br>

        <label>Notes</label>
        <textarea name="notes" class="form-control"></textarea><br>

        <button class="btn btn-success" name="save">Save</button>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
