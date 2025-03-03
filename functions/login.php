<?php 
    include "../config.php";

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data['username'];
    $email = $data['email'];
    $password = $data['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if($user && password_verify($password, $user['password'])){
        echo json_encode(["message" => "Login successful", "status" => true]);
    }
    else{
        echo json_encode(["message" => "Invalid credentials", "status" => false]);
    }
?>