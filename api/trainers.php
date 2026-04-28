<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

$host = "localhost";
$db   = "gms_db";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $stmt = $pdo->query("SELECT id, fullname, age, gender, mobile, email, address, hire_date, created_at FROM trainers ORDER BY created_at DESC");
    $trainers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($trainers);

} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = $pdo->prepare("INSERT INTO trainers (fullname, age, gender, mobile, email, address, hire_date, salary) 
                            VALUES (:fullname, :age, :gender, :mobile, :email, :address, :hire_date, :salary)");
    $stmt->execute([
        ':fullname'  => $data['fullname'],
        ':age'       => $data['age'],
        ':gender'    => $data['gender'],
        ':mobile'    => $data['mobile'],
        ':email'     => $data['email'],
        ':address'   => $data['address'],
        ':hire_date' => $data['hire_date'],
        ':salary'    => $data['salary'],
    ]);
    echo json_encode(["success" => true, "id" => $pdo->lastInsertId()]);
}
?>