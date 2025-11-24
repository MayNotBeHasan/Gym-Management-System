<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'cafeteria']);

include "../config/db.php";

$id = $_GET["id"];
$conn->query("DELETE FROM diet_log WHERE log_id=$id");

header("Location: list.php");
exit;
?>
