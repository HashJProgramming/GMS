<?php
include_once 'functions/connection.php';

$sql = 'SELECT members.*, payments.total, payments.amount
        FROM members
        INNER JOIN payments ON members.id = payments.member';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
?>
    <tr>
        <td><img class="rounded-circle me-2" width="30" height="30" src="https://bootdey.com/img/Content/avatar/avatar7.png"><?=$row['fullname']?></td>
        <td><?=$row['address']?></td>
        <td><?=$row['phone']?></td>
        <td><?=$row['type']?></td>
        <td>₱<?=number_format($row['amount'], 2)?></td>
        <td>₱<?=number_format($row['total'], 2)?></td>
        <td><?=$row['start_date']?></td>
    </tr>
<?php
}
?>