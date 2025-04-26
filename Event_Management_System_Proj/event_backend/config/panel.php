<?php
include '../config/db.php';
session_start();

if ($_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    echo json_encode(["error" => "Access denied"]);
    exit;
}

// Get reported events
$reportedEvents = $pdo->query("SELECT * FROM events WHERE reported = 1")->fetchAll(PDO::FETCH_ASSOC);

// Get all users
$users = $pdo->query("SELECT id, name, email, role FROM users")->fetchAll(PDO::FETCH_ASSOC);

echo json_encode([
    "reported_events" => $reportedEvents,
    "users" => $users
]);
?>
