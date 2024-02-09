<?php
include_once 'connection.php';

$fullname = $_POST['fullname'];
$sex = $_POST['sex'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$type = $_POST['type'];
$start_date = $_POST['start_date'];
$birthdate = $_POST['birthdate'];

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

header('Location: ../members.php?type=success&message=Member was added successfully');
