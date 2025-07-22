
<?php
// Include DB
include '../database/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteTitle = $_POST['site_title'];
    $adminEmail = $_POST['admin_email'];

    // Update settings table (if you have one)
    $stmt = $conn->prepare("UPDATE settings SET site_title = ?, admin_email = ? WHERE id = 1");
    $stmt->bind_param("ss", $siteTitle, $adminEmail);
    $stmt->execute();
    echo "✅ Settings updated.";
}
?>



<h2>System Settings</h2>
<form method="POST" id="page-form">
    <label>Site Title:</label>
    <input type="text" name="site_title"  placeholder="Enter site name" required><br><br>

    <label>Admin Email:</label>
    <input type="email" name="admin_email"  placeholder="Enter admin email" required><br><br>

    <button type="submit">Save</button>
</form>
 <script src="../js/manageUser.js"></script>


