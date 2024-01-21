<?php
include_once 'connection.php';

$id = $_POST['id'];
$room = $_POST['room'];
$total = $_POST['total'];
$amount = $_POST['amount'];
$change = $amount - $total;

if ($change < 0) {
    header('Location: ../rentals.php?type=error&message=Amount is not enough');
    exit;
}

$sql = "INSERT INTO payments (boarder, room, amount, total) VALUES (:boarder, :room, :amount, :total)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':boarder', $id);
$stmt->bindParam(':room', $room);
$stmt->bindParam(':amount', $amount);
$stmt->bindParam(':total', $total);
$stmt->execute();

$paymentId = $db->lastInsertId();

$sql = "UPDATE boarders SET start_date = CURDATE() WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

generate_logs('Payment', $id . '| Payment was made');
header('Location: ../reciept.php?id=' . $paymentId);
// header('Location: ../rentals.php?type=success&message=Payment was made successfully');
?>