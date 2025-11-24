<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

if(isset($_POST['save'])){
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $phone    = $_POST['phone'];
    $password = $_POST['password'];

    $sql = "INSERT INTO users (name, email, password, role, phone, status) 
            VALUES ('$name', '$email', '$password', 'member', '$phone', 'active')";

    mysqli_query($conn, $sql);

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Add New Member</h2>

    <form method="POST">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required><br>

        <label>Email</label>
        <input type="email" name="email" class="form-control" required><br>

        <label>Phone</label>
        <input type="text" name="phone" class="form-control"><br>

        <label>Password</label>
        <input type="password" name="password" class="form-control" required><br>

        <button class="btn btn-success" name="save">Save</button>
    </form>
</div>

<?php include "../includes/footer.php"; ?>
