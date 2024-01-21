<?php
include_once 'functions/connection.php';

$sql = 'SELECT b.*, r.rent FROM `boarders` b
        INNER JOIN `rooms` r ON b.room = r.id';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
?>
    <tr>
        <td><img class="rounded-circle me-2" width="30" height="30" src="functions/<?=$row['profile_picture']?>"><?=$row['fullname']?></td>
        <td>Room #<?= $row['room'] ?></td>
        <td><?= $row['type'] ?></td>
        <td>₱<?= $row['rent'] ?></td>
        <td><?= $row['start_date'] ?></td>
        <td><?= $row['phone'] ?></td>
        <td class="text-center">
            <a class="btn btn-primary mx-1" role="button" href="profile.php?id=<?=$row['id']?>">View</a>
            <button class="btn btn-warning mx-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?=$row['id']?>" data-fullname="<?=$row['fullname']?>" data-room="<?=$row['room']?>" data-type="<?=$row['type']?>" data-sex="<?=$row['sex']?>" data-start_date="<?=$row['start_date']?>"  data-phone="<?=$row['phone']?>"  data-address="<?=$row['address']?>">Update</button>
            <button class="btn btn-danger mx-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?=$row['id']?>">Remove</button>
        </td>
    </tr>

<?php
}
