<?php
include '../database/db.php';

if($_SERVER['REQUEST_METHOD']==='POST'){
$application_id=$_POST['application_id'];
$staus=$_POST['status'];



$stmt=$conn->prepare("SELECT * FROM applications WHERE application_id=? ");
$stmt->bind_param("s",$application_id);

if ($stmt->execute())

{
   $stmt = $conn->prepare("UPDATE applications SET status = ? WHERE application_id = ?");
$stmt->bind_param("si", $status, $application_id); // assuming status is a string and application_id is an integer
$stmt->execute();

    
echo "successfully added";
exit;
}
else
    $conn->close();
}
?>




<form action="shortlisting.php" method="POST">
    <input type="number" name="application_id" placeholder="Application ID" required><br>
    <select name="status">
        <option value="shortlisted">Shortlist</option>
        <option value="rejected">Reject</option>
    </select><br>
    <button type="submit">Update Status</button>
</form>
