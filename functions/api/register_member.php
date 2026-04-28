<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

include_once '../connection.php'; // same as your members.php uses

$data = json_decode(file_get_contents("php://input"), true);

$fullname  = trim($data['fullname']  ?? '');
$email     = trim($data['email']     ?? '');
$phone     = trim($data['phone']     ?? '');
$sex       = trim($data['sex']       ?? '');
$birthdate = trim($data['birthdate'] ?? '');
$address   = trim($data['address']   ?? '');
$type      = trim($data['type']      ?? 'Monthly');
$password  = $data['password']          ?? '';
$confirm   = $data['confirm_password']  ?? '';

// Validate required fields
if (empty($fullname) || empty($email) || empty($password) || empty($phone)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

// Validate password match
if ($password !== $confirm) {
    echo json_encode(["success" => false, "message" => "Passwords do not match."]);
    exit;
}

// Validate password length
if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "Password must be at least 8 characters."]);
    exit;
}

// Check if email already exists in members table
$check = $db->prepare("SELECT id FROM members WHERE email = ?");
$check->execute([$email]);
if ($check->fetch()) {
    echo json_encode(["success" => false, "message" => "Email already registered. Please login instead."]);
    exit;
}

// Hash password — same as your web register
$hashed     = password_hash($password, PASSWORD_DEFAULT);
$start_date = date('Y-m-d');

// Insert — exact same columns as your functions/register.php
$stmt = $db->prepare("INSERT INTO members 
    (fullname, email, password, phone, sex, birthdate, address, type, status, start_date, created_at)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active', ?, NOW())");
$stmt->execute([$fullname, $email, $hashed, $phone, $sex, $birthdate, $address, $type, $start_date]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["success" => true, "message" => "Account created! You can now login."]);
} else {
    echo json_encode(["success" => false, "message" => "Registration failed. Please try again."]);
}
?>