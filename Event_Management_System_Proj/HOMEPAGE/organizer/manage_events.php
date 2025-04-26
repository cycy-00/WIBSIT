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

// CHECK IF USER IS ORGANIZER
if (!isset($_SESSION['email'])) {
    header("Location: ../../AUTHENTICATION/login.php");
    exit();
}

$query = "SELECT * FROM events WHERE organizer_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['email']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Events</title>
    <link rel="stylesheet" href="db.css"> <!-- optional if may sarili kang css -->
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

<div class="dashboard-container">
  
  <div class="sidebar">
    <nav>
      <ul>
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="create_event.php">Create Event</a></li>
        <li><a href="manage_events.php">Manage Event</a></li>
      </ul>
    </nav>
  </div>

  <div class="main-content">
    <h3>Manage Your Events</h3>

    <table border="1" cellpadding="10" cellspacing="0">
      <tr>
        <th>Title</th>
        <th>Date</th>
        <th>Time</th>
        <th>Location</th>
        <th>Actions</th>
      </tr>

      <?php while ($row = $result->fetch_assoc()): ?>
      <tr>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo htmlspecialchars($row['event_date']); ?></td>
        <td><?php echo htmlspecialchars($row['event_time']); ?></td>
        <td><?php echo htmlspecialchars($row['location']); ?></td>
        <td>
          <a href="edit_event.php?id=<?php echo $row['event_id']; ?>">✏️ Edit</a> |
          <a href="delete_event.php?id=<?php echo $row['event_id']; ?>" onclick="return confirm('Are you sure you want to delete this event?');">🗑️ Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>

    </table>
  </div>

</div>

</body>
</html>