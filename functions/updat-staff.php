<?php
include_once 'connection.php';

$id = $_POST['id'];
$fullname = $_POST['fullname'];
$sex = $_POST['sex'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$type = $_POST['type'];
$start_date = $_POST['start_date'];
$birthdate = $_POST['birthdate'];

$sql = "SELECT * FROM members WHERE fullname = :fullname OR phone = :phone AND id != :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
    header('Location: ../members.php?type=error&message=Member already exists');
    exit;
}

$sql = "UPDATE `members` SET `fullname` = :fullname , `sex` = :sex , `phone` = :phone , `address` = :address , `type` = :type , `start_date` = :start_date , `birthdate` = :birthdate WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':sex', $sex);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':type', $type);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->execute();

header('Location: ../members.php?type=success&message=Member was updated successfully');
