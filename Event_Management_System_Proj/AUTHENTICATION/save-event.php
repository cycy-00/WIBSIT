<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "myevnt";

// Connect to database
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Only organizers can create events
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'organizer') {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_event'])) {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $date = $_POST['event_date'];
    $time = $_POST['event_time'];
    $location = trim($_POST['location']);
    $capacity = (int)$_POST['capacity'];
    $organizer_id = $_SESSION['user_id'];
    
    $imagePath = null;

    // Handle Image Upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = "../uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = uniqid() . "_" . basename($_FILES['image']['name']);
        $targetPath = $uploadDir . $imageName;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
            $imagePath = "uploads/" . $imageName;
        }
    }

    // Insert event into the database
    $stmt = $conn->prepare("INSERT INTO events (organizer_id, title, description, date, time, location, capacity, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssis", $organizer_id, $title, $description, $date, $time, $location, $capacity, $imagePath);

    if ($stmt->execute()) {
        echo "Event created successfully!";
        header("Location: organizer_dashboard.php"); // Redirect back to dashboard after creation
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    echo "Invalid request.";
}
?>