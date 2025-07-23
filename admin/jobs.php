<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>
<style>
    #job-section {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    #job-section h2 {
        margin-top: 0;
        color: #2c3e50;
        font-size: 24px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    #job-controls {
        margin-bottom: 20px;
        text-align: right;
    }

    #job-controls button {
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

    #job-controls button:hover {
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

    #job-content {
        min-height: 100px;
        background-color: #f9f9f9;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    #job-content p {
        margin: 0;
        color: #666;
    }

    @media (max-width: 600px) {
        #job-controls {
            text-align: center;
        }
    }
</style>

<div id="job-section">
    <h2>Manage Jobs</h2>
    <div id="job-controls">
        <button onclick="loadJobs()">View Jobs</button>
        <button onclick="loadAddJobForm()">Add Job</button>
    </div>

    <div id="message-box"></div>

    <div id="job-content">
        <p>Loading jobs...</p>
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
    const form = document.getElementById('job-form');
    if (form) {
        form.addEventListener('submit', submitJobForm);
    } else {
        console.warn("No form with ID 'job-form' found.");
    }
}

function loadJobs() {
    console.log("Fetching job list...");
    fetch('jobs_list.php')
        .then(res => res.text())
        .then(html => {
            document.getElementById('job-content').innerHTML = html;
        })
        .catch(err => {
            showMessage("Error loading jobs: " + err.message, 'error');
        });
}

function submitJobForm(e) {
    e.preventDefault();
    const form = e.target;
    const formData = new FormData(form);

    fetch('save_job.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            showMessage(data.message, 'success');
            loadJobs();
        } else {
            showMessage("Save failed: " + data.message, 'error');
        }
    })
    .catch(err => {
        showMessage("Error saving job: " + err.message, 'error');
    });
}

function loadAddJobForm() {
    console.log("Fetching Add Job form...");
    fetch('add_job.php')
        .then(res => res.text())
        .then(html => {
            document.getElementById('job-content').innerHTML = html;
            attachFormHandler();
        })
        .catch(err => {
            showMessage("Error loading form: " + err.message, 'error');
        });
}

function loadEditJobForm(id) {
    console.log(`Fetching Edit Job form for ID ${id}...`);
    fetch(`edit_job.php?id=${id}`)
        .then(res => res.text())
        .then(html => {
            document.getElementById('job-content').innerHTML = html;
            attachFormHandler();
        })
        .catch(err => {
            showMessage("Error loading form: " + err.message, 'error');
        });
}

function deleteJob(id) {
    if (confirm("Are you sure you want to delete this job?")) {
        console.log(`Deleting job with ID ${id}...`);
        fetch(`delete_job.php?id=${id}`, { method: 'POST' })
            .then(res => res.text())
            .then(() => {
                showMessage("Job deleted successfully.", 'success');
                loadJobs();
            })
            .catch(err => {
                showMessage("Error deleting job: " + err.message, 'error');
            });
    }
}

document.addEventListener('DOMContentLoaded', loadJobs);
</script>
