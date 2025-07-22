<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<style>
    #user-section {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    #user-section h2 {
        margin-top: 0;
        color: #2c3e50;
        font-size: 24px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    #user-controls {
        margin-bottom: 20px;
        text-align: right;
    }

    #user-controls button {
        background-color: teal;
        color: white;
        padding: 10px 18px;
        font-size: 14px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s;
        margin-left: 10px;
    }

    #user-controls button:hover {
        background-color: #007777;
    }

    #message-box {
        display: none;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 5px;
        font-size: 14px;
    }

    #message-box.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    #message-box.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    #user-content {
        min-height: 100px;
        background-color: #f9f9f9;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    #user-content p {
        margin: 0;
        color: #666;
    }

    @media (max-width: 600px) {
        #user-controls {
            text-align: center;
        }
    }
</style>

<div id="user-section">
    <h2>Manage Users</h2>
    <div id="user-controls">
        <button onclick="loadUsers()">View Users</button>
        <button onclick="loadAddUserForm()">Add User</button>
    </div>

    <div id="message-box"></div>

    <div id="user-content">
        <p>Loading users...</p>
    </div>
</div>

<script>
function showMessage(message, type = 'success') {
    const box = document.getElementById('message-box');
    box.textContent = message;
    box.className = type;
    box.style.display = 'block';
    setTimeout(() => {
        box.style.display = 'none';
    }, 4000);
}


function attachFormHandler() {
    const form = document.getElementById('user-form');
    if (form) {
        form.addEventListener('submit', submitUserForm);
    } else {
        console.warn("No form with ID 'user-form' found.");
    }
}


function loadUsers() {
    console.log("Fetching user list...");
    fetch('users_list.php')
        .then(res => {
            if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
            return res.text();
        })
        .then(html => {
            document.getElementById('user-content').innerHTML = html;
        })
        .catch(err => {
            showMessage("Error loading users: " + err.message, 'error');
        });
}
function submitUserForm(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    fetch('save_user.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showMessage(data.message, 'success');
            loadUsers();
        } else {
            showMessage("Save failed: " + data.message, 'error');
        }
    })
    .catch(err => {
        showMessage("Error saving user: " + err.message, 'error');
    });
}


function loadAddUserForm() {
    console.log("Fetching Add User form...");
    fetch('add_user.php')
        .then(res => res.text())
        .then(html => {
            document.getElementById('user-content').innerHTML = html;
            attachFormHandler();
        })
        .catch(err => {
            showMessage("Error loading form: " + err.message, 'error');
        });
}

function loadEditUserForm(id) {
    console.log(`Fetching Edit User form for ID ${id}...`);
    fetch(`edit_user.php?id=${id}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('user-content').innerHTML = html;
            attachFormHandler();
        })
        .catch(err => {
            showMessage("Error loading form: " + err.message, 'error');
        });
}

function deleteUser(id) {
    if (confirm("Are you sure you want to delete this user?")) {
        console.log(`Deleting user with ID ${id}...`);
        fetch(`delete_user.php?id=${id}`, { method: 'POST' })
            .then(res => {
                if (!res.ok) throw new Error(`HTTP error! status: ${res.status}`);
                return res.text();
            })
            .then(() => {
                showMessage("User deleted successfully.", 'success');
                loadUsers();
            })
            .catch(err => {
                showMessage("Error deleting user: " + err.message, 'error');
            });
    }
}

document.addEventListener('DOMContentLoaded', loadUsers);
</script>
