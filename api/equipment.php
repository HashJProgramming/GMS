<?php
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Content-Type');

include_once 'C:/xampp/htdocs/GMS/functions/setup.php';

if (!isset($db)) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed']);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $equipment_name = $data['equipment_name'] ?? '';
    $description    = $data['description'] ?? '';
    $muscles_used   = $data['muscles_used'] ?? '';
    $delivery_date  = $data['delivery_date'] ?? '';
    $cost           = $data['cost'] ?? 0;
    $quantity       = $data['quantity'] ?? 0;

    $sql = "INSERT INTO equipment 
            (equipment_name, description, muscles_used, delivery_date, cost, quantity) 
            VALUES 
            (:equipment_name, :description, :muscles_used, :delivery_date, :cost, :quantity)";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':equipment_name', $equipment_name);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':muscles_used', $muscles_used);
    $stmt->bindParam(':delivery_date', $delivery_date);
    $stmt->bindParam(':cost', $cost);
    $stmt->bindParam(':quantity', $quantity);

    if ($stmt->execute()) {
        echo json_encode(['success' => true,
                          'message' => 'Equipment added successfully']);
    } else {
        echo json_encode(['success' => false,
                          'message' => 'Failed to add equipment']);
    }
    exit;
}

if ($method === 'GET') {
    $stmt = $db->query("SELECT * FROM equipment ORDER BY created_at DESC");
    $equipment = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['success' => true, 'data' => $equipment]);
    exit;
}