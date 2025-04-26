<?php
include '../config/db.php'; 
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        echo json_encode(["status" => "success", "role" => $user['role']]);
    } else {
        echo json_encode(["status" => "fail", "message" => "Invalid credentials"]);
    }
}
?>
