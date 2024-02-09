<?php
include_once 'connection.php';

$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM `users` WHERE username = :username OR phone = :phone";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':phone', $phone);
$stmt->execute();
$count = $stmt->rowCount();

if ($count > 0) {
    header('Location: ../staff.php?type=error&message=Staff already exists');
    exit;
}

$sql = "INSERT INTO `users` (`fullname`, `phone`, `address`, `username`, `password`, `level`) VALUES (:fullname, :phone, :address, :username, :password, 1)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
$stmt->execute();

header('Location: ../staff.php?type=success&message=Staff details were added successfully');