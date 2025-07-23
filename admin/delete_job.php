<?php
include 'conn.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

echo $stmt->affected_rows > 0 ? "Deleted" : "Failed";
$conn->close();
?>
