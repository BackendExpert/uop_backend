<?php
    include "../config.php";

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    $data = json_decode(file_get_contents("php://input"), true);

    $username = $data['username'];
    $email = $data['email'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);

    $checkuser_stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $checkuser_stmt->execute([$email]);

    // $user_indb = $checkuser_stmt->rowCount()

    if($checkuser_stmt->rowCount() !== 0){
        echo json_encode(["message" => "User Already in Database", "status" => false]);
    }
    else{
        $insert_stmt = $pdo->prepare("INSERT INTO users (username, email, password) (?,?,?)");
        $insert_stmt->execute([$username, $email, $password]);

        echo json_encode(["message" => "User registered successfully"]);
    }    
?>