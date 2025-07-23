<?php
session_start();
include '../database/db.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Bandari Maritime Academy</title>
    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Segoe UI', sans-serif;
        }

        .page-wrapper {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        .header {
            height: 100px;
            background-color: rgb(4, 99, 194);
            color: white;
            padding: 30px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
        }

        .header h1 {
            font-size: 26px;
            margin: 0;
        }

        .user-info {
            font-size: 16px;
        }

        .user-info a {
            color: #ecf0f1;
            text-decoration: none;
        }

        .dashboard-container {
            display: flex;
            flex: 1;
            margin-top: 100px; /* below header */
        }

        /* Sidebar */
        .sidebar {
            width: 240px;
            background-color: teal;
            color: white;
            height: calc(100vh - 100px);
            overflow-y: auto;
            padding-top: 20px;
            position: fixed;
            top: 100px;
            left: 0;
        }

        .sidebar a {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: background 0.2s;
        }

        .sidebar a:hover {
            background-color: grey;
        }

        .dropbtn {
            background-color: teal;
            color: white;
            border: none;
            outline: none;
            width: 100%;
            text-align: left;
            padding: 15px 20px;
            cursor: pointer;
            font-family: 'Segoe UI', sans-serif;
            font-size: 16px;
            transition: background 0.2s;
        }

        .dropbtn:hover {
            background-color: grey;
        }

        .dropdown-content {
            display: none;
            flex-direction: column;
            background-color: teal;
        }

        .dropdown-content a {
            padding: 12px 20px;
            text-decoration: none;
            color: #ecf0f1;
            transition: background 0.2s;
        }

        .dropdown-content a:hover {
            background-color: grey;
        }

        .dropdown.active .dropdown-content {
            display: flex;
        }

        /* Main content */
        .main-content {
            margin-left: 240px;
            padding: 30px;
            flex: 1;
            overflow-y: auto;
            max-height: calc(100vh - 100px);
        }

        /* Footer */
      

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>
</head>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="../js/manageUser.js"></script>
<body>
<div class="page-wrapper">
    <!-- Header -->
    <div class="header">
        <img src="../uploads/bandari.png" alt="Logo" style="height: 100px; width: auto;" />
        <h1>BANDARI MARITIME ACADEMY-ADMINS</h1>
        <div class="user-info">
                    <p>Amin: <?= isset($_SESSION['FirstName']) ? htmlspecialchars($_SESSION['FirstName']) : 'Guest' ?> | 🔒 <a href="../includes/logout.php">Logout</a></p>
          
        </div>
    </div>

    <!-- Dashboard -->
    <div class="dashboard-container">
        <!-- Sidebar -->

<div class="sidebar">
    <a href="#" onclick="loadPage('dashboard.php')">🏠 Dashboard</a>
    <a href="#" onclick="loadPage('manage_users.php')">⚙️ Manage Users</a>
    <a href="#" onclick="loadPage('post_job.php')">📋 Post Jobs</a>
    <a href="#" onclick="loadPage('apply_intern.php')">🎓 Post Internships</a>
    <a href="#" onclick="loadPage('status.php')">📈 View Applications</a>
    <a href="#" onclick="loadPage('jobs.php')">📢 Vacancies</a>
    <a href="#" onclick="loadPage('interview.php')">🗓️ Interview</a>
    <a href="#" onclick="loadPage('shortlisting.php')">✅ Shortlisting</a>
    <a href="#" onclick="loadPage('selection.php')">🎯 Selection</a>
    <a href="#" onclick="loadPage('page.php')">⚙️ Settings</a>
    
</div>


 


     
     <div class="main-content" id="main-content">

       <div id="message-box"></div>

<p>Welcome to this admin dashboard</p>



<?php


// Count Users
$totalUsers = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

// Count Admins
$totalAdmins = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'admin'")->fetch_assoc()['count'];

// Count Applicants (users who applied)
$totalApplicants = $conn->query("SELECT COUNT(DISTINCT user_id) as count FROM status")->fetch_assoc()['count'];

// Count Jobs Available
$availableJobs = $conn->query("SELECT COUNT(*) as count FROM jobs WHERE advert_close_date >= CURDATE()")->fetch_assoc()['count'];

// Count Total Applications
$totalApplications = $conn->query("SELECT COUNT(*) as count FROM status")->fetch_assoc()['count'];

// Nearest Job Deadline
$deadlineRes = $conn->query("SELECT advert_close_date FROM jobs WHERE advert_close_date >= CURDATE() ORDER BY advert_close_date ASC LIMIT 1");
$nextDeadline = $deadlineRes->num_rows > 0 ? $deadlineRes->fetch_assoc()['advert_close_date'] : null;
?>

<div class="row g-4">
    <div class="col-md-4">
        <div class="card text-bg-primary">
            <div class="card-body">
                <h5 class="card-title">👤 Users</h5>
                <p class="card-text fs-4"><?= $totalUsers ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-success">
            <div class="card-body">
                <h5 class="card-title">🧑‍💼 Admins</h5>
                <p class="card-text fs-4"><?= $totalAdmins ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-info">
            <div class="card-body">
                <h5 class="card-title">📨 Applicants</h5>
                <p class="card-text fs-4"><?= $totalApplicants ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-warning">
            <div class="card-body">
                <h5 class="card-title">📢 Jobs Available</h5>
                <p class="card-text fs-4"><?= $availableJobs ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-secondary">
            <div class="card-body">
                <h5 class="card-title">📌 Jobs Applied</h5>
                <p class="card-text fs-4"><?= $totalApplications ?></p>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-bg-danger">
            <div class="card-body">
                <h5 class="card-title">⏳ Countdown to Deadline</h5>
                <?php if ($nextDeadline): ?>
                    <p class="card-text fs-5" id="countdown">Loading...</p>
                    <script>
                        const deadline = new Date("<?= $nextDeadline ?>T23:59:59").getTime();

                        const countdownInterval = setInterval(() => {
                            const now = new Date().getTime();
                            const distance = deadline - now;

                            if (distance < 0) {
                                clearInterval(countdownInterval);
                                document.getElementById("countdown").innerText = "Closed";
                                return;
                            }

                            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));

                            document.getElementById("countdown").innerText = `${days}d : ${hours}h : ${minutes}m`;
                        }, 1000);
                    </script>
                <?php else: ?>
                    <p class="card-text">No Open Jobs</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

        </div>

    

    </div> 

</div>

<!-- JavaScript -->


</body>
</html>
<script src="../js/manageUser.js"></script>