<?php
include_once 'connection.php';

$id = $_POST['id'];
$type = $_POST['type'];
if ($type == 'Regular'){
    $total = 300;
} elseif ($type == 'Premium'){
    $total = 500;
} else {
    $total = 800;
}

$amount = $_POST['amount'];
$change = $amount - $total;

if ($change < 0) {
    header('Location: ../status.php?type=error&message=Amount is not enough');
    exit;
}

$sql = "INSERT INTO payments (member, type, amount, total) VALUES (:member, :type, :amount, :total)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':member', $id);
$stmt->bindParam(':type', $type);
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':total', $total);
$stmt->execute();

$paymentId = $db->lastInsertId();

$sql = "UPDATE members SET start_date = CURDATE() WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

generate_logs('Payment', $id . '| Payment was made');
header('Location: ../reciept.php?id=' . $paymentId);
// header('Location: ../rentals.php?type=success&message=Payment was made successfully');
?>