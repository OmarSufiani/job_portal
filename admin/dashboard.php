<<<<<<< HEAD
<?php
session_start();

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
    <a href="#" onclick="loadPage('vacancies.php')">📢 Vacancies</a>
    <a href="#" onclick="loadPage('interview.php')">🗓️ Interview</a>
    <a href="#" onclick="loadPage('shortlisting.php')">✅ Shortlisting</a>
    <a href="#" onclick="loadPage('selection.php')">🎯 Selection</a>
    <a href="#" onclick="loadPage('page.php')">⚙️ Settings</a>
    
</div>


 


     
     <div class="main-content" id="main-content">

       <div id="message-box"></div>

<p>Welcome to this admin dashboard</p>

        </div>

    

    </div> 

</div>

<!-- JavaScript -->


</body>
</html>
=======
<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

$username = isset($_SESSION['id_number']) ? $_SESSION['id_number'] : 'User';
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'User';
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
        footer {
            background-color: #f1f1f1;
            padding: 15px 20px;
            text-align: center;
            font-size: 14px;
            color: #444;
            border-top: 1px solid #ccc;
        }

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
<body>
<div class="page-wrapper">
    <!-- Header -->
    <div class="header">
        <img src="../uploads/bandari.png" alt="Logo" style="height: 100px; width: auto;" />
        <h1>BANDARI MARITIME ACADEMY-ADMINS</h1>
        <div class="user-info">
            Admin: <strong><?= htmlspecialchars($username) ?></strong> |
            <a href="../includes/logout.php">🔒 Logout</a>
        </div>
    </div>

    <!-- Dashboard -->
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="#" onclick="loadPage('dashboard.php')">🏠 Dashboard</a>
            <a href="#" onclick="loadPage('advertised_jobs.php')">📋 Post Jobs</a>
            <a href="#" onclick="loadPage('apply_job.php')">🎓 Post Internships</a>
            <a href="#" onclick="loadPage('status.php')">📈 View Applications</a>
            <a href="#" onclick="loadPage('settings.php')">⚙️ Settings</a>

        </div>

        <!-- Main Content -->
        <div class="main-content" id="mainContent">
            <h2>Welcome to your Dashboard</h2>
            <p>This is your main content area.</p>
        </div>
    </div>

    <!-- Footer -->
    <?php include '../includes/footer.php'; ?>
</div>

<script>
    function toggleDropdown() {
        document.getElementById("profileDropdown").classList.toggle("active");
    }

    // Close dropdown if clicked outside
    window.onclick = function(event) {
        if (!event.target.matches('.dropbtn')) {
            const dropdown = document.getElementById("profileDropdown");
            if (dropdown.classList.contains('active')) {
                dropdown.classList.remove('active');
            }
        }
    }

    function loadPage(pageUrl) {
        const content = document.getElementById('mainContent');
        content.innerHTML = "<p>Loading...</p>";
        fetch(pageUrl)
            .then(response => response.text())
            .then(html => {
                content.innerHTML = html;
            })
            .catch(error => {
                content.innerHTML = "<p>Error loading content.</p>";
                console.error(error);
            });
    }
</script>

</body>
</html>
>>>>>>> 45a39b43c00407c36fae2a72151ba9a8e7f8caf6
