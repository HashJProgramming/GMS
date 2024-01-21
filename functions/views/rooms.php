<?php
include_once 'functions/connection.php';

$sql = 'SELECT * FROM `rooms`';
$stmt = $db->prepare($sql);
$stmt->execute();
$results = $stmt->fetchAll();


foreach ($results as $row) {

?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['pax']; ?></td>
        <td>₱<?php echo number_format($row['rent'],2); ?></td>
        <td class="text-center">
            <button class="btn btn-warning mx-1" type="button" data-bs-target="#update" data-bs-toggle="modal" data-id="<?php echo $row['id'] ?>" data-pax="<?php echo $row['pax'] ?>" data-rent="<?php echo $row['rent'] ?>">Update</button>
            <button class="btn btn-danger mx-1" type="button" data-bs-target="#remove" data-bs-toggle="modal" data-id="<?php echo $row['id'] ?>">Remove</button>
        </td>
    </tr>

<?php
}
