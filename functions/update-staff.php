<?php
include_once 'connection.php';

$id = $_POST['id'];
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM `users` WHERE username = :username OR phone = :phone AND id != :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':id', $id);
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
    header('Location: ../staff.php?type=error&message=Staff already exists');
    exit;
}

$sql = "UPDATE `users` SET `fullname` = :fullname, `phone` = :phone, `address` = :address, `username` = :username, `password` = :password WHERE `id` = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
$stmt->execute();

header('Location: ../staff.php?type=success&message=Staff details were updated successfully');