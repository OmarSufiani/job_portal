<?php
session_start();
include '../database/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $conn->real_escape_string(trim($_POST['id']));
    $AdvertNo = $conn->real_escape_string(trim($_POST['AdvertNo']));
    $position = $conn->real_escape_string(trim($_POST['position']));
    $job_scale = $conn->real_escape_string(trim($_POST['job_scale']));
    $ministry = $conn->real_escape_string(trim($_POST['ministry']));
    $no_vacancies = (int)$_POST['no_vacancies'];
    $years_exp = (int)$_POST['years_exp'];
    $Advert_category = $conn->real_escape_string($_POST['Advert_category']);
    $advert_date = $_POST['advert_date'];
    $advert_close_date = $_POST['advert_close_date'];

    if (
             empty($id) ||empty($AdvertNo) || empty($position) || empty($job_scale) || empty($ministry)
        || empty($no_vacancies) || empty($years_exp) || empty($Advert_category)
        || empty($advert_date) || empty($advert_close_date)
    ) {
        $error = "All fields are required.";
    } elseif (!in_array($Advert_category, ['open', 'closed'])) {
        $error = "Invalid Advert Category.";
    } elseif (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $advert_date) || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $advert_close_date)) {
        $error = "Invalid date format.";
    } else {
        $stmt = $conn->prepare("INSERT INTO jobs (id, AdvertNo, position, job_scale, ministry, no_vacancies, years_exp, Advert_category, advert_date, advert_close_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("issssiiiss",$id, $AdvertNo, $position, $job_scale, $ministry, $no_vacancies, $years_exp, $Advert_category, $advert_date, $advert_close_date);

        if ($stmt->execute()) {
            $success = "Job posted successfully!";
        } else {
            $error = "Error posting job: " . $stmt->error;
        }
        $stmt->close();
    }
}
$conn->close();
?>

<style>
  #user-content {
        min-height: 100px;
        background-color: #f9f9f9;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }
    </style>
    



  

    <h2>Post a Job</h2>

<form method="POST" id="post-job-form" class="needs-validation container" novalidate>
    <?php if ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php elseif ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="row">
         <div class="col-md-6 mb-3">
            <label for="Job_id" class="form-label">Job id</label>
            <input type="number" id="job_id" name="id" class="form-control" required />
        </div>
        <div class="col-md-6 mb-3">
            <label for="AdvertNo" class="form-label">Advertisement Number</label>
            <input type="text" id="AdvertNo" name="AdvertNo" class="form-control" required />
        </div>

        <div class="col-md-6 mb-3">
            <label for="position" class="form-label">Position</label>
            <input type="text" id="position" name="position" class="form-control" required />
        </div>

        <div class="col-md-6 mb-3">
            <label for="job_scale" class="form-label">Job Scale</label>
            <input type="text" id="job_scale" name="job_scale" class="form-control" required />
        </div>

        <div class="col-md-6 mb-3">
            <label for="ministry" class="form-label">Ministry</label>
            <input type="text" id="ministry" name="ministry" class="form-control" required />
        </div>

        <div class="col-md-6 mb-3">
            <label for="no_vacancies" class="form-label">Number of Vacancies</label>
            <input type="number" id="no_vacancies" name="no_vacancies" class="form-control" min="1" required />
        </div>

        <div class="col-md-6 mb-3">
            <label for="years_exp" class="form-label">Years of Experience Required</label>
            <input type="number" id="years_exp" name="years_exp" class="form-control" min="0" required />
        </div>

        <div class="col-md-6 mb-3">
            <label for="Advert_category" class="form-label">Advertisement Category</label>
            <select id="Advert_category" name="Advert_category" class="form-select" required>
                <option value="">-- Select --</option>
                <option value="open">Open</option>
                <option value="closed">Closed</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="advert_date" class="form-label">Advertisement Date</label>
            <input type="date" id="advert_date" name="advert_date" class="form-control" required />
        </div>

        <div class="col-md-6 mb-3">
            <label for="advert_close_date" class="form-label">Advertisement Close Date</label>
            <input type="date" id="advert_close_date" name="advert_close_date" class="form-control" required />
        </div>
    </div>

    <div class="text-center mt-3">
        <button type="submit" class="btn btn-primary px-5">Post Job</button>
    </div>
</form>

<script src="../js/manageUser.js"></script>
