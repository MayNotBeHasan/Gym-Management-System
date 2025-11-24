<?php
include "../config/db.php";

$id = $_GET["id"];
$conn->query("DELETE FROM payments WHERE payment_id=$id");

header("Location: list.php");
exit;
?>
