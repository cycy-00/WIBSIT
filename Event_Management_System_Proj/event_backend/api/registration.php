<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

// POST: Register for an event
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user']['id'], $data['event_id']]);
    echo json_encode(["message" => "Registered successfully"]);
}

// GET: Show my registrations
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->prepare("SELECT e.title, e.date FROM registrations r JOIN events e ON r.event_id = e.id WHERE r.user_id = ?");
    $stmt->execute([$_SESSION['user']['id']]);
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
?>
