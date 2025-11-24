<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

if(isset($_POST['save'])){
    $name = $_POST['plan_name'];
    $duration = $_POST['duration_months'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $status = $_POST['status'];

    $sql = "INSERT INTO membership_plans (plan_name, duration_months, price, description, status)
            VALUES ('$name', $duration, $price, '$description', '$status')";

    mysqli_query($conn, $sql);
    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Add Membership Plan</h2>

    <form method="POST">

        <label>Plan Name</label>
        <input type="text" name="plan_name" class="form-control" required><br>

        <label>Duration (months)</label>
        <input type="number" name="duration_months" class="form-control" required><br>

        <label>Price (₹)</label>
        <input type="number" name="price" class="form-control" required><br>

        <label>Description</label>
        <textarea name="description" class="form-control"></textarea><br>

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select><br>

        <button class="btn btn-success" name="save">Save</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
