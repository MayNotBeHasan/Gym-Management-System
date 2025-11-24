<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$id = $_GET['id'];

$sql = "SELECT * FROM membership_plans WHERE plan_id=$id";
$plan = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if(isset($_POST['update'])){

    $name = $_POST['plan_name'];
    $duration = $_POST['duration_months'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $sql = "UPDATE membership_plans SET
            plan_name='$name',
            duration_months=$duration,
            price=$price,
            description='$description',
            status='$status'
            WHERE plan_id=$id";

    mysqli_query($conn, $sql);

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Edit Membership Plan</h2>

    <form method="POST">

        <label>Plan Name</label>
        <input type="text" name="plan_name" class="form-control" value="<?= $plan['plan_name'] ?>"><br>

        <label>Duration (months)</label>
        <input type="number" name="duration_months" class="form-control" value="<?= $plan['duration_months'] ?>"><br>

        <label>Price (₹)</label>
        <input type="number" name="price" class="form-control" value="<?= $plan['price'] ?>"><br>

        <label>Description</label>
        <textarea name="description" class="form-control"><?= $plan['description'] ?></textarea><br>

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" <?= ($plan['status']=='active')?'selected':'' ?>>Active</option>
            <option value="inactive" <?= ($plan['status']=='inactive')?'selected':'' ?>>Inactive</option>
        </select><br>

        <button class="btn btn-success" name="update">Update</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
