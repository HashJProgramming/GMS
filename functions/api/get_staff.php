<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

include_once '../setup.php';

if (!$db) {
    echo json_encode(["error" => "Connection failed"]);
    exit;
}

$sql = "SELECT id, username, fullname, address, phone, level, created_at FROM users ORDER BY id DESC";
$stmt = $db->prepare($sql);
$stmt->execute();
$staff = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($staff);
?>