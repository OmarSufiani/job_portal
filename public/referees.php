<?php
session_start();
include '../database/db.php';

if (!isset($_SESSION['idNo'])) {
    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['idNo'];
$success = $error = '';

// Handle form submission
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

    // Check how many referees this user has
    $countStmt = $conn->prepare("SELECT COUNT(*) FROM referees WHERE user_id = ?");
    $countStmt->bind_param("i", $user_id);
    $countStmt->execute();
    $countStmt->bind_result($referee_count);
    $countStmt->fetch();
    $countStmt->close();

    if ($referee_count >= 3) {
        $error = "You can only add up to 3 referees.";
    } else {
        $stmt = $conn->prepare("INSERT INTO referees (fullname, user_id, email, occupation, postal_code, postal_town, known_period, mobile_number, address)
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sississss", $fullname, $user_id, $email, $occupation, $postal_code, $postal_town, $known_period, $mobile_number, $address);

        if ($stmt->execute()) {
            $success = "Referee added successfully!";
        } else {
            $error = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Fetch existing referees for display
$referees = [];
$result = $conn->prepare("SELECT fullname, email, occupation, postal_code, postal_town, known_period, mobile_number, address FROM referees WHERE user_id = ?");
$result->bind_param("i", $user_id);
$result->execute();
$result->store_result();

if ($result->num_rows > 0) {
    $result->bind_result($fullname, $email, $occupation, $postal_code, $postal_town, $known_period, $mobile_number, $address);
    while ($result->fetch()) {
        $referees[] = [
            'fullname' => $fullname,
            'email' => $email,
            'occupation' => $occupation,
            'postal_code' => $postal_code,
            'postal_town' => $postal_town,
            'known_period' => $known_period,
            'mobile_number' => $mobile_number,
            'address' => $address,
        ];
    }
}
$result->close();
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
        <input type="hidden" name="user_id" value="<?= htmlspecialchars($_SESSION['idNo']) ?>" readonly>

        <div class="col-12">
            <button type="submit" class="btn btn-primary">Save Referee</button>
        </div>
    </form>

    <!-- Display Existing Referees -->
    <?php if (!empty($referees)): ?>
        <hr>
        <h4 class="mt-5">Your Referees</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Occupation</th>
                    <th>Postal Code</th>
                    <th>Postal Town</th>
                    <th>Known Period</th>
                    <th>Mobile Number</th>
                    <th>Address</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($referees as $ref): ?>
                    <tr>
                        <td><?= htmlspecialchars($ref['fullname']) ?></td>
                        <td><?= htmlspecialchars($ref['email']) ?></td>
                        <td><?= htmlspecialchars($ref['occupation']) ?></td>
                        <td><?= htmlspecialchars($ref['postal_code']) ?></td>
                        <td><?= htmlspecialchars($ref['postal_town']) ?></td>
                        <td><?= htmlspecialchars($ref['known_period']) ?></td>
                        <td><?= htmlspecialchars($ref['mobile_number']) ?></td>
                        <td><?= htmlspecialchars($ref['address']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
<script src="../js/manageUser.js"></script>
