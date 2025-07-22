<?php
include '../database/db.php';
session_start();

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['idNo'])) {
    header("Location: ../index.php");
    exit();
}

$userId = $_SESSION['user_id'];  // For session tracking
$idNo = $_SESSION['idNo'];       // For use in job_status table

// Handle job application if job_id is in URL
$applicationMessage = '';
if (isset($_GET['job_id'])) {
    $jobId = (int)$_GET['job_id'];

    if ($jobId <= 0) {
        $applicationMessage = "❌ Invalid job ID.";
    } else {
        // Prevent duplicate application
        $check = $conn->prepare("SELECT id FROM status WHERE user_id = ? AND job_id = ?");
        $check->bind_param("ii", $idNo, $jobId);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $applicationMessage = "⚠️ You have already applied for this job.";
        } else {
            $stmt = $conn->prepare("INSERT INTO status (user_id, job_id) VALUES (?, ?)");
            $stmt->bind_param("ii", $idNo, $jobId);

            if ($stmt->execute()) {
                $applicationMessage = "✅ Application submitted successfully!";
            } else {
                $applicationMessage = "❌ Failed to apply. Please try again.";
            }

            $stmt->close();
        }

        $check->close();
    }
}

// Fetch job listings
$sql = "SELECT * FROM jobs ORDER BY advert_date DESC";
$result = $conn->query($sql);
?>


<head>
    <title>Job Listings</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

<div class="container mt-5">
    <h2 class="mb-4">Posted Jobs</h2>

    <?php if ($applicationMessage): ?>
        <div class="alert alert-info"><?= $applicationMessage ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Advert No</th>
                <th>Position</th>
                <th>Job Scale</th>
                <th>Ministry</th>
                <th>Vacancies</th>
                <th>Experience (Years)</th>
                <th>Category</th>
                <th>Advert Date</th>
                <th>Close Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($job = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($job['id']) ?></td>
                        <td><?= htmlspecialchars($job['AdvertNo']) ?></td>
                        <td><?= htmlspecialchars($job['position']) ?></td>
                        <td><?= htmlspecialchars($job['job_scale']) ?></td>
                        <td><?= htmlspecialchars($job['ministry']) ?></td>
                        <td><?= htmlspecialchars($job['no_vacancies']) ?></td>
                        <td><?= htmlspecialchars($job['years_exp']) ?></td>
                        <td><?= htmlspecialchars($job['Advert_category']) ?></td>
                        <td><?= htmlspecialchars($job['advert_date']) ?></td>
                        <td><?= htmlspecialchars($job['advert_close_date']) ?></td>
                        <td>
                            <a href="?job_id=<?= $job['id'] ?>" class="btn btn-success"
                               onclick="return confirm('Are you sure you want to apply for this job?');">Apply</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="11" class="text-center">No jobs found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

