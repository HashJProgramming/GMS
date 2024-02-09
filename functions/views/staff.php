<?php
include_once 'functions/connection.php';

$sql = 'SELECT * FROM `users` WHERE `level` > 0';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
?>
    <tr>
        <td><?=$row['id']?></td>
        <td><?=$row['username'] ? : 'None';?></td>
        <td><img class="rounded-circle me-2" width="30" height="30" src="https://bootdey.com/img/Content/avatar/avatar7.png"><?=$row['fullname']? : 'None'?></td>
        <td><?=$row['address']? : 'None'?></td>
        <td><?=$row['phone']? : 'None'?></td>
        <td><?=$row['created_at']?></td>
        <td class="text-center">
            <button class="btn btn-warning btn-sm mx-1 my-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?=$row['id']?>" data-fullname="<?=$row['fullname']?>" data-address="<?=$row['address']?>" data-phone="<?=$row['phone']?>" data-username="<?=$row['username']?>"><i class="fas fa-check-circle fa-sm text-white-50"></i>&nbsp;Update</button>
            <button class="btn btn-danger btn-sm mx-1 my-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?=$row['id']?>"><i class="fas fa-trash-alt fa-sm text-white-50"></i>&nbsp;Remove</button></td>
    </tr>
<?php
}