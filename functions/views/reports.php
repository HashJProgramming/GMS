<?php
include_once 'functions/connection.php';

$sql = 'SELECT boarders.*, rooms.id as room, rooms.rent as rent, payments.total, payments.amount
        FROM boarders
        INNER JOIN rooms ON boarders.room = rooms.id
        INNER JOIN payments ON boarders.id = payments.boarder';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
?>
    <tr>
        <td><img class="rounded-circle me-2" width="30" height="30" src="functions/<?=$row['profile_picture']?>"><?=$row['fullname']?></td>
        <td>Room # <?=$row['room']?></td>
        <td><?=$row['type']?></td>
        <td>₱<?=number_format($row['rent'], 2)?></td>
        <td>₱<?=number_format($row['total'], 2)?></td>
        <td>₱<?=number_format($row['amount'], 2)?></td>
        <td><?=$row['start_date']?></td>
    </tr>
<?php
}
?>