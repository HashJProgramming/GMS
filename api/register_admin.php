<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$host = "localhost";
$db   = "gms_db";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
    exit;
}

$data     = json_decode(file_get_contents("php://input"), true);
$username = trim($data['username']    ?? '');
$fullname = trim($data['fullname']    ?? '');
$address  = trim($data['address']     ?? '');
$phone    = trim($data['phone']       ?? '');
$password = $data['password']         ?? '';
$confirm  = $data['confirm_password'] ?? '';
$level    = 0;

if (empty($username) || empty($fullname) || empty($password)) {
    echo json_encode(["success" => false, "message" => "All fields are required."]);
    exit;
}

if ($password !== $confirm) {
    echo json_encode(["success" => false, "message" => "Passwords do not match."]);
    exit;
}

if (strlen($password) < 8) {
    echo json_encode(["success" => false, "message" => "Password must be at least 8 characters."]);
    exit;
}

$check = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$check->execute([$username]);
if ($check->fetch()) {
    echo json_encode(["success" => false, "message" => "Username already exists."]);
    exit;
}

$hashed = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("INSERT INTO users (username, password, fullname, address, phone, level)
                       VALUES (?, ?, ?, ?, ?, ?)");
$stmt->execute([$username, $hashed, $fullname, $address, $phone, $level]);

if ($stmt->rowCount() > 0) {
    echo json_encode(["success" => true, "message" => "Account created! You can now login."]);
} else {
    echo json_encode(["success" => false, "message" => "Registration failed. Try again."]);
}
?>