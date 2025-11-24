<?php
include "../auth/check_login.php";
include "../auth/check_role.php";
allow_role(['admin']);

include "../config/db.php";

$member = $_POST['member_id'];
$trainer = $_POST['trainer_id'];
$plan = $_POST['plan_id'];
$start = $_POST['start_date'];
$end = $_POST['end_date'];

$sql = "INSERT INTO memberships 
        (member_id, plan_id, trainer_id, start_date, end_date, status)
        VALUES ('$member', '$plan', '$trainer', '$start', '$end', 'active')";

mysqli_query($conn, $sql);

header("Location: assign_list.php?success=1");
exit;
?>
