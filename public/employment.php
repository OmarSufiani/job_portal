<?php
include '../database/db.php';
session_start();

$success = '';
$error = '';

// Check if user is logged in
if (!isset($_SESSION['idNo'])) {
    die("Access denied. Please login.");
}

$user_id = $_SESSION['idNo'];

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $designation = $_POST['designation'] ?? '';
    $gross_salary = $_POST['gross_salary'] ?? '';
    $department = $_POST['department'] ?? '';
    $duties = $_POST['duties'] ?? '';
    $start_date = $_POST['start_date'] ?? '';
    $end_date = $_POST['end_date'] ?? null;

    if ($designation && $department && $start_date) {
        $stmt = $conn->prepare("INSERT INTO employment_details (user_id, designation, gross_salary, department, duties, start_date, end_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssss", $user_id, $designation, $gross_salary, $department, $duties, $start_date, $end_date);

        if ($stmt->execute()) {
            $success = "Employment details submitted successfully.";
        } else {
            $error = "Database error: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "Please fill in all required fields (designation, department, start date).";
    }
}

// No prefill
$formData = [];

// Fetch all employment records for snapshot table
$employmentSnapshot = [];
$stmt = $conn->prepare("SELECT designation, gross_salary, department, duties, start_date, end_date FROM employment_details WHERE user_id = ? ORDER BY id DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
while ($row = $res->fetch_assoc()) {
    $employmentSnapshot[] = $row;
}
$stmt->close();

// Helper function
function old($key, $data) {
    return htmlspecialchars($data[$key] ?? '');
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employment Details Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Enter Employment Details</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST"  id="employment-form" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Designation</label>
            <input type="text" name="designation" class="form-control" required value="<?= old('designation', $formData) ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Gross Salary</label>
            <input type="text" name="gross_salary" class="form-control" value="<?= old('gross_salary', $formData) ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Department</label>
            <input type="text" name="department" class="form-control" required value="<?= old('department', $formData) ?>">
        </div>

        <div class="col-md-12">
            <label class="form-label">Duties</label>
            <textarea name="duties" class="form-control" rows="3"><?= old('duties', $formData) ?></textarea>
        </div>

        <div class="col-md-6">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" required value="<?= old('start_date', $formData) ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" value="<?= old('end_date', $formData) ?>">
        </div>

        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id) ?>">

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save Employment Details</button>
        </div>
    </form>

    <?php if (!empty($employmentSnapshot)): ?>
        <h4 class="mt-5">Employment Records Snapshot</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Designation</th>
                    <th>Gross Salary</th>
                    <th>Department</th>
                    <th>Duties</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employmentSnapshot as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['designation']) ?></td>
                        <td><?= htmlspecialchars($row['gross_salary']) ?></td>
                        <td><?= htmlspecialchars($row['department']) ?></td>
                        <td><?= htmlspecialchars($row['duties']) ?></td>
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
