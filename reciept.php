<?php
include_once 'functions/authentication.php';
include_once 'functions/connection.php';

$id = $_GET['id'];

$sql = "SELECT p.*, b.* FROM `payments` p INNER JOIN `members` b ON p.member = b.id WHERE p.id = :id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$result = $stmt->fetch();

$boarder = $result['fullname'];
$total = $result['total'];
$amount = $result['amount'];
$change = $amount - $total ;

function getRentalReciept(){
    global $db;
    global $id;
    $sql = "SELECT p.*, b.* FROM `payments` p INNER JOIN `members` b ON p.member = b.id WHERE p.id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $result = $stmt->fetchAll();
    foreach($result as $row){
        ?>
        <tr class="font-monospace">
                    <td class="font-monospace text-start mt-0 mb-0" style="font-size: 10px;"><?= $row['fullname']?></td>
                    <th class="font-monospace text-center mt-0 mb-0" style="font-size: 10px;">Type #<?= $row['type']?></th>
                    <th class="font-monospace text-center mt-0 mb-0" style="font-size: 10px;">₱<?= number_format($row['total'], 2)?></th>
                    <td class="font-monospace text-end mt-0 mb-0" style="font-size: 10px;">₱<?= number_format($row['amount'], 2)?></td>
                </tr>
        <?php
    }
}


?>
<!DOCTYPE html>
<html data-bs-theme="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>GMS</title>
    <meta name="description" content="GMS - Gym Membership System">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i&amp;display=swap">
</head>

<!-- <body class="mx-5" onload=""> -->
<body class="mx-5" onload="printPageAndRedirect()">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th class="font-monospace text-center" style="color: var(--bs-gray-900);font-size: 13px;">
                    GMS - Gym Membership System<br>
                    <span style="font-weight: normal !important;">Street Unknown, Pagadian City</span><br>
                    <span style="font-weight: normal !important;">Phone (+63) 000-000-000</span><br>
                    <span style="font-weight: normal !important;">Date: <?php echo date('Y-m-d')?></span><br>
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr></tr>
                <tr></tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive">
        <table class="table table-borderless">
            <thead>
                <tr>
                    <th class="font-monospace text-center" style="font-size: 15px;">Rental Reciept</th>
                </tr>
            </thead>
            <tbody class="font-monospace">
                <tr class="font-monospace"></tr>
                <tr class="font-monospace"></tr>
            </tbody>
        </table>
    </div>
    <div class="table-responsive font-monospace">
        <table class="table table-borderless">
            <thead class="font-monospace">
                <tr class="font-monospace">
                    <th class="font-monospace" style="font-size: 15px;"><span style="font-weight: normal !important;">MEMBER: <strong><?php echo $boarder; ?></strong></span></th>
                    <th class="font-monospace text-end" style="font-size: 15px;"></th>
                    <th class="font-monospace text-end" style="font-size: 15px;"></th>
                    <th class="font-monospace text-end" style="font-size: 15px;">INVOICE #<?php echo $_GET['id'] ?></th>
                </tr>
            </thead>
            <tbody class="font-monospace">
                
            </tbody>
        </table>
    </div>
    
    <div class="table-responsive font-monospace">
        <table class="table table-borderless">
            <thead class="font-monospace">
                <tr class="font-monospace">
                    <th class="font-monospace text-start" style="font-size: 15px;"><span><strong>MEMBER</strong></span></th>
                    <th class="font-monospace text-center" style="font-size: 15px;"><span><strong>TYPE</strong></span></th>
                    <th class="font-monospace text-center" style="font-size: 15px;"><span><strong>PRICE</strong></span></th>
                    <th class="font-monospace text-end" style="font-size: 15px;"><span><strong>AMOUNT</strong></span></th>
                </tr>
            </thead>
            <tbody class="font-monospace">
                <?php getRentalReciept() ?>
            </tbody>
        </table>
    </div>
   
    <div class="table-responsive">
        <table class="table">
            <thead class="font-monospace">
                <tr class="font-monospace">
                    <th class="font-monospace text-end"><strong>TOTAL</strong>&nbsp;<strong>₱<?php echo number_format($total, 2); ?></strong><br><strong>CHANGE</strong>&nbsp;<strong>₱<?php echo number_format($change, 2); ?></strong></th>
                </tr>
            </thead>
            <tbody>
                <tr></tr>
            </tbody>
        </table>
    </div>
    
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/dataTables.buttons.min.js"></script>
    <script src="assets/js/jszip.min.js"></script>
    <script src="assets/js/pdfmake.min.js"></script>
    <script src="assets/js/vfs_fonts.js"></script>
    <script src="assets/js/buttons.html5.min.js"></script>
    <script src="assets/js/buttons.print.min.js"></script>
    <script src="assets/js/listTable.js"></script>
    <script src="assets/js/theme.js"></script>
    <script>
        $(document) .ready(function() {
        } );
            function printPageAndRedirect() {
                setTimeout(function() {
                    window.setTimeout(function() {
                        window.print();
                        window.location.href = 'status.php';
                    }, 500);
                }, 500);
            }
            
    </script>
</body>

</html>