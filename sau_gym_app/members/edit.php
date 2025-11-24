<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$id = $_GET['id'];

$sql = "SELECT * FROM users WHERE user_id=$id AND role='member'";
$result = mysqli_query($conn, $sql);
$member = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){
    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $status = $_POST['status'];

    $sql = "UPDATE users 
            SET name='$name', email='$email', phone='$phone', status='$status' 
            WHERE user_id=$id";

    mysqli_query($conn, $sql);

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Edit Member</h2>

    <form method="POST">

        <label>Name</label>
        <input type="text" name="name" class="form-control" value="<?= $member['name'] ?>" required><br>

        <label>Email</label>
        <input type="email" name="email" class="form-control" value="<?= $member['email'] ?>" required><br>

        <label>Phone</label>
        <input type="text" name="phone" class="form-control" value="<?= $member['phone'] ?>"><br>

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active" <?= ($member['status']=='active')?'selected':'' ?>>Active</option>
            <option value="inactive" <?= ($member['status']=='inactive')?'selected':'' ?>>Inactive</option>
        </select><br>

        <button class="btn btn-success" name="update">Update</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
