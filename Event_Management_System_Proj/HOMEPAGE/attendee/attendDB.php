<?php
session_start();
if (!isset($_SESSION['email']) || $_SESSION['role'] !== 'attendee') {
    header('Location: ../../AUTHENTICATION/login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Attendee Dashboard | Ebentify</title>
  <link rel="stylesheet" href="attendee_dashboard.css">
</head>
<body>

<header>
  <div class="header-left">
    <div class="logo">
      <img src="../IMAGES/ebentify.logo.png" alt="Ebentify Logo" style="height: 50px;">
      <h2>Ebentify.</h2>
    </div>
  </div>

  <div class="header-right">
    <?php if (isset($_SESSION['email'])): ?>
      <div class="dropdown">
        <button class="dropbtn">
          <?php echo $_SESSION['email']; ?> ▼
        </button>
        <div class="dropdown-content">
          <a href="../../AUTHENTICATION/logout.php">Logout</a>
        </div>
      </div>
    <?php endif; ?>
  </div>
</header>

<div class="dashboard-container">
  
  <div class="sidebar">
    <nav>
      <ul>
        <li><a href="../../HOMEPAGE/index.php">Home</a></li>
        <li><a href="browse_events.php">Browse Events</a></li>
        <li><a href="my_registrations.php">My Registrations</a></li>
      </ul>
    </nav>
  </div>

  <div class="main-content">
    <h3>Welcome to your Attendee Dashboard!</h3>
    <p>Start browsing and registering for exciting events!</p>
  </div>

</div>

</body>
</html>