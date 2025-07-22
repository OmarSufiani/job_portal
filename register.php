<?php
session_start();
include 'database/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idNo = $conn->real_escape_string(trim($_POST['idNo']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $firstName = $conn->real_escape_string(trim($_POST['firstName']));
    $lastName = $conn->real_escape_string(trim($_POST['lastName']));
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $role = 'user'; // default role

    // Validation
    if (empty($idNo) || empty($email) || empty($firstName) || empty($lastName) || empty($password) || empty($confirm)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // Check for duplicate ID number or email
        $check = $conn->prepare("SELECT id FROM users WHERE idNo = ? OR email = ?");
        $check->bind_param("ss", $idNo, $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "ID Number or Email is already registered.";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (id_number, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $id_number, $email, $hashed, $role);
            if ($stmt->execute()) {
                $success = "Registration successful!";
            } else {
                $error = "Error: Unable to register. Please try again.";
            }
            $stmt->close();
        }
        $check->close();
    }

    $conn->close();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register | Bandari Maritime Academy</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            background-color: #f9f9f9;
        }

        .form-container {
            background-color: #fff;
            padding: 40px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #2980b9;
            color: white;
            border: none;
            font-size: 16px;
            border-radius: 6px;
            cursor: pointer;
        }

        button:hover {
            background-color: #3498db;
        }

        .error {
            color: #e74c3c;
            text-align: center;
        }

        .success {
            color: #27ae60;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            color: #2980b9;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>📝 SIGN UP</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($success): ?>
        <p class="success"><?= htmlspecialchars($success) ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="number" name="idNo" placeholder="ID Number" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm" placeholder="Confirm Password" required>
        <button type="submit">Register</button>
    </form>

    <div class="footer">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>

</body>
</html>



