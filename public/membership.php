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
    $professional_body = $_POST['professional_body'];
    $membership_type = $_POST['membership_type'];
    $regno = $_POST['regno'];
    $date_renewed = $_POST['date_renewed'];
    $next_renewal = $_POST['next_renewal'];

    $stmt = $conn->prepare("INSERT INTO registration_membership (user_id, professional_body, membership_type, regno, date_renewed, next_renewal)
                            VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $user_id, $professional_body, $membership_type, $regno, $date_renewed, $next_renewal);

    if ($stmt->execute()) {
        $success = "Membership registration added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Membership Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h3>Add Professional Membership</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" id="membership-form" class="row g-3">
         <div class="col-md-2">
            <label>ID Number</label>
            <input type="number" name="user_id"  class="form-control" value="<?= htmlspecialchars($_SESSION['idNo']) ?>" readonly>
        </div>
        <div class="col-md-6">
            <label>Professional Body</label>
            <input type="text" name="professional_body" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Membership Type</label>
            <input type="text" name="membership_type" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Registration Number</label>
            <input type="text" name="regno" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Date Renewed</label>
            <input type="date" name="date_renewed" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Next Renewal</label>
            <input type="date" name="next_renewal" class="form-control">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save Membership</button>
        </div>
    </form>
</body>
</html>
<script src="../js/manageUser.js"></script>