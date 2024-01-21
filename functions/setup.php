<?php
date_default_timezone_set('Asia/Manila');
$database = 'bhrms';
$db = new PDO('mysql:host=localhost', 'root', '');
$query = "CREATE DATABASE IF NOT EXISTS $database";

try {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec($query);
    $db->exec("USE $database");

    $db->exec("
            CREATE TABLE IF NOT EXISTS users (
              id INT PRIMARY KEY AUTO_INCREMENT,
              username VARCHAR(255),
              password VARCHAR(255),
              fullname VARCHAR(255),
              email VARCHAR(255),
              phone VARCHAR(255),
              address VARCHAR(255),
              level VARCHAR(255),
              created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
            ");

    $db->exec("
            CREATE TABLE IF NOT EXISTS rooms (
                id INT PRIMARY KEY AUTO_INCREMENT,
                pax VARCHAR(255),
                rent DECIMAL(10,2),
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )
        ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS boarders (
            id INT PRIMARY KEY AUTO_INCREMENT,
            fullname VARCHAR(255),
            phone VARCHAR(255),
            sex varchar(255),
            address VARCHAR(255),
            room VARCHAR(255),
            type VARCHAR(255),
            start_date DATE,
            profile_picture VARCHAR(255),
            proof_of_identity VARCHAR(255),
          created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
        ");

    $db->exec("
        CREATE TABLE IF NOT EXISTS payments (
            id INT PRIMARY KEY AUTO_INCREMENT,
            boarder INT,
            room INT,
            amount DECIMAL(10,2),
            total DECIMAL(10,2),
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (boarder) REFERENCES boarders(id) ON DELETE CASCADE,
            FOREIGN KEY (room) REFERENCES rooms(id) ON DELETE CASCADE
        )
    ");

    $db->exec("
          CREATE TABLE IF NOT EXISTS logs (
            id INT PRIMARY KEY AUTO_INCREMENT,
            user_id int,
            logs TEXT,
            type TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        )
        ");


    $db->beginTransaction();

    $stmt = $db->prepare("SELECT COUNT(*) FROM `users` WHERE `username` = 'admin'");
    $stmt->execute();
    $userExists = $stmt->fetchColumn();

    if (!$userExists) {
        $stmt = $db->prepare("INSERT INTO `users` (`username`, `password`, `level`) VALUES (:username, :password, :level)");
        $stmt->bindValue(':username', 'admin');
        $stmt->bindValue(':password', '$2y$10$WgL2d2fzi6IiGiTfXvdBluTLlMroU8zBtIcRut7SzOB6j9i/LbA4K');
        $stmt->bindValue(':level', 0);
        $stmt->execute();
    }

    $db->commit();
} catch (PDOException $e) {
    die("Error creating database: " . $e->getMessage());
}
