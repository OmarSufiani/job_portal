<?php
include '../database/db.php';
session_start();

if (!isset($_SESSION['idNo'])) {
    echo '<div class="alert alert-danger">You must be logged in to apply for a job.</div>';
    exit();
}

$idNo = $_SESSION['idNo'];
$applicationMessage = '';

// Handle job application via AJAX POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id'])) {
    $jobId = (int)$_POST['job_id'];

    if ($jobId <= 0) {
        $applicationMessage = "<div class='alert alert-danger'>Invalid job ID.</div>";
    } else {
        $tablesToCheck = ['personal_info', 'academic_qualifications', 'employment_details', 'referees'];
        $incompleteSections = [];

        foreach ($tablesToCheck as $table) {
            $stmt = $conn->prepare("SELECT id FROM $table WHERE user_id = ? LIMIT 1");
            $stmt->bind_param("s", $idNo);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows == 0) {
                $incompleteSections[] = ucwords(str_replace('_', ' ', $table));
            }

            $stmt->close();
        }

        if (!empty($incompleteSections)) {
            $applicationMessage = "<div class='alert alert-danger'>Please complete your profile: " . implode(", ", $incompleteSections) . ".</div>";
        } else {
            $check = $conn->prepare("SELECT id FROM status WHERE user_id = ? AND job_id = ?");
            $check->bind_param("ii", $idNo, $jobId);
            $check->execute();
            $check->store_result();

            if ($check->num_rows > 0) {
                $applicationMessage = "<div class='alert alert-warning'>You have already applied for this job.</div>";
            } else {
                $stmt = $conn->prepare("INSERT INTO status (user_id, job_id) VALUES (?, ?)");
                $stmt->bind_param("ii", $idNo, $jobId);

                if ($stmt->execute()) {
                    $applicationMessage = "<div class='alert alert-success'>Application submitted successfully!</div>";
                } else {
                    $applicationMessage = "<div class='alert alert-danger'>Failed to apply. Please try again.</div>";
                }

                $stmt->close();
            }

            $check->close();
        }
    }

    echo $applicationMessage;
    exit(); // Important for AJAX
}

// Fetch jobs
$sql = "SELECT * FROM jobs ORDER BY advert_date DESC";
$result = $conn->query($sql);
?>

<div class="container mt-3">
    <h4>Posted Jobs</h4>
    <form id="apply-form" method="POST">
        <table id="job-table" class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Advert No</th>
                    <th>Position</th>
                    <th>Job Scale</th>
                    <th>Ministry</th>
                    <th>Vacancies</th>
                    <th>Experience</th>
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
                                <button type="submit" name="job_id" value="<?= $job['id'] ?>" class="btn btn-success btn-sm">Apply</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="11" class="text-center">No jobs found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </form>
</div>

<script src="../js/manageUser.js"></script>
