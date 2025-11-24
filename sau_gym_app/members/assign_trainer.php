<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

// Fetch members
$members = mysqli_query($conn, "SELECT user_id, name FROM users WHERE role='member'");

// Fetch trainers
$trainers = mysqli_query($conn, "SELECT t.trainer_id, u.name 
                                 FROM trainers t 
                                 JOIN users u ON t.user_id = u.user_id");

// Fetch plans
$plans = mysqli_query($conn, "SELECT plan_id, plan_name FROM membership_plans");
?>

<div class="container mt-4">
    <h2>Assign Trainer to Member</h2>
    <hr>

    <form action="assign_save.php" method="POST">

        <div class="mb-3">
            <label class="form-label">Select Member</label>
            <select name="member_id" class="form-control" required>
                <option disabled selected>-- Select --</option>
                <?php while ($m = mysqli_fetch_assoc($members)) { ?>
                    <option value="<?= $m['user_id'] ?>"><?= $m['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Trainer</label>
            <select name="trainer_id" class="form-control" required>
                <option disabled selected>-- Select --</option>
                <?php while ($t = mysqli_fetch_assoc($trainers)) { ?>
                    <option value="<?= $t['trainer_id'] ?>"><?= $t['name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Select Membership Plan</label>
            <select name="plan_id" class="form-control" required>
                <?php while ($p = mysqli_fetch_assoc($plans)) { ?>
                    <option value="<?= $p['plan_id'] ?>"><?= $p['plan_name'] ?></option>
                <?php } ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control" required>
        </div>

        <button class="btn btn-success">Assign Trainer</button>
        <a href="assign_list.php" class="btn btn-secondary">View Assignments</a>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
