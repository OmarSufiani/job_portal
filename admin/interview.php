<form action="submit_interview.php" method="POST">
  <h2>Schedule Interview</h2>
  <label>Applicant ID:</label>
  <input type="number" name="applicant_id" required><br>

  <label>Vacancy ID:</label>
  <input type="number" name="vacancy_id" required><br>

  <label>Scheduled Date:</label>
  <input type="datetime-local" name="scheduled_date" required><br>

  <label>Status:</label>
  <select name="status">
    <option value="scheduled">Scheduled</option>
    <option value="completed">Completed</option>
    <option value="cancelled">Cancelled</option>
  </select><br>

  <label>Notes:</label>
  <textarea name="notes"></textarea><br>

  <input type="submit" value="Schedule Interview">
</form>