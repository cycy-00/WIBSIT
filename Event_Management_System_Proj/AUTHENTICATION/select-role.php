<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Select Role</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: white;
            padding: 40px 30px;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 25px;
            color: #333;
        }
        .role-button {
            background: #007BFF;
            color: white;
            border: none;
            padding: 15px 25px;
            margin: 10px;
            font-size: 16px;
            border-radius: 8px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .role-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>How do you want to use the platform?</h2>
        <form method="POST" action="save-role.php">
            <button type="submit" name="role" value="attendee" class="role-button">I'm an Attendee</button>
            <button type="submit" name="role" value="organizer" class="role-button">I'm an Organizer</button>
        </form>
    </div>
</body>
</html

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['role'])) {
    $role = $_POST['role'];
    $userId = $_SESSION['user_id'];

    // Update user role in database
    $stmt = $conn->prepare("UPDATE users SET role = ? WHERE id = ?");
    $stmt->bind_param("si", $role, $userId);

    if ($stmt->execute()) {
        $_SESSION['role'] = $role;

        if ($role == 'attendee') {
            header("Location: ../save-role.php"); // <-- make sure this is correct relative to save-role.php
        } else if ($role == 'organizer') {
            header("Location: ../HOMEPAGE/organizer/organizerDB.php");
        }
        exit();
    } else {
        echo "Failed to update role.";
    }
} else {
    echo "Invalid request.";
}
?>