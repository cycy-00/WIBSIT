<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "myevnt";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['role'])) {
    $role = $_POST['role'];
    $userId = $_SESSION['user_id'];

    // Update the user's role in the database
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $role, $userId);

    if ($stmt->execute()) {
        $_SESSION['role'] = $role;

        // Redirect based on role
        if ($role == 'attendee') {
            header("Location: ../HOMEPAGE/index.php"); // homepage
        } else if ($role == 'organizer') {
            header("Location: ../organizer/index.html"); // organizer dashboard
        }
        exit();
    } else {
        echo "Failed to update role.";
    }
} else {
    echo "Invalid request.";
}

?>
