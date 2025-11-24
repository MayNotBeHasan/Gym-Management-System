<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";

$id = $_GET['id'];

// get the user id from trainer table
$sql = "SELECT user_id FROM trainers WHERE trainer_id = $id";
$res = mysqli_fetch_assoc(mysqli_query($conn, $sql));
$user_id = $res['user_id'];

// delete trainer record
mysqli_query($conn, "DELETE FROM trainers WHERE trainer_id = $id");

// delete user record
mysqli_query($conn, "DELETE FROM users WHERE user_id = $user_id");

header("Location: list.php");
exit;
?>
