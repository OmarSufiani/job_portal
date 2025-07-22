<?php
include '../database/db.php';
$id = $conn->real_escape_string($_GET['id']);
$res = $conn->query("SELECT * FROM users WHERE id = $id");
$user = $res->fetch_assoc();
?>

<style>
    .form-container {
        background-color: #ffffff;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 500px;
        margin: 0 auto;
    }

    .form-container label {
        display: block;
        margin-bottom: 15px;
        font-size: 14px;
        color: #333;
    }

    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container input[type="password"],
    .form-container input[type="number"],
    .form-container select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
    }

    .form-container button {
        background-color: teal;
        color: white;
        padding: 10px 16px;
        border: none;
        border-radius: 6px;
        font-size: 14px;
        cursor: pointer;
        margin-top: 10px;
        transition: background 0.3s ease;
    }

    .form-container button:hover {
        background-color: #007777;
    }

    @media (max-width: 600px) {
        .form-container {
            padding: 15px;
        }
    }
</style>

<div class="form-container">
    <h3>Edit User</h3>
    <form id="user-form" method="POST">

        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <label>ID No:
            <input type="number" name="idNo" value="<?= htmlspecialchars($user['idNo']) ?>" required>
        </label>

        <label>Email:
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </label>

        <label>First Name:
            <input type="text" name="FirstName" value="<?= htmlspecialchars($user['FirstName']) ?>" required>
        </label>

        <label>Last Name:
            <input type="text" name="LastName" value="<?= htmlspecialchars($user['LastName']) ?>" required>
        </label>

        <label>New Password:
            <input type="password" name="password" placeholder="Leave blank to keep current">
        </label>

        <label>Role:
            <select name="role" required>
                <option value="">-- Select Role --</option>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </label>

        <button type="submit">Update</button>
    </form>
</div>
