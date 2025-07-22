<?php
session_start();
include '../database/db.php';

// Check if user is logged in
if (!isset($_SESSION['idNo'])) {
    header("Location: ../index.php");
    exit();
}

$idNo = $_SESSION['idNo'];
$applicationMessage = '';

// Function to check profile completeness
function isProfileComplete($userId, $conn) {
    $checks = [
        "SELECT * FROM personal_info WHERE user_id = $userId AND firstname != '' AND lastname != '' AND dob IS NOT NULL AND gender != '' AND mobile_number != '' AND email != ''",
        "SELECT * FROM employment_details WHERE user_id = $userId AND designation != '' AND start_date IS NOT NULL",
        "SELECT * FROM academic_qualifications WHERE user_id = $userId AND instituition_name != '' AND course != '' AND grade != ''",
        "SELECT * FROM referees WHERE user_id = $userId AND fullname != '' AND email != '' AND mobile_number != ''"
    ];
    
    foreach ($checks as $sql) {
        $result = mysqli_query($conn, $sql);
        if (!$result || mysqli_num_rows($result) == 0) {
            return false;
        }
    }
    return true;
}

$isComplete = isProfileComplete($idNo, $conn);

// Handle form submission if profile is complete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['job_id']) && $isComplete) {
    $jobId = (int)$_POST['job_id'];

    if ($jobId <= 0) {
        $applicationMessage = "❌ Invalid job ID.";
    } else {
        // Prevent duplicate applications
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

// Fetch available jobs to populate dropdown
$jobs = [];
$result = $conn->query("SELECT id, position, AdvertNo FROM jobs ORDER BY advert_date DESC");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Apply for Job</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Job Application</h2>

    <?php if (!empty($applicationMessage)): ?>
        <div class="alert alert-info"><?= $applicationMessage ?></div>
    <?php endif; ?>

    <?php if ($isComplete): ?>
        <form method="POST" id="submit-form" class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Job Position</label>
                <select name="job_id" class="form-select" required>
                    <option value="">-- Select Job --</option>
                    <?php foreach ($jobs as $job): ?>
                        <option value="<?= $job['id'] ?>">
                            <?= htmlspecialchars($job['position']) ?> (<?= htmlspecialchars($job['AdvertNo']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-12">
                <button type="submit" class="btn btn-primary"
                        onclick="return confirm('Are you sure you want to apply for this job?');">
                    Apply Now
                </button>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-danger mt-4">
            ❌ Please complete your profile (Personal Info, Employment, Academic, Referees) before applying.
        </div>
    <?php endif; ?>
</div>

<script src="../js/manageUser.js"></script>
</body>
</html>
