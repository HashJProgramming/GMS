<?php
include_once 'connection.php';

$id = $_POST['id'];

$sql = "DELETE FROM `users` WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

generate_logs('Remove staff', $id . '| Boarder details were removed');
header('Location: ../staff.php?type=success&message=Staff details were removed successfully');
exit;
