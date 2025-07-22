<?php
include '../database/db.php';
session_start();

$success = '';
$error = '';

// Make sure the user is logged in


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'] ?? '';
    $salutation = $_POST['salutation'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $secondname = $_POST['secondname'] ?? '';
    $dob = $_POST['dob'] ?? null;
    $gender = $_POST['gender'] ?? '';
    $kra_pin = $_POST['kra_pin'] ?? '';
    $disability_status = $_POST['disability_status'] ?? '';
    $disability_details = $_POST['disability_details'] ?? '';
    $regno_disability = $_POST['regno_disability'] ?? '';
    $home_county = $_POST['home_county'] ?? '';
    $constituency = $_POST['constituency'] ?? '';
    $subcounty = $_POST['subcounty'] ?? '';
    $ward = $_POST['ward'] ?? '';
    $postall_adress = $_POST['postall_adress'] ?? '';
    $postalcode = $_POST['postalcode'] ?? '';
    $town = $_POST['town'] ?? '';
    $mobile_number = $_POST['mobile_number'] ?? '';
    $email = $_POST['email'] ?? '';
    $contact_person = $_POST['contact_person'] ?? '';
    $contact_person_no = $_POST['contact_person_no'] ?? '';
    $current_employer = $_POST['current_employer'] ?? '';
    $position_held = $_POST['position_held'] ?? '';
    $effective_date = $_POST['effective_date'] ?? null;

    $stmt = $conn->prepare("INSERT INTO personal_info (
        user_id, salutation, lastname, firstname, secondname, dob, gender, kra_pin,
        disability_status, disability_details, regno_disability, home_county, constituency,
        subcounty, ward, postall_adress, postalcode, town, mobile_number, email,
        contact_person, contact_person_no, current_employer, position_held, effective_date
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param("issssssssssssssssssssssss",
        $user_id, $salutation, $lastname, $firstname, $secondname, $dob, $gender, $kra_pin,
        $disability_status, $disability_details, $regno_disability, $home_county, $constituency,
        $subcounty, $ward, $postall_adress, $postalcode, $town, $mobile_number, $email,
        $contact_person, $contact_person_no, $current_employer, $position_held, $effective_date
    );

    if ($stmt->execute()) {
        $success = "Personal information saved successfully.";
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Personal Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>Personal Information Form</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST"  id="personal-form" class="row g-3">
        <div class="col-md-2">
            <label>ID Number</label>
            <input type="number" name="user_id"  class="form-control" value="<?= htmlspecialchars($_SESSION['idNo']) ?>" readonly>
        </div>

        <div class="col-md-2">
            <label>Salutation</label>
            <select name="salutation" class="form-select">
                <option value="Mr.">Mr.</option>
                <option value="Ms.">Ms.</option>
                <option value="Mrs.">Mrs.</option>
            </select>
        </div>

        <div class="col-md-3"><label>First Name</label><input type="text" name="firstname" class="form-control" required></div>
        <div class="col-md-3"><label>Second Name</label><input type="text" name="secondname" class="form-control"></div>
        <div class="col-md-3"><label>Last Name</label><input type="text" name="lastname" class="form-control" required></div>
        <div class="col-md-3"><label>Date of Birth</label><input type="date" name="dob" class="form-control"></div>

        <div class="col-md-2">
            <label>Gender</label>
            <select name="gender" class="form-select">
                <option value="">-- Select --</option>
                <option>Male</option>
                <option>Female</option>
                <option>Other</option>
            </select>
        </div>

        <div class="col-md-3"><label>KRA PIN</label><input type="text" name="kra_pin" class="form-control"></div>
        <div class="col-md-2">
            <label>Disability</label>
            <select name="disability_status" class="form-select">
                <option value="">-- Select --</option>
                <option>Yes</option>
                <option>No</option>
            </select>
        </div>

        <div class="col-md-5"><label>Disability Details</label><input type="text" name="disability_details" class="form-control"></div>
        <div class="col-md-4"><label>Disability Reg No.</label><input type="text" name="regno_disability" class="form-control"></div>

        <div class="col-md-3"><label>Home County</label><input type="text" name="home_county" class="form-control"></div>
        <div class="col-md-3"><label>Constituency</label><input type="text" name="constituency" class="form-control"></div>
        <div class="col-md-3"><label>Subcounty</label><input type="text" name="subcounty" class="form-control"></div>
        <div class="col-md-3"><label>Ward</label><input type="text" name="ward" class="form-control"></div>

        <div class="col-md-6"><label>Postal Address</label><input type="text" name="postall_adress" class="form-control"></div>
        <div class="col-md-2"><label>Postal Code</label><input type="text" name="postalcode" class="form-control"></div>
        <div class="col-md-4"><label>Town</label><input type="text" name="town" class="form-control"></div>

        <div class="col-md-4"><label>Mobile Number</label><input type="text" name="mobile_number" class="form-control"></div>
        <div class="col-md-4"><label>Email</label><input type="email" name="email" class="form-control"></div>

        <div class="col-md-4"><label>Contact Person</label><input type="text" name="contact_person" class="form-control"></div>
        <div class="col-md-4"><label>Contact Person Number</label><input type="text" name="contact_person_no" class="form-control"></div>

        <div class="col-md-4"><label>Current Employer</label><input type="text" name="current_employer" class="form-control"></div>
        <div class="col-md-4"><label>Position Held</label><input type="text" name="position_held" class="form-control"></div>
        <div class="col-md-4"><label>Effective Date</label><input type="date" name="effective_date" class="form-control"></div>

        <div class="col-12 mt-3">
            <button type="submit" class="btn btn-primary">Submit Personal Info</button>
        </div>
    </form>
</body>
</html>
<script src="../js/manageUser.js"></script>