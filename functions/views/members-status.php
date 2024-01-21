<?php
include_once 'functions/connection.php';

$sql = 'SELECT b.*, r.rent, DATEDIFF(DATE_ADD(b.start_date, INTERVAL 1 MONTH), CURDATE()) AS days_due FROM `boarders` b
        INNER JOIN `rooms` r ON b.room = r.id';

$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
    $daysDue = $row['days_due'];
    $class = '';
    $text = '';
    $total = 0;
    if ($daysDue > 0) {
        $class = 'bg-success';
        $text = 'Due in ' . $daysDue . ' days';
    } elseif ($daysDue == 0) {
        $class = 'bg-warning';
        $text = 'Due Today';
        $total = round($row['rent'] + ($row['rent'] * abs($daysDue / 30)) );
    } else {
        $class = 'bg-danger';
        $text = 'Overdue ';
        $total = round($row['rent'] + ($row['rent'] * abs($daysDue / 30)) );
    }
?>
    <tr>
        <td><img class="rounded-circle me-2" width="30" height="30" src="functions/<?= $row['profile_picture'] ?>"><?= $row['fullname'] ?></td>
        <td>Room #<?= $row['room'] ?></td>
        <td>₱<?= $row['rent'] ?></td>
        <td>₱<?= number_format($total,2) ?></td>
        <td><?= $row['start_date'] ?></td>
        <td class="<?= $class ?>"><?= $text ?></td>
        <td><?= abs($daysDue > 0 ? 0 : $daysDue)?></td>
        <td class="text-center">
            <a class="btn btn-primary mx-1" role="button" href="profile.php" data-bs-target="#pay" data-bs-toggle="modal" data-id="<?= $row['id'] ?>" data-room="<?= $row['room'] ?>" data-total="<?= $total ?>">
                <i class="far fa-money-bill-alt"></i>&nbsp;Payment
            </a>
        </td>
    </tr>
<?php
}
?>
