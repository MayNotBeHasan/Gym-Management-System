<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

if(isset($_POST['save'])){

    $name   = $_POST['name'];
    $email  = $_POST['email'];
    $phone  = $_POST['phone'];
    $password = $_POST['password'];

    $spec = $_POST['specialization'];
    $exp  = $_POST['experience_years'];
    $cert = $_POST['certification'];
    $rate = $_POST['hourly_rate'];
    $bio  = $_POST['bio'];

    // step 1: insert into users
    $sql1 = "INSERT INTO users (name, email, password, role, phone, status)
             VALUES ('$name', '$email', '$password', 'trainer', '$phone', 'active')";

    mysqli_query($conn, $sql1);
    $user_id = mysqli_insert_id($conn);

    // step 2: insert into trainers
    $sql2 = "INSERT INTO trainers (user_id, specialization, experience_years, certification, hourly_rate, bio)
             VALUES ($user_id, '$spec', $exp, '$cert', $rate, '$bio')";

    mysqli_query($conn, $sql2);

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Add New Trainer</h2>

    <form method="POST">

        <h4>Basic Information</h4>
        <input type="text" name="name" class="form-control" placeholder="Name" required><br>
        <input type="email" name="email" class="form-control" placeholder="Email" required><br>
        <input type="text" name="phone" class="form-control" placeholder="Phone"><br>
        <input type="password" name="password" class="form-control" placeholder="Password" required><br>

        <h4>Trainer Details</h4>
        <input type="text" name="specialization" class="form-control" placeholder="Specialization"><br>
        <input type="number" name="experience_years" class="form-control" placeholder="Experience (years)"><br>
        <input type="text" name="certification" class="form-control" placeholder="Certification"><br>
        <input type="number" name="hourly_rate" class="form-control" placeholder="Hourly Rate"><br>
        <textarea name="bio" class="form-control" placeholder="Bio"></textarea><br>

        <button class="btn btn-success" name="save">Save Trainer</button>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
