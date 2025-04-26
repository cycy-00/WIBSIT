<?php
// Database connection directly in this file
$host = "localhost";
$user = "root";
$pass = ""; // default for XAMPP
$db = "myevnt"; // or whatever your database is called

$conn = new mysqli( $host, $user, $pass, $db );

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];

    // Validate password match
    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "Email is already registered.";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user with default role "user"
    $stmt = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, 'user')");
    $stmt->bind_param("ss", $email, $hashedPassword);

    if ($stmt->execute()) {
        // Optionally log the user in
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = 'user';
        header("Location: dashboard.php"); // Change this to your user dashboard
        exit();
    } else {
        echo "Registration failed. Please try again.";
    }
}
?>