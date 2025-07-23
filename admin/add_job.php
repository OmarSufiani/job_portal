<style>
#job-form {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    padding: 20px;
    background: #f9f9f9;
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
    background-color: #28a745;
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

#job-form button:hover {
    background-color: #1e7e34;
}
</style>

<form id="job-form">
    <div class="form-group">
        <label>ID:</label>
        <input type="number" name="id" required>
    </div>

    <div class="form-group">
        <label>Advert No:</label>
        <input type="text" name="AdvertNo" required>
    </div>

    <div class="form-group">
        <label>Position:</label>
        <input type="text" name="position" required>
    </div>

    <div class="form-group">
        <label>Job Scale:</label>
        <input type="text" name="job_scale" required>
    </div>

    <div class="form-group">
        <label>Ministry:</label>
        <input type="text" name="ministry" required>
    </div>

    <div class="form-group">
        <label>No. of Vacancies:</label>
        <input type="number" name="no_vacancies" required>
    </div>

    <div class="form-group">
        <label>Years of Experience:</label>
        <input type="number" name="years_exp" required>
    </div>

    <div class="form-group">
        <label>Advert Category:</label>
        <select name="Advert_category" required>
            <option value="open">Open</option>
            <option value="closed">Closed</option>
        </select>
    </div>

    <div class="form-group">
        <label>Advert Date:</label>
        <input type="date" name="advert_date" required>
    </div>

    <div class="form-group">
        <label>Advert Close Date:</label>
        <input type="date" name="advert_close_date" required>
    </div>

    <div class="form-group" style="flex: 1 1 100%;">
        <label>Description:</label>
        <textarea name="description" rows="5" required></textarea>
    </div>

    <button type="submit">Save Job</button>
</form>
