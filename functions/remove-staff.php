<?php
include_once 'connection.php';

$id = $_POST['id'];

$sql = "DELETE FROM `members` WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

generate_logs('Remove member', $id . '| Boarder details were removed');
header('Location: ../members.php?type=success&message=Member details were removed successfully');
exit;
