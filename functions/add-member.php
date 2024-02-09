<?php
include_once 'connection.php'; 

$fullname = $_POST['fullname']; 
$sex = $_POST['sex'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$type = $_POST['type'];
$start_date = $_POST['start_date'];
$birthdate = $_POST['birthdate'];
$amount = $_POST['amount'];


$sql = "SELECT * FROM members WHERE fullname = :fullname OR phone = :phone";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
    header('Location: ../members.php?type=error&message=Member already exists');
    exit;
}

if ($type == 'Regular'){
    $total = 300;
} elseif ($type == 'Premium'){
    $total = 500;
} else {
    $total = 800;
}

$change = $amount - $total;

if ($change < 0) {
    header('Location: ../members.php?type=error&message=Amount is not enough');
    exit;
}

$sql = "INSERT INTO `members` (`fullname`, `sex`, `phone`, `address`, `type`, `start_date`, `birthdate`) 
        VALUES (:fullname, :sex, :phone, :address, :type, :start_date, :birthdate)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':sex', $sex);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':type', $type);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->execute();

$id = $db->lastInsertId();

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
