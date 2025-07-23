<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

ob_start(); // Start output buffering

include '../database/db.php';

// Capture and sanitize inputs
$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$AdvertNo = $conn->real_escape_string(trim($_POST['AdvertNo'] ?? ''));
$position = $conn->real_escape_string(trim($_POST['position'] ?? ''));
$job_scale = $conn->real_escape_string(trim($_POST['job_scale'] ?? ''));
$ministry = $conn->real_escape_string(trim($_POST['ministry'] ?? ''));
$no_vacancies = intval($_POST['no_vacancies'] ?? 0);
$years_exp = intval($_POST['years_exp'] ?? 0);
$Advert_category = $conn->real_escape_string(trim($_POST['Advert_category'] ?? ''));
$advert_date = $conn->real_escape_string(trim($_POST['advert_date'] ?? ''));
$advert_close_date = $conn->real_escape_string(trim($_POST['advert_close_date'] ?? ''));
$description = $conn->real_escape_string(trim($_POST['description'] ?? ''));

// Validation
if (empty($AdvertNo) || empty($position) || empty($job_scale) || empty($ministry) || 
    empty($Advert_category) || empty($advert_date) || empty($advert_close_date)) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill all required fields.']);
    exit;
}

// UPDATE
if ($id > 0) {
    $sql = "UPDATE jobs SET 
        AdvertNo='$AdvertNo',
        position='$position',
        job_scale='$job_scale',
        ministry='$ministry',
        no_vacancies=$no_vacancies,
        years_exp=$years_exp,
        Advert_category='$Advert_category',
        advert_date='$advert_date',
        advert_close_date='$advert_close_date',
        description='$description'
        WHERE id=$id";

    if ($conn->query($sql)) {
        ob_clean();
        echo json_encode(['status' => 'success', 'message' => 'Job updated successfully.']);
        exit;
    } else {
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'Update error: ' . $conn->error]);
        exit;
    }

// INSERT
} else {
    $sql = "INSERT INTO jobs (
        AdvertNo, position, job_scale, ministry, no_vacancies, years_exp, Advert_category, advert_date, advert_close_date, description
    ) VALUES (
        '$AdvertNo', '$position', '$job_scale', '$ministry', $no_vacancies, $years_exp, '$Advert_category', '$advert_date', '$advert_close_date', '$description'
    )";

    if ($conn->query($sql)) {
        ob_clean();
        echo json_encode(['status' => 'success', 'message' => 'New job added successfully.']);
        exit;
    } else {
        ob_clean();
        echo json_encode(['status' => 'error', 'message' => 'Insert error: ' . $conn->error]);
        exit;
    }
}

?>
