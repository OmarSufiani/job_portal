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
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $occupation = $_POST['occupation'];
    $postal_code = $_POST['postal_code'];
    $postal_town = $_POST['postal_town'];
    $known_period = $_POST['known_period'];
    $mobile_number = $_POST['mobile_number'];
    $address = $_POST['address'];

    $stmt = $conn->prepare("INSERT INTO referees (fullname, user_id, email, occupation, postal_code, postal_town, known_period, mobile_number, address)
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sississss", $fullname, $user_id, $email, $occupation, $postal_code, $postal_town, $known_period, $mobile_number, $address);

    if ($stmt->execute()) {
        $success = "Referee added successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Referee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h3>Add Referee</h3>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" id="referees-form" class="row g-3">
          <div class="col-md-2">
            <label>ID Number</label>
            <input type="number" name="user_id"  class="form-control" value="<?= htmlspecialchars($_SESSION['idNo']) ?>" readonly>
        </div>
        <div class="col-md-6">
            <label>Full Name</label>
            <input type="text" name="fullname" class="form-control" required>
        </div>
        <div class="col-md-6">
            <label>Email</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Occupation</label>
            <input type="text" name="occupation" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Postal Code</label>
            <input type="number" name="postal_code" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Postal Town</label>
            <input type="text" name="postal_town" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Known Period (Years)</label>
            <input type="number" name="known_period" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Mobile Number</label>
            <input type="text" name="mobile_number" class="form-control">
        </div>
        <div class="col-md-6">
            <label>Address</label>
            <input type="text" name="address" class="form-control">
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save Referee</button>
        </div>
    </form>
</body>
</html>
<script src="../js/manageUser.js"></script>