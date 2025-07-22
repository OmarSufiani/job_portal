<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../database/db.php';

$query = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<style>
    table.user-table {
        width: 100%;
        border-collapse: collapse;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin-top: 15px;
    }

    .user-table th, .user-table td {
        padding: 12px;
        border: 1px solid #ddd;
        text-align: left;
    }

    .user-table th {
        background-color: teal;
        color: white;
        font-size: 14px;
    }

    .user-table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .user-table tr:hover {
        background-color: #f1f1f1;
    }

    .action-buttons button {
        margin-right: 6px;
        padding: 6px 12px;
        font-size: 13px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .action-buttons .edit-btn {
        background-color: #007bff;
        color: white;
    }

    .action-buttons .edit-btn:hover {
        background-color: #0056b3;
    }

    .action-buttons .delete-btn {
        background-color: #dc3545;
        color: white;
    }

    .action-buttons .delete-btn:hover {
        background-color: #b02a37;
    }

    @media (max-width: 600px) {
        .user-table th, .user-table td {
            font-size: 12px;
            padding: 8px;
        }

        .action-buttons button {
            margin-bottom: 4px;
        }
    }
</style>

<table class="user-table">
    <thead>
        <tr>
            <th>ID</th>
            <th>ID No</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $query->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['idNo']) ?></td>
            <td><?= htmlspecialchars($row['FirstName']) ?></td>
            <td><?= htmlspecialchars($row['LastName']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td class="action-buttons">

                <button  class="edit-btn" onclick="loadEditUserForm(<?= $row['id'] ?>)">Edit</button>

                <button class="delete-btn" onclick="deleteUser(<?= $row['id'] ?>)">Delete</button>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

