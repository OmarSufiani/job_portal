<?php
include '../database/db.php';
$sql = "
    SELECT 
        s.id AS status_id,
        u.FirstName,
        j.position,
        s.job_status,
        s.date_applied,
        s.remarks
    FROM status s
    INNER JOIN users u ON s.user_id = u.idNo
    INNER JOIN jobs j ON s.job_id = j.id
    WHERE s.user_id = ?
    ORDER BY s.id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param('');
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Applications View</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Submitted Job Applications</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Job Position</th>
                    <th>Application Status</th>
                    <th>Date Applied</th>
                    <th>Remarks</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['status_id']) ?></td>
                        <td><?= htmlspecialchars($row['FirstName']) ?></td>
                        <td><?= htmlspecialchars($row['position']) ?></td>
                        <td><?= htmlspecialchars($row['job_status']) ?></td>
                        <td><?= htmlspecialchars($row['date_applied']) ?></td>
                        <td><?= !empty($row['remarks']) ? htmlspecialchars($row['remarks']) : 'N/A' ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No applications found.</div>
    <?php endif; ?>
</div>
</body>
</html>