
<?php
session_start();

// Redirect non-organizers
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'organizer') {
    header("Location: ../index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Organizer Dashboard</title>
  <link rel="stylesheet" href="db.css">
</head>
<body>

<!-- HEADER -->
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
            <a href="../../save-role.php?role=attendee">Switch to Attendee</a>
            <a href="../../AUTHENTICATION/logout.php">Logout</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </header>

  <!-- DASHBOARD -->
  <div class="dashboard-container">
    
    <!-- SIDEBAR -->
    <div class="sidebar">
      <nav>
        <ul>
          <li><a href="../index.php">Home</a></li>
          <li><a href="create_event.php"> Create Event</a></li>
          <li><a href="manage_events.php">Manage Event</a></li>
        </ul>
      </nav>
    </div>

  <!-- MAIN CONTENT -->
  <main class="main-content">
    <h3>Create a New Event</h3>
    <form action="save_event.php" method="POST" enctype="multipart/form-data">
      <label>Title:</label>
      <input type="text" name="title" required>

      <label>Description:</label>
      <textarea name="description" required></textarea>

      <label>Date:</label>
      <input type="date" name="event_date" required>

      <label>Time:</label>
      <input type="time" name="event_time" required>

      <label>Location:</label>
      <input type="text" name="location" required>

      <label>Capacity:</label>
      <input type="number" name="capacity" required>

      <label>Upload Image:</label>
      <input type="file" name="image" accept="image/*">

      <button type="submit" name="create_event">Create Event</button>
    </form>
  </main>
</div>

</body>
</html>
