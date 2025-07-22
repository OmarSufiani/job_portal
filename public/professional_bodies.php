<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['idNo'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['idNo'];
$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
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

    $stmt = $conn->prepare("INSERT INTO professional_bodies (user_id, instituition_name, admno, area_of_study, specialization, award, course, grade, examiner, certificate_no, start_date, end_date, graduation_date)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssssssss", $user_id, $instituition_name, $admno, $area_of_study, $specialization, $award, $course, $grade, $examiner, $certificate_no, $start_date, $end_date, $graduation_date);

    if ($stmt->execute()) {
        $success = "Record added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Professional Body</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h3>Add Professional Body</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST"  id="professional-form" class="row g-3">
          <div class="col-md-2">
            <label>ID Number</label>
            <input type="number" name="user_id"  class="form-control" value="<?= htmlspecialchars($_SESSION['idNo']) ?>" readonly>
        </div>
        <div class="col-md-6">
            <label>Institution Name</label>
            <input type="text" name="instituition_name" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Admission No</label>
            <input type="text" name="admno" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Area of Study</label>
            <input type="text" name="area_of_study" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Specialization</label>
            <input type="text" name="specialization" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Award</label>
            <input type="text" name="award" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Course</label>
            <input type="text" name="course" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Grade</label>
            <input type="text" name="grade" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Examiner</label>
            <input type="text" name="examiner" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Certificate No</label>
            <input type="text" name="certificate_no" class="form-control">
        </div>
        <div class="col-md-4">
            <label>Start Date</label>
            <input type="date" name="start_date" class="form-control">
        </div>
        <div class="col-md-4">
            <label>End Date</label>
            <input type="date" name="end_date" class="form-control">
        </div>
        <div class="col-md-4">
            <label>Graduation Date</label>
            <input type="date" name="graduation_date" class="form-control">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
</body>
</html>
<script src="../js/manageUser.js"></script>