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
$role     = $data['role']     ?? 'admin';
$password = $data['password'] ?? '';

if ($role === 'member') {
    $email = trim($data['email'] ?? '');
    $stmt  = $pdo->prepare("SELECT * FROM members WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            "success"  => true,
            "role"     => "member",
            "id"       => $user['id'],
            "fullname" => $user['fullname'],
            "email"    => $user['email']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Wrong email or password."]);
    }
} else {
    $username = trim($data['username'] ?? '');
    $stmt     = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        echo json_encode([
            "success"  => true,
            "role"     => "admin",
            "id"       => $user['id'],
            "username" => $user['username'],
            "level"    => $user['level']
        ]);
    } else {
        echo json_encode(["success" => false, "message" => "Wrong username or password."]);
    }
}
?>