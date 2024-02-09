<?php
include_once 'functions/connection.php';

$sql = 'SELECT * FROM members';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();

foreach ($results as $row) {
    $age = date_diff(date_create($row['birthdate']), date_create('now'))->y;
?>
    <tr>
        <td><?=$row['id']?></td>
        <td><img class="rounded-circle me-2" width="30" height="30" src="https://bootdey.com/img/Content/avatar/avatar7.png"><?=$row['fullname']?></td>
        <td><?=$row['address']?></td>
        <td><?=$row['phone']?></td>
        <td><?=$age?></td>
        <td><?=$row['sex']?></td>
        <td><?=$row['type']?></td>
        <td><?=$row['birthdate']?></td>
        <td><?=$row['start_date']?></td>
        <td class="text-center">
            <button class="btn btn-warning btn-sm d-none d-sm-inline-block mx-1 my-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?=$row['id']?>" data-fullname="<?=$row['fullname']?>" data-address="<?=$row['address']?>" data-phone="<?=$row['phone']?>" data-sex="<?=$row['sex']?>" data-type="<?=$row['type']?>" data-birthdate="<?=$row['birthdate']?>" data-start_date="<?=$row['start_date']?>"><i class="fas fa-check-circle fa-sm text-white-50"></i>&nbsp;Update</button>
            <button class="btn btn-danger btn-sm d-none d-sm-inline-block mx-1 my-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?=$row['id']?>"><i class="fas fa-trash-alt fa-sm text-white-50"></i>&nbsp;Remove</button></td>
    </tr>
<?php
}