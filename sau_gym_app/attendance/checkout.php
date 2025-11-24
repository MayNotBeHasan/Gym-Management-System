<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";
include "../includes/header.php";
include "../includes/navbar.php";

$id = $_GET['id'];

$sql = "SELECT * FROM attendance WHERE attendance_id=$id";
$row = mysqli_fetch_assoc(mysqli_query($conn, $sql));

if(isset($_POST['checkout'])){

    $checkout_time = $_POST['check_out'];

    $update = "UPDATE attendance SET check_out_time='$checkout_time'
               WHERE attendance_id=$id";

    mysqli_query($conn, $update);

    header("Location: list.php");
    exit;
}
?>

<div class="container mt-4">
    <h2>Checkout Member</h2>

    <form method="POST">

        <label>Check-in Time:</label>
        <input type="text" class="form-control" value="<?= $row['check_in_time'] ?>" disabled><br>

        <label>Checkout Time</label>
        <input type="datetime-local" name="check_out" class="form-control" required><br>

        <button name="checkout" class="btn btn-success">Submit Checkout</button>

    </form>
</div>

<?php include "../includes/footer.php"; ?>
