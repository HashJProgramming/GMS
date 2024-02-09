<?php
include_once 'functions/connection.php';

$sql = 'SELECT *, DATEDIFF(DATE_ADD(start_date, INTERVAL 1 MONTH), CURDATE()) AS days_due FROM `members`';

$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
    $age = date_diff(date_create($row['birthdate']), date_create('now'))->y;
    $daysDue = $row['days_due'];
    $class = '';
    $text = '';
    if ($daysDue > 0) {
        $class = 'badge bg-success';
        $text = 'Expire in ' . $daysDue . ' days';
    } elseif ($daysDue == 0) {
        $class = 'badge bg-warning';
        $text = 'Expire Today';
    } else {
        $class = 'badge bg-danger';
        $text = 'Expired';
    }
?>
    <tr>
        <td><img class="rounded-circle me-2" width="30" height="30" src="assets/img/avatars/avatar1.jpeg"><?=$row['fullname']?></td>
        <td><?=$row['address']?></td>
        <td><?=$row['phone']?></td>
        <td><?=$age?></td>
        <td><?=$row['sex']?></td>
        <td><?=$row['type']?></td>
        <td><?=$row['start_date']?></td>
        <td><span class="<?= $class ?>"><?= $text ?></span></td>
        <td class="text-center">
            <a class="btn btn-primary mx-1" role="button" href="profile.php" data-bs-target="#pay" data-bs-toggle="modal" data-id="<?= $row['id'] ?>" data-type="<?= $row['type'] ?>">
                <i class="far fa-money-bill-alt"></i>&nbsp;Payment
            </a>
        </td>
    </tr>
<?php
}
?>
