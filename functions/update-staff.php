<?php
include_once 'connection.php';

$id = $_POST['id'];
$pax = $_POST['pax'];
$rent = $_POST['rent'];

$sql = "UPDATE rooms SET pax = :pax, rent = :rent WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':pax', $pax);
$stmt->bindParam(':rent', $rent);
$stmt->bindParam(':id', $id);
$stmt->execute();

generate_logs('Update Room', $pax.'| Room was updated successfully');
header('Location: ../rooms.php?type=success&message=Room was updated successfully');
?>