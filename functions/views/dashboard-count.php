<?php
include_once 'functions/connection.php';

function calculateMonthlyEarnings() {
    global $db;
    $sql = 'SELECT SUM(total) AS monthlyEarnings FROM payments WHERE MONTH(created_at) = MONTH(CURRENT_DATE())';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    $monthlyEarnings = $result['monthlyEarnings'];
    return $monthlyEarnings;
}

function calculateYearlyEarnings() {
    global $db;
    $sql = 'SELECT SUM(total) AS yearlyEarnings FROM payments WHERE YEAR(created_at) = YEAR(CURRENT_DATE())';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    $yearlyEarnings = $result['yearlyEarnings'];
    return $yearlyEarnings;
}

function countTotalActiveMembers() {
    global $db;
    $sql = 'SELECT COUNT(*) AS totalActiveMembers FROM `members` WHERE DATE_ADD(start_date, INTERVAL 1 MONTH) > CURDATE()';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    $totalActiveMembers = $result['totalActiveMembers'];
    return $totalActiveMembers;
}

function countTotalMembers() {
    global $db;
    $sql = 'SELECT COUNT(*) AS totalMembers FROM members';
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetch();
    $totalMembers = $result['totalMembers'];
    return $totalMembers;
}