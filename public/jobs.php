<?php
include '../config/db.php';
$result = $conn->query("SELECT * FROM jobs WHERE status='Open'");
while ($job = $result->fetch_assoc()) {
    echo "<h3>{$job['title']}</h3>";
    echo "<p>{$job['description']}</p>";
    echo "<a href='apply.php?job_id={$job['id']}'>Apply Now</a><hr>";
}
?>