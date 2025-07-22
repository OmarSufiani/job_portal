<?php
include '../database/db.php';
session_start();

$success = '';
$error = '';

// Handle POST submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = $_POST['job_id'] ?? null;
    $user_id = $_POST['user_id'] ?? null;
    $job_status = $_POST['job_status'] ?? 'PROCESSING OF APPLICATION IN PROGRESS';
    $remarks = $_POST['remarks'] ?? null;

    if ($job_id && $user_id) {
        $stmt = $conn->prepare("INSERT INTO application_status (job_id, user_id, job_status, remarks) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $job_id, $user_id, $job_status, $remarks);

        if ($stmt->execute()) {
            $success = "Application status entry saved successfully.";
        } else {
            $error = "Failed to save entry: " . $stmt->error;
        }
    } else {
        $error = "Please select both job and user.";
    }
}

// Fetch jobs
$jobs = [];
$jobResult = $conn->query("SELECT id, position FROM jobs ORDER BY advert_date DESC");
if ($jobResult && $jobResult->num_rows > 0) {
    while ($row = $jobResult->fetch_assoc()) {
        $jobs[] = $row;
    }
}

// Fetch users
$users = [];
$userResult = $conn->query("SELECT idNo, name FROM users ORDER BY name ASC");
if ($userResult && $userResult->num_rows > 0) {
    while ($row = $userResult->fetch_assoc()) {
        $users[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Application Status Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Enter Application Status</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Select Job</label>
            <select name="job_id" class="form-select" required>
                <option value="">-- Select Job --</option>
                <?php foreach ($jobs as $job): ?>
                    <option value="<?= $job['id'] ?>"><?= htmlspecialchars($job['position']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Select User</label>
            <select name="user_id" class="form-select" required>
                <option value="">-- Select User --</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['idNo'] ?>"><?= htmlspecialchars($user['name']) ?> (<?= $user['idNo'] ?>)</option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Status</label>
            <input type="text" name="job_status" class="form-control"
                   value="PROCESSING OF APPLICATION IN PROGRESS">
        </div>

        <div class="col-md-12">
            <label class="form-label">Remarks (Optional)</label>
            <textarea name="remarks" class="form-control" rows="3"></textarea>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit Entry</button>
        </div>
    </form>
</body>
</html>
