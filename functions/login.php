<?php 
    include "../config.php";
    require "../vendor/autoload.php";
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json");


    $data = json_decode(file_get_contents("php://input"), true);

    $email = $data['email'];
    $password = $data['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email=?");
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        if($user['is_active'] === "0"){
            echo json_encode(["message" => "Account is Still Not Active", "status" => false]);
        }
        else{
            $payload = [
                "id" => $user['id'],
                "email" => $user['email'],
                "exp" => time() + (60 * 60 * 24) 
            ];
            
            $token = JWT::encode($payload, $_ENV['JWT_SECRET'], 'HS256');
        
            echo json_encode(["message" => "Login successful", "token" => $token, "useremail" => $user['email']]);
        }

    } else {
        echo json_encode(["message" => "Invalid credentials", "status" => false]);
    }
?>