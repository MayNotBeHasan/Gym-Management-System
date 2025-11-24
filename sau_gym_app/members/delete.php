<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE user_id = $id AND role='member'";
mysqli_query($conn, $sql);

header("Location: list.php");
exit;
?>
