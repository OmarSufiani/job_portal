<?php
include '../database/db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM users WHERE id = $id");
?>