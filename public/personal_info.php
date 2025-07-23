<?php
include '../database/db.php';
session_start();

$success = '';
$error = '';
$user_id = $_SESSION['idNo'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && $user_id) {
    // Prepare form data
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

    // Check if record exists
    $check = $conn->prepare("SELECT id FROM personal_info WHERE user_id = ?");
    $check->bind_param("i", $user_id);  // fixed to 'i'
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        // Update
        $stmt = $conn->prepare("UPDATE personal_info SET 
            salutation=?, lastname=?, firstname=?, secondname=?, dob=?, gender=?, kra_pin=?,
            disability_status=?, disability_details=?, regno_disability=?, home_county=?, constituency=?,
            subcounty=?, ward=?, postall_adress=?, postalcode=?, town=?, mobile_number=?, email=?,
            contact_person=?, contact_person_no=?, current_employer=?, position_held=?, effective_date=?
            WHERE user_id=?
        ");

        $stmt->bind_param("ssssssssssssssssssssssssi", 
            $salutation, $lastname, $firstname, $secondname, $dob, $gender, $kra_pin,
            $disability_status, $disability_details, $regno_disability, $home_county, $constituency,
            $subcounty, $ward, $postall_adress, $postalcode, $town, $mobile_number, $email,
            $contact_person, $contact_person_no, $current_employer, $position_held, $effective_date,
            $user_id
        );

        if ($stmt->execute()) {
            $success = "Personal information updated successfully.";
        } else {
            $error = "Update failed: " . $stmt->error;
        }
    } else {
        // Insert
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
}

// Fetch personal info to show snapshot if it exists
$personalInfo = null;
if ($user_id) {
    $result = $conn->prepare("SELECT * FROM personal_info WHERE user_id = ?");
    $result->bind_param("i", $user_id);  // fixed to 'i'
    $result->execute();
    $res = $result->get_result();
    $personalInfo = $res->fetch_assoc();
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

   <form method="POST" id="personal-form" class="row g-3">
    <div class="col-md-2">
        <label>ID Number</label>
        <input type="number" name="user_id" class="form-control" value="<?= htmlspecialchars($user_id) ?>" readonly>
    </div>

    <div class="col-md-2">
        <label>Salutation</label>
        <select name="salutation" class="form-select">
            <option value="Mr." <?= (isset($personalInfo['salutation']) && $personalInfo['salutation'] === 'Mr.') ? 'selected' : '' ?>>Mr.</option>
            <option value="Ms." <?= (isset($personalInfo['salutation']) && $personalInfo['salutation'] === 'Ms.') ? 'selected' : '' ?>>Ms.</option>
            <option value="Mrs." <?= (isset($personalInfo['salutation']) && $personalInfo['salutation'] === 'Mrs.') ? 'selected' : '' ?>>Mrs.</option>
        </select>
    </div>

    <div class="col-md-3"><label>First Name</label><input type="text" name="firstname" class="form-control" value="<?= htmlspecialchars($personalInfo['firstname'] ?? '') ?>" required></div>
    <div class="col-md-3"><label>Second Name</label><input type="text" name="secondname" class="form-control" value="<?= htmlspecialchars($personalInfo['secondname'] ?? '') ?>"></div>
    <div class="col-md-3"><label>Last Name</label><input type="text" name="lastname" class="form-control" value="<?= htmlspecialchars($personalInfo['lastname'] ?? '') ?>" required></div>
    <div class="col-md-3"><label>Date of Birth</label><input type="date" name="dob" class="form-control" value="<?= htmlspecialchars($personalInfo['dob'] ?? '') ?>"></div>

    <div class="col-md-2">
        <label>Gender</label>
        <select name="gender" class="form-select">
            <option value="">-- Select --</option>
            <option <?= (isset($personalInfo['gender']) && $personalInfo['gender'] === 'Male') ? 'selected' : '' ?>>Male</option>
            <option <?= (isset($personalInfo['gender']) && $personalInfo['gender'] === 'Female') ? 'selected' : '' ?>>Female</option>
            <option <?= (isset($personalInfo['gender']) && $personalInfo['gender'] === 'Other') ? 'selected' : '' ?>>Other</option>
        </select>
    </div>

    <div class="col-md-3"><label>KRA PIN</label><input type="text" name="kra_pin" class="form-control" value="<?= htmlspecialchars($personalInfo['kra_pin'] ?? '') ?>"></div>
    <div class="col-md-2">
        <label>Disability</label>
        <select name="disability_status" class="form-select">
            <option value="">-- Select --</option>
            <option value="Yes" <?= (isset($personalInfo['disability_status']) && $personalInfo['disability_status'] === 'Yes') ? 'selected' : '' ?>>Yes</option>
            <option value="No" <?= (isset($personalInfo['disability_status']) && $personalInfo['disability_status'] === 'No') ? 'selected' : '' ?>>No</option>
        </select>
    </div>

    <div class="col-md-5"><label>Disability Details</label><input type="text" name="disability_details" class="form-control" value="<?= htmlspecialchars($personalInfo['disability_details'] ?? '') ?>"></div>
    <div class="col-md-4"><label>Disability Reg No.</label><input type="text" name="regno_disability" class="form-control" value="<?= htmlspecialchars($personalInfo['regno_disability'] ?? '') ?>"></div>

    <div class="col-md-3"><label>Home County</label><input type="text" name="home_county" class="form-control" value="<?= htmlspecialchars($personalInfo['home_county'] ?? '') ?>"></div>
    <div class="col-md-3"><label>Constituency</label><input type="text" name="constituency" class="form-control" value="<?= htmlspecialchars($personalInfo['constituency'] ?? '') ?>"></div>
    <div class="col-md-3"><label>Subcounty</label><input type="text" name="subcounty" class="form-control" value="<?= htmlspecialchars($personalInfo['subcounty'] ?? '') ?>"></div>
    <div class="col-md-3"><label>Ward</label><input type="text" name="ward" class="form-control" value="<?= htmlspecialchars($personalInfo['ward'] ?? '') ?>"></div>

    <div class="col-md-6"><label>Postal Address</label><input type="text" name="postall_adress" class="form-control" value="<?= htmlspecialchars($personalInfo['postall_adress'] ?? '') ?>"></div>
    <div class="col-md-2"><label>Postal Code</label><input type="text" name="postalcode" class="form-control" value="<?= htmlspecialchars($personalInfo['postalcode'] ?? '') ?>"></div>
    <div class="col-md-4"><label>Town</label><input type="text" name="town" class="form-control" value="<?= htmlspecialchars($personalInfo['town'] ?? '') ?>"></div>

    <div class="col-md-4"><label>Mobile Number</label><input type="text" name="mobile_number" class="form-control" value="<?= htmlspecialchars($personalInfo['mobile_number'] ?? '') ?>"></div>
    <div class="col-md-4"><label>Email</label><input type="email" name="email" class="form-control" value="<?= htmlspecialchars($personalInfo['email'] ?? '') ?>"></div>

    <div class="col-md-4"><label>Contact Person</label><input type="text" name="contact_person" class="form-control" value="<?= htmlspecialchars($personalInfo['contact_person'] ?? '') ?>"></div>
    <div class="col-md-4"><label>Contact Person Number</label><input type="text" name="contact_person_no" class="form-control" value="<?= htmlspecialchars($personalInfo['contact_person_no'] ?? '') ?>"></div>

    <div class="col-md-4"><label>Current Employer</label><input type="text" name="current_employer" class="form-control" value="<?= htmlspecialchars($personalInfo['current_employer'] ?? '') ?>"></div>
    <div class="col-md-4"><label>Position Held</label><input type="text" name="position_held" class="form-control" value="<?= htmlspecialchars($personalInfo['position_held'] ?? '') ?>"></div>
    <div class="col-md-4"><label>Effective Date</label><input type="date" name="effective_date" class="form-control" value="<?= htmlspecialchars($personalInfo['effective_date'] ?? '') ?>"></div>

    <div class="col-12 mt-3">
        <button type="submit" class="btn btn-primary">Submit Personal Info</button>
    </div>
</form>


</body>
</html>

<script src="../js/manageUser.js"></script>
