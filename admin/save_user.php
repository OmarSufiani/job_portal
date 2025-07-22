<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

ob_start(); // Start output buffering

include '../database/db.php';

$id      = isset($_POST['id']) ? intval($_POST['id']) : 0;
$idNo    = $conn->real_escape_string(trim($_POST['idNo'] ?? ''));
$email   = $conn->real_escape_string(trim($_POST['email'] ?? ''));
$fname   = $conn->real_escape_string(trim($_POST['FirstName'] ?? ''));
$lname   = $conn->real_escape_string(trim($_POST['LastName'] ?? ''));
$role    = $conn->real_escape_string(trim($_POST['role'] ?? '')); // ✅ Added role
$passRaw = $_POST['password'] ?? '';

// Validate input
if (empty($idNo) || empty($email) || empty($fname) || empty($lname) || empty($role)) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields.']);
    exit;
}

if ($id > 0) {
    // ✅ Update existing user
    if (!empty($passRaw)) {
        $hashed = password_hash($passRaw, PASSWORD_BCRYPT);
        $sql = "UPDATE users 
                SET idNo='$idNo', email='$email', FirstName='$fname', LastName='$lname', password='$hashed', role='$role' 
                WHERE id=$id";
    } else {
        $sql = "UPDATE users 
                SET idNo='$idNo', email='$email', FirstName='$fname', LastName='$lname', role='$role' 
                WHERE id=$id";
    }

    if ($conn->query($sql)) {
        ob_clean();
        echo json_encode(['status' => 'success', 'message' => 'User updated successfully.']);
        exit;
    } else {
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'Database update error: ' . $conn->error]);
        exit;
    }

} else {
    // ✅ Create new user
    if (empty($passRaw)) {
        echo json_encode(['status' => 'error', 'message' => 'Password is required for new user.']);
        exit;
    }

    $hashed = password_hash($passRaw, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (idNo, email, FirstName, LastName, password, role) 
            VALUES ('$idNo', '$email', '$fname', '$lname', '$hashed', '$role')";

    if ($conn->query($sql)) {
        ob_clean();
        echo json_encode(['status' => 'success', 'message' => 'New user added successfully.']);
        exit;
    } else {
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'Database insert error: ' . $conn->error]);
        exit;
    }
}
?>
