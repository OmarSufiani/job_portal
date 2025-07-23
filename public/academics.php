<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include '../database/db.php';

$error = '';
$success = '';

if (!isset($_SESSION['idNo'])) {
    $error = "You must be logged in to submit academic qualifications.";
} else {
    $idno = $_SESSION['idNo'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $instituition_name = $_POST['instituition_name'];
        $admno = $_POST['admno'];
        $area_of_study = $_POST['area_of_study'];
        $specialization = $_POST['specialization'];
        $award = $_POST['award'];
        $course = $_POST['course'];
        $grade = $_POST['grade'];
        $examiner = $_POST['examiner'];
        $certificate_no = $_POST['certificate_no'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $graduation_date = $_POST['graduation_date'];

        // Always insert a new record
        $stmt = $conn->prepare("INSERT INTO academic_qualifications 
            (user_id, instituition_name, admno, area_of_study, specialization, award, course, grade, examiner, certificate_no, start_date, end_date, graduation_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssssssssss", $idno, $instituition_name, $admno, $area_of_study, $specialization, $award, $course, $grade, $examiner, $certificate_no, $start_date, $end_date, $graduation_date);

        if ($stmt->execute()) {
            $success = "Academic qualification added successfully.";
        } else {
            $error = "Error inserting data: " . $stmt->error;
        }
    }

    // Fetch existing data for snapshot
    $snapshot = [];
    $result = $conn->prepare("SELECT * FROM academic_qualifications WHERE user_id = ?");
    $result->bind_param("i", $idno);
    $result->execute();
    $snapshotResult = $result->get_result();

    if ($snapshotResult && $snapshotResult->num_rows > 0) {
        $snapshot = $snapshotResult->fetch_all(MYSQLI_ASSOC);
    }
}
?>



<!DOCTYPE html>
<html>
<head>
    <title>Academic Qualifications</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2>Enter Academic Qualifications</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" id="academics-form" class="row g-3">

        <div class="col-md-6">
            <label class="form-label">Institution Name</label>
            <input type="text" name="instituition_name" class="form-control" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Admission No</label>
            <input type="text" name="admno" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Area of Study</label>
            <input type="text" name="area_of_study" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Specialization</label>
            <input type="text" name="specialization" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Award</label>
            <input type="text" name="award" class="form-control">
        </div>

        <div class="col-md-6">
            <label class="form-label">Course</label>
            <input type="text" name="course" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Grade</label>
            <input type="text" name="grade" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Examiner</label>
            <input type="text" name="examiner" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Certificate No</label>
            <input type="text" name="certificate_no" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>

        <div class="col-md-4">
            <label class="form-label">Graduation Date</label>
            <input type="date" name="graduation_date" class="form-control">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save Academic Qualification</button>
        </div>
    </form>

    <?php if (!empty($snapshot)): ?>
        <h4 class="mt-5">📘 Academic Qualifications Snapshot</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Institution Name</th>
                    <th>Admission No</th>
                    <th>Area of Study</th>
                    <th>Specialization</th>
                    <th>Award</th>
                    <th>Course</th>
                    <th>Grade</th>
                    <th>Examiner</th>
                    <th>Certificate No</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Graduation Date</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($snapshot as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['instituition_name']) ?></td>
                        <td><?= htmlspecialchars($row['admno']) ?></td>
                        <td><?= htmlspecialchars($row['area_of_study']) ?></td>
                        <td><?= htmlspecialchars($row['specialization']) ?></td>
                        <td><?= htmlspecialchars($row['award']) ?></td>
                        <td><?= htmlspecialchars($row['course']) ?></td>
                        <td><?= htmlspecialchars($row['grade']) ?></td>
                        <td><?= htmlspecialchars($row['examiner']) ?></td>
                        <td><?= htmlspecialchars($row['certificate_no']) ?></td>
                        <td><?= htmlspecialchars($row['start_date']) ?></td>
                        <td><?= htmlspecialchars($row['end_date']) ?></td>
                        <td><?= htmlspecialchars($row['graduation_date']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</body>
</html>
<script src="../js/manageUser.js"></script>