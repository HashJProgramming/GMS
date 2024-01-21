<?php
include_once 'connection.php';

$id = $_POST['id'];

$sql = "DELETE FROM boarders WHERE id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();

generate_logs('Remove boarder', $fullname . '| Boarder details were removed');
header('Location: ../boarders.php?type=success&message=Boarder details were removed successfully');
exit;
