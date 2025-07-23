<?php
include '../database/db.php';

$sql = "SELECT id, AdvertNo, position, job_scale, ministry, no_vacancies, years_exp, Advert_category, advert_date, advert_close_date 
        FROM jobs ORDER BY advert_date DESC";
$result = $conn->query($sql);

// CSS
echo "
<style>
#job-content {
    max-width: 100%;
    overflow-x: auto;
    padding: 10px;
    box-sizing: border-box;
}

#job-content table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    font-size: 15px;
    background: #fff;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

#job-content th, #job-content td {
    padding: 10px 12px;
    border: 1px solid #ccc;
    text-align: left;
    white-space: nowrap;
}

#job-content th {
    background-color: #f2f2f2;
    font-weight: bold;
}

#job-content tr:nth-child(even) {
    background-color: #f9f9f9;
}

#job-content button {
    padding: 6px 10px;
    margin: 0 2px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
}

#job-content button:hover {
    opacity: 0.9;
}

#job-content button:first-child {
    background-color: #4CAF50; /* Edit */
    color: white;
}

#job-content button:last-child {
    background-color: #f44336; /* Delete */
    color: white;
}
</style>

<div id='job-content'>
";

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Advert No</th>
            <th>Position</th>
            <th>Job Scale</th>
            <th>Ministry</th>
            <th>Vacancies</th>
            <th>Experience</th>
            <th>Advert Date</th>
            <th>Deadline</th>
            <th>Actions</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['AdvertNo']}</td>
                <td>{$row['position']}</td>
                <td>{$row['job_scale']}</td>
                <td>{$row['ministry']}</td>
                <td>{$row['no_vacancies']}</td>
                <td>{$row['years_exp']} yrs</td>
                <td>{$row['advert_date']}</td>
                <td>{$row['advert_close_date']}</td>
                <td>
                    <button onclick='loadEditJobForm({$row['id']})'>Edit</button>
                    <button onclick='deleteJob({$row['id']})'>Delete</button>
                </td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No job listings found.</p>";
}

echo "</div>";

$conn->close();
?>
