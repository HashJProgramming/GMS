<?php
include_once 'connection.php';

$id = $_POST['id'];
$fullname = $_POST['fullname'];
$phone = $_POST['phone'];
$sex = $_POST['sex'];
$address = $_POST['address'];
$start_date = $_POST['start_date'];
$room = $_POST['room'];
$type = $_POST['type'];

$target_dir = "img/";
$profile = $target_dir . $fullname . basename($_FILES["profile"]["name"]);
$proof = $target_dir . $fullname . basename($_FILES["proof"]["name"]);

// Check if profile and proof are empty
if (!empty($_FILES["profile"]["name"]) && !empty($_FILES["proof"]["name"])) {
    move_uploaded_file($_FILES["profile"]["tmp_name"], $profile);
    move_uploaded_file($_FILES["proof"]["tmp_name"], $proof);
}

$sql = "SELECT * FROM boarders WHERE (fullname = :fullname OR phone = :phone) AND id != :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':id', $id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header('Location: ../boarders.php?type=error&message=' . $fullname . ' is already exist or phone number is already exist');
    exit;
}

$sql = "UPDATE boarders SET fullname = :fullname, phone = :phone, sex = :sex, address = :address, start_date = :start_date, room = :room, type = :type";

// Add profile_picture and proof_of_identity to the query if they are not empty
if (!empty($_FILES["profile"]["name"]) && !empty($_FILES["proof"]["name"])) {
    $sql .= ", profile_picture = :profile, proof_of_identity = :proof";
}

$sql .= " WHERE fullname = :fullname OR phone = :phone";
$stmt = $db->prepare($sql);
$stmt->bindParam(':fullname', $fullname);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':sex', $sex);
$stmt->bindParam(':address', $address);
$stmt->bindParam(':start_date', $start_date);
$stmt->bindParam(':room', $room);
$stmt->bindParam(':type', $type);

// Bind profile and proof parameters if they are not empty
if (!empty($_FILES["profile"]["name"]) && !empty($_FILES["proof"]["name"])) {
    $stmt->bindParam(':profile', $profile);
    $stmt->bindParam(':proof', $proof);
}

$stmt->execute();

generate_logs('Updating boarder', $fullname . '| Boarder details were updated');
header('Location: ../boarders.php?type=success&message=Boarder details were updated successfully');
exit;
