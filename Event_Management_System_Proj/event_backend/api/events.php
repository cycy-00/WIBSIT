<?php
include '../config/db.php';
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit;
}

// GET: Retrieve events
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $stmt = $pdo->query("SELECT * FROM events");
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// POST: Create an event (organizer only)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SESSION['user']['role'] === 'organizer') {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $pdo->prepare("INSERT INTO events (title, description, date, location, organizer_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['title'],
        $data['description'],
        $data['date'],
        $data['location'],
        $_SESSION['user']['id']
    ]);
    echo json_encode(["message" => "Event created"]);
}
?>
