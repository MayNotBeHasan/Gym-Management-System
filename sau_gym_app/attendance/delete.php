<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM attendance WHERE attendance_id=$id");

header("Location: list.php");
exit;
?>
