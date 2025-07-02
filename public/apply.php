<form action="submit_application.php" method="POST" enctype="multipart/form-data">
<input type="hidden" name="job_id" value="<?= $_GET['job_id'] ?>">
<input type="text" name="fullname" required placeholder="Full Name">
<input type="email" name="email" required>
<input type="file" name="cv" required>
<button type="submit">Submit Application</button>
</form>