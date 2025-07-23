<?php
include '../database/db.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM jobs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()):
?>

<style>
#job-form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
    background: #fff;
    border: 1px solid #ccc;
    max-width: 100%;
    box-sizing: border-box;
    font-family: Arial, sans-serif;
}

#job-form .form-group {
    display: flex;
    flex-direction: column;
    min-width: 250px;
    flex: 1 1 300px;
}

#job-form label {
    font-weight: bold;
    margin-bottom: 5px;
}

#job-form input,
#job-form select,
#job-form textarea {
    padding: 8px;
    border: 1px solid #aaa;
    border-radius: 4px;
    font-size: 14px;
}

#job-form textarea {
    resize: vertical;
}

#job-form button {
    margin-top: 20px;
    padding: 10px 20px;
    background-color: #007BFF;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#job-form button:hover {
    background-color: #0056b3;
}
</style>

<form id="job-form">
    <div class="form-group">
        <label>ID:</label>
        <input type="number" name="id" value="<?= $row['id'] ?>" required>
    </div>

    <div class="form-group">
        <label>Advert No:</label>
        <input type="text" name="AdvertNo" value="<?= htmlspecialchars($row['AdvertNo']) ?>" required>
    </div>

    <div class="form-group">
        <label>Position:</label>
        <input type="text" name="position" value="<?= htmlspecialchars($row['position']) ?>" required>
    </div>

    <div class="form-group">
        <label>Job Scale:</label>
        <input type="text" name="job_scale" value="<?= htmlspecialchars($row['job_scale']) ?>" required>
    </div>

    <div class="form-group">
        <label>Ministry:</label>
        <input type="text" name="ministry" value="<?= htmlspecialchars($row['ministry']) ?>" required>
    </div>

    <div class="form-group">
        <label>No. of Vacancies:</label>
        <input type="number" name="no_vacancies" value="<?= $row['no_vacancies'] ?>" required>
    </div>

    <div class="form-group">
        <label>Years of Experience:</label>
        <input type="number" name="years_exp" value="<?= $row['years_exp'] ?>" required>
    </div>

    <div class="form-group">
        <label>Advert Category:</label>
        <select name="Advert_category" required>
            <option value="open" <?= $row['Advert_category'] == 'open' ? 'selected' : '' ?>>Open</option>
            <option value="closed" <?= $row['Advert_category'] == 'closed' ? 'selected' : '' ?>>Closed</option>
        </select>
    </div>

    <div class="form-group">
        <label>Advert Date:</label>
        <input type="date" name="advert_date" value="<?= $row['advert_date'] ?>" required>
    </div>

    <div class="form-group">
        <label>Advert Close Date:</label>
        <input type="date" name="advert_close_date" value="<?= $row['advert_close_date'] ?>" required>
    </div>

    <div class="form-group" style="flex: 1 1 100%;">
        <label>Description:</label>
        <textarea name="description" rows="5" required><?= htmlspecialchars($row['description']) ?></textarea>
    </div>

    <button type="submit">Update Job</button>
</form>

<?php else: ?>
<p>Job not found.</p>
<?php endif; $conn->close(); ?>
