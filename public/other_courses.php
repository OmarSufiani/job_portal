<?php
include '../database/db.php';
session_start();

$success = '';
$error = '';

if (!isset($_SESSION['idNo'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['idNo'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $instituition_name = $_POST['instituition_name'] ?? '';
    $course_name = $_POST['course_name'] ?? '';
    $certificate_no = $_POST['certificate_no'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? '';

    if ($user_id && $instituition_name && $course_name && $start_date) {
        $stmt = $conn->prepare("INSERT INTO other_courses (user_id, instituition_name, course_name, certificate_no, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $user_id, $instituition_name, $course_name, $certificate_no, $start_date, $end_date);

        if ($stmt->execute()) {
            $success = "Course details saved successfully.";
        } else {
            $error = "Database error: " . $stmt->error;
        }
    } else {
        $error = "Please fill in all required fields (institution, course name, start date).";
    }
}

// Fetch courses for current user
$courseSnapshot = [];
$stmt = $conn->prepare("SELECT instituition_name, course_name, certificate_no, start_date, end_date FROM other_courses WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
while ($row = $result->fetch_assoc()) {
    $courseSnapshot[] = $row;
}
$stmt->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Other Courses Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Add Other Courses</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" id="courses-form" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Institution Name</label>
            <input type="text" name="instituition_name" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Course Name</label>
            <input type="text" name="course_name" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Certificate Number</label>
            <input type="text" name="certificate_no" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Submit Course</button>
        </div>
    </form>

    <?php if (!empty($courseSnapshot)): ?>
        <h4 class="mt-5">Other Courses Snapshot</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Institution Name</th>
                    <th>Course Name</th>
                    <th>Certificate No</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($courseSnapshot as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['instituition_name']) ?></td>
                        <td><?= htmlspecialchars($row['course_name']) ?></td>
                        <td><?= htmlspecialchars($row['certificate_no']) ?></td>
                        <td><?= htmlspecialchars($row['start_date']) ?></td>
                        <td><?= htmlspecialchars($row['end_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>

<script src="../js/manageUser.js"></script>
