<?php
session_start();

// Connect to database
$host = "localhost";
$user = "root";
$pass = "";
$db = "myevnt";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $event_date = $_POST['event_date'];
    $event_time = $_POST['event_time'];

    $organizer_id = $_SESSION['user_id']; // Assuming user_id is stored in session after login

    // (Optional) Handle image upload later

    // Insert event into database
    $stmt = $conn->prepare("INSERT INTO events (organizer_id, title, description, location, event_date, event_time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $organizer_id, $title, $description, $location, $event_date, $event_time);

    if ($stmt->execute()) {
        // Success
        header("Location: dashboard.php?success=EventCreated");
        exit();
    } else {
        echo "Failed to create event. Please try again.";
    }

    $stmt->close();
}

$conn->close();
?>