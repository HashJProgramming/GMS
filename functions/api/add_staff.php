<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

include_once '../setup.php';

if (!$db) {
    echo json_encode(["success" => false, "message" => "Connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$fullname = $data['fullname'] ?? '';
$phone    = $data['phone']    ?? '';
$address  = $data['address']  ?? '';
$username = $data['username'] ?? '';
$password = $data['password'] ?? '';

// Check if username or phone already exists
$sql = "SELECT * FROM users WHERE username = :username OR phone = :phone";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':phone', $phone);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    echo json_encode(["success" => false, "message" => "Username or phone already exists"]);
    exit;
}

// Insert new staff - level 1 = staff (matches your add-staff.php)
$sql = "INSERT INTO users (fullname, phone, address, username, password, level) 
        VALUES (:fullname, :phone, :address, :username, :password, 1)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone',    $phone);
$stmt->bindParam(':address',  $address);
$stmt->bindParam(':username', $username);
$stmt->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
$stmt->execute();

echo json_encode(["success" => true, "message" => "Staff added successfully"]);
?>