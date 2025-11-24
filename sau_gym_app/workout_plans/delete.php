<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin', 'trainer']);

include "../config/db.php";

$id = $_GET['id'];

// SAFE deletion
$stmt = $conn->prepare("DELETE FROM workout_plans WHERE workout_id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: list.php");
exit;
?>
