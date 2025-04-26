<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Event System - Home</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f0f0f0; }
        .box { background: white; padding: 20px; border-radius: 5px; max-width: 500px; margin: auto; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="box">
        <?php if (isset($_SESSION['user'])): ?>
            <h2>Welcome, <?= htmlspecialchars($_SESSION['user']['name']) ?>!</h2>
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email']) ?></p>
            <p><strong>Role:</strong> <?= htmlspecialchars($_SESSION['user']['role']) ?></p>

            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <p><a href="admin/panel.php">Go to Admin Panel</a></p>
            <?php elseif ($_SESSION['user']['role'] === 'organizer'): ?>
                <p><a href="api/events.php">Manage Events</a></p>
            <?php elseif ($_SESSION['user']['role'] === 'attendee'): ?>
                <p><a href="api/registrations.php">View Your Registrations</a></p>
            <?php endif; ?>

            <form method="post">
                <button type="submit" name="logout">Logout</button>
            </form>

            <?php
            if (isset($_POST['logout'])) {
                session_destroy();
                header("Location: index.php");
                exit;
            }
            ?>

        <?php else: ?>
            <h2>Welcome to the Event Management System</h2>
            <p>You are not logged in.</p>
            <p>Please use <code>POST</code> to <code>/api/auth.php</code> with <strong>email</strong> and <strong>password</strong> to log in via Postman or a frontend.</p>
        <?php endif; ?>
    </div>
</body>
</html>
