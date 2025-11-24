<?php
include "../config/db.php";

$id = $_GET["id"];
$conn->query("DELETE FROM progress_tracking WHERE progress_id=$id");

header("Location: list.php");
exit;
?>
