<?php
    require "../vendor/autoload.php";
    include "config.php";
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");

    $headers = getallheaders();

    if (!isset($headers['Authorization'])) {
        http_response_code(401);
        echo json_encode(["message" => "Token missing"]);
        exit();
    }

    $token = str_replace("Bearer ", "", $headers['Authorization']);

    try {
        $decoded = JWT::decode($token, new Key($_ENV['JWT_SECRET'], 'HS256'));
        echo json_encode(["message" => "Token verified", "user" => $decoded]);
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["message" => "Invalid token"]);
    }
?>
