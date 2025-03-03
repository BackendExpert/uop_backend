<?php
    $host = "localhost";
    $dbname = "uop_db";
    $username = "root";
    $password = "1234";

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die(json_encode(["error" => "Database connection failed: " . $e->getMessage()]));
    }
?>
