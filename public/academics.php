<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
include '../database/db.php';

$error = '';
$success = '';

// Ensure the user is logged in
if (!isset($_SESSION['idNo'])) {
    $error = "You must be logged in to submit academic qualifications.";
} else {
    $idno = $_SESSION['idNo'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize inputs
        $instituition_name = trim($_POST['instituition_name'] ?? '');
        $admno = trim($_POST['admno'] ?? '');
        $area_of_study = trim($_POST['area_of_study'] ?? '');
        $specialization = trim($_POST['specialization'] ?? '');
        $award = trim($_POST['award'] ?? '');
        $course = trim($_POST['course'] ?? '');
        $grade = trim($_POST['grade'] ?? '');
        $examiner = trim($_POST['examiner'] ?? '');
        $certificate_no = trim($_POST['certificate_no'] ?? '');
        $start_date = $_POST['start_date'] ?? '';
        $end_date = $_POST['end_date'] ?? '';
        $graduation_date = $_POST['graduation_date'] ?? '';

        // Validate required fields
        if (empty($instituition_name)) {
            $error = "❌ Please fill all required fields.";
        } else {
            $checkSql = "SELECT id FROM academic_qualifications WHERE user_id = ?";
            $checkStmt = $conn->prepare($checkSql);
            $checkStmt->bind_param("i", $idno);
            $checkStmt->execute();
            $checkStmt->store_result();

            if ($checkStmt->num_rows > 0) {
                $error = "❌ You have already submitted academic qualifications.";
            } else {
                $sql = "INSERT INTO academic_qualifications 
                    (user_id, instituition_name, admno, area_of_study, specialization, award, course, grade, examiner, certificate_no, start_date, end_date, graduation_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

                $stmt = $conn->prepare($sql);
                $stmt->bind_param(
                    "issssssssssss",
                    $idno, $instituition_name, $admno, $area_of_study, $specialization, $award, $course,
                    $grade, $examiner, $certificate_no, $start_date, $end_date, $graduation_date
                );

                if ($stmt->execute()) {
                    $success = "✅ Academic qualification submitted successfully.";
                } else {
                    $error = "❌ Error: " . $stmt->error;
                }

                $stmt->close();
            }

            $checkStmt->close();
        }
    }
}
?>


    <style>

             input[readonly] {
                background-color: #f5f5f5;
                color: #555;
            }

      
        .error, .success {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 5px;
            max-width: 500px;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        #academics-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        max-width: 1000px;
        margin: auto;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 10px;
    }

    #academics-form label {
        display: block;
        font-weight: bold;
        margin-bottom: 5px;
    }

    #academics-form input[type="text"],
    #academics-form input[type="date"] {
        width: 100%;
        padding: 8px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    #academics-form input[type="submit"] {
        grid-column: span 2;
        padding: 10px;
        font-weight: bold;
        background-color: #007BFF;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    #academics-form input[type="submit"]:hover {
        background-color: #0056b3;
    }
    </style>
</head>


<h2>Submit Academic Qualifications</h2>

<?php if (!empty($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php elseif (!empty($success)): ?>
    <div class="success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>

<form method="POST" id="academics-form">
    <div>
        <label>ID Number:</label>
        <input type="text" name="idno_display" value="<?= htmlspecialchars($_SESSION['idNo']) ?>" readonly>
    </div>

    <div>
        <label>Institution Name:</label>
        <input type="text" name="instituition_name" required>
    </div>

    <div>
        <label>Admission No:</label>
        <input type="text" name="admno">
    </div>

    <div>
        <label>Area of Study:</label>
        <input type="text" name="area_of_study">
    </div>

    <div>
        <label>Specialization:</label>
        <input type="text" name="specialization">
    </div>

    <div>
        <label>Award:</label>
        <input type="text" name="award">
    </div>

    <div>
        <label>Course:</label>
        <input type="text" name="course">
    </div>

    <div>
        <label>Grade:</label>
        <input type="text" name="grade">
    </div>

    <div>
        <label>Examiner:</label>
        <input type="text" name="examiner">
    </div>

    <div>
        <label>Certificate No:</label>
        <input type="text" name="certificate_no">
    </div>

    <div>
        <label>Start Date:</label>
        <input type="date" name="start_date">
    </div>

    <div>
        <label>End Date:</label>
        <input type="date" name="end_date">
    </div>

    <div>
        <label>Graduation Date:</label>
        <input type="date" name="graduation_date">
    </div>

    <div>
        <input type="submit" value="Submit">
    </div>
</form>

<script src="../js/manageUser.js"></script>
