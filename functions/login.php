<?php
include_once 'connection.php';

$role     = $_POST['role'] ?? 'admin';
$password = $_POST['password'];

if ($role === 'member') {
    // MEMBER LOGIN - uses email
    $email = $_POST['email'];

    $sql  = "SELECT * FROM members WHERE email = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['member_id'] = $user['id'];
        $_SESSION['fullname']  = $user['fullname'];
        $_SESSION['role']      = 'member';
        header('location: ../member_dashboard.php');
        exit();
    } else {
        header('location: ../index.php?type=error&message=Wrong username or password');
        exit();
    }

} else {
    // ADMIN LOGIN - uses username
    $username = $_POST['username'];

    $sql  = "SELECT * FROM users WHERE username = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['username'] = $username;
        $_SESSION['level']    = $user['level'];
        $_SESSION['id']       = $user['id'];
        $_SESSION['role']     = 'admin';

        if (isset($_POST['remember'])) {
            setcookie('username', $username, time() + (86400 * 30), "/");
            setcookie('password', $password, time() + (86400 * 30), "/");
        } else {
            setcookie('username', '', time() - 3600, "/");
            setcookie('password', '', time() - 3600, "/");
        }

       generate_logs('Login', $username . '| Logged in');
        if ($user['level'] == 0) {
            header('location: ../dashboard.php');
        } else {
            header('location: ../staff.php');
        }
        exit();
    } else {
        header('location: ../index.php?type=error&message=Wrong username or password&role=admin');
        exit();
    }
}
?>