<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$id = $_GET['id'];

$sql = "SELECT t.*, u.name, u.email, u.phone 
        FROM trainers t 
        JOIN users u ON t.user_id = u.user_id
        WHERE trainer_id = $id";

$trainer = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if(isset($_POST['update'])) {

    $name  = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $spec  = $_POST['specialization'];
    $exp   = $_POST['experience_years'];
    $cert  = $_POST['certification'];
    $rate  = $_POST['hourly_rate'];
    $bio   = $_POST['bio'];

    $uid = $trainer['user_id'];

    mysqli_query($conn, "UPDATE users SET 
        name='$name', email='$email', phone='$phone'
        WHERE user_id=$uid");

    mysqli_query($conn, "UPDATE trainers SET
        specialization='$spec',
        experience_years=$exp,
        certification='$cert',
        hourly_rate=$rate,
        bio='$bio'
        WHERE trainer_id=$id");

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Edit Trainer</h2>

    <form method="POST">

        <h4>Basic Information</h4>
        <input type="text" name="name" class="form-control" value="<?= $trainer['name'] ?>"><br>
        <input type="email" name="email" class="form-control" value="<?= $trainer['email'] ?>"><br>
        <input type="text" name="phone" class="form-control" value="<?= $trainer['phone'] ?>"><br>

        <h4>Trainer Details</h4>
        <input type="text" name="specialization" class="form-control" value="<?= $trainer['specialization'] ?>"><br>
        <input type="number" name="experience_years" class="form-control" value="<?= $trainer['experience_years'] ?>"><br>
        <input type="text" name="certification" class="form-control" value="<?= $trainer['certification'] ?>"><br>
        <input type="number" name="hourly_rate" class="form-control" value="<?= $trainer['hourly_rate'] ?>"><br>
        <textarea name="bio" class="form-control"><?= $trainer['bio'] ?></textarea><br>

        <button class="btn btn-success" name="update">Update</button>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
