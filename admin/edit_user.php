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
        max-width: 1000px;
        margin: 20px auto;
        box-sizing: border-box;
    }

    .form-container h3 {
        margin-bottom: 20px;
        color: #2c3e50;
    }

    #user-form {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        flex: 1 1 300px;
    }

    .form-group label {
        font-weight: 600;
        color: #333;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 14px;
        box-sizing: border-box;
    }

    button[type="submit"] {
        background-color: teal;
        color: white;
        border: none;
        padding: 12px 22px;
        font-size: 16px;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 10px;
    }

    button[type="submit"]:hover {
        background-color: #007777;
    }

    @media (max-width: 600px) {
        .form-group {
            flex: 1 1 100%;
        }
    }
</style>

<div class="form-container">
    <h3>Edit User</h3>
    <form id="user-form" method="POST">

        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

        <div class="form-group">
            <label>ID No:</label>
            <input type="number" name="idNo" value="<?= htmlspecialchars($user['idNo']) ?>" required>
        </div>

        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="form-group">
            <label>First Name:</label>
            <input type="text" name="FirstName" value="<?= htmlspecialchars($user['FirstName']) ?>" required>
        </div>

        <div class="form-group">
            <label>Last Name:</label>
            <input type="text" name="LastName" value="<?= htmlspecialchars($user['LastName']) ?>" required>
        </div>

        <div class="form-group">
            <label>New Password:</label>
            <input type="password" name="password" placeholder="Leave blank to keep current">
        </div>

        <div class="form-group">
            <label>Role:</label>
            <select name="role" required>
                <option value="">-- Select Role --</option>
                <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
            </select>
        </div>

        <div class="form-group" style="flex: 1 1 100%;">
            <button type="submit">Update</button>
        </div>
    </form>
</div>
