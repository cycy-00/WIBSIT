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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Get user by email
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];
            $_SESSION['message'] = "Login successful! Welcome back.";

            // Redirect if role is not yet chosen
            if (empty($user['role']) || $user['role'] == 'user') {
                header("Location: /Event_Management_System_Proj/AUTHENTICATION/select-role.php");
                exit();
            }

            // Redirect based on role
            switch ($user['role']) {
                case 'admin':
                    header("Location: /Event_Management_System_Proj/admin/dashboard.php");
                    break;
                case 'organizer':
                    header("Location: /Event_Management_System_Proj/HOMEPAGE/organizer/create_event.php");
                    break;
                case 'attendee':
                    header("Location: /Event_Management_System_Proj/HOMEPAGE/index.php");
                    break;
                default:
                    header("Location: /Event_Management_System_Proj/AUTHENTICATION/select-role.php"); // fallback
            }
            exit();
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No account found with that email.";
    }
}
?>
