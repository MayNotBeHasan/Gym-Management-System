<?php
include "../config/db.php";

$id = $_GET["id"];
$conn->query("DELETE FROM memberships WHERE membership_id=$id");

header("Location: list.php");
exit;
?>
