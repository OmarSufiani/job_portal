<?php
include '../database/db.php';
session_start();

if (!isset($_SESSION['idNo'])) {
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT * FROM jobs WHERE Advert_category = 'open' ORDER BY advert_date DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Available Job Vacancies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Available Job Vacancies</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Advert No</th>
                    <th>Position</th>
                    <th>Scale</th>
                    <th>Ministry</th>
                    <th>Vacancies</th>
                    <th>Experience</th>
                    <th>Advert Date</th>
                    <th>Closing Date</th>
                    <th>Job description</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($job = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($job['id']) ?></td>
                        <td><?= htmlspecialchars($job['AdvertNo']) ?></td>
                        <td><?= htmlspecialchars($job['position']) ?></td>
                        <td><?= htmlspecialchars($job['job_scale']) ?></td>
                        <td><?= htmlspecialchars($job['ministry']) ?></td>
                        <td><?= htmlspecialchars($job['no_vacancies']) ?></td>
                        <td><?= htmlspecialchars($job['years_exp']) ?> years</td>
                        <td><?= htmlspecialchars($job['advert_date']) ?></td>
                        <td><?= htmlspecialchars($job['advert_close_date']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#jobModal<?= $job['id'] ?>">
                                View Details
                            </button>
                        </td>
                    </tr>

                    <!-- Modal for Job Details -->
                    <div class="modal fade" id="jobModal<?= $job['id'] ?>" tabindex="-1" aria-labelledby="jobModalLabel<?= $job['id'] ?>" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="jobModalLabel<?= $job['id'] ?>">Job Description - <?= htmlspecialchars($job['position']) ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                            <?= nl2br(htmlspecialchars($job['description'] ?? 'No description available.')) ?>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-warning">No job vacancies found.</div>
    <?php endif; ?>
</div>
</body>
</html>
