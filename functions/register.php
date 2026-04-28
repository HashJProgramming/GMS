<?php
include_once 'connection.php';

$fullname = trim($_POST['fullname']);
$phone    = trim($_POST['phone']);
$sex      = $_POST['sex'];
$birthdate= $_POST['birthdate'];
$address  = trim($_POST['address']);
$email    = trim($_POST['email']);
$password = $_POST['password'];
$confirm  = $_POST['confirm_password'];
$type     = $_POST['type'];

// Check if passwords match
if ($password !== $confirm) {
    header('location: ../register.php?type=error&message=Passwords do not match.');
    exit();
}

// Check if email already exists
$check = $db->prepare("SELECT id FROM members WHERE email = ?");
$check->execute([$email]);
if ($check->fetch()) {
    header('location: ../register.php?type=error&message=Email is already registered. Please login instead.');
    exit();
}

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Set start_date to today
$start_date = date('Y-m-d');

// Insert new member
$stmt = $db->prepare("INSERT INTO members (fullname, email, password, phone, sex, birthdate, address, type, status, start_date, created_at)
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'active', ?, NOW())");
$stmt->execute([$fullname, $email, $hashed, $phone, $sex, $birthdate, $address, $type, $start_date]);

if ($stmt->rowCount() > 0) {
    header('location: ../index.php?type=success&message=Registration successful! You can now login as a member.');
    exit();
} else {
    header('location: ../register.php?type=error&message=Something went wrong. Please try again.');
    exit();
}
?>