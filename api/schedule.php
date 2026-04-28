<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST");
header("Access-Control-Allow-Headers: Content-Type");

include_once 'C:/xampp/htdocs/GMS/functions/setup.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $member_id = $_GET['member_id'] ?? null;
    if ($member_id) {
        $stmt = $db->prepare("SELECT * FROM schedules WHERE member_id = ?");
        $stmt->execute([$member_id]);
        $schedules = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $schedules]);
    }

} elseif ($method === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $member_id = $data['member_id'];
    $schedules = $data['schedules'];

    // Delete existing schedules for this member
    $stmt = $db->prepare("DELETE FROM schedules WHERE member_id = ?");
    $stmt->execute([$member_id]);

    // Insert new schedules
    $stmt = $db->prepare("INSERT INTO schedules (member_id, day, time_slot, focus) VALUES (?, ?, ?, ?)");
    foreach ($schedules as $schedule) {
        $stmt->execute([
            $member_id,
            $schedule['day'],
            $schedule['time_slot'],
            $schedule['focus']
        ]);
    }
    echo json_encode(['success' => true, 'message' => 'Schedule saved!']);
}
?>