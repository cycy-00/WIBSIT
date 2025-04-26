<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ebentify. | Best Event Management</title>
  <link rel="icon" href="IMAGES/ebentify.logo.png">
  <link rel="stylesheet" href="style.css">
</head>
<body>

<!--HEADER-->
<header class="header">
  <a href="#" class="logo">
    <img src="IMAGES/ebentify.logo.png" alt="Ebentify Logo">Ebentify.
  </a>
  <nav class="navbar">
    <a href="#home">Home</a>
    <a href="#feature-event">Events</a>
    <a href="support.html">Contact</a>

    <?php if (isset($_SESSION['user_id'])): ?>
    <div class="dropdown">
      <a href="#" class="dropbtn">Dashboard ▼</a>
      <div class="dropdown-content">
        <a href="../HOMEPAGE/attendee/attendDB.php">Attendee Dashboard</a>
        <a href="../HOMEPAGE/organizer/create_event.php">Organizer Dashboard</a>
      </div>
    </div>
    <a href="../AUTHENTICATION/logout.php" class="logout-btn">Logout</a>
    <?php else: ?>
    <a href="../AUTHENTICATION/login.html">Login</a>
    <a href="../AUTHENTICATION/signup.php">Sign Up</a>
    <?php endif; ?>
  </nav>
</header>

<!--HOME SECTION-->
<section class="home" id="home">
  <div class="content">
    <h1>Let Ebentify cook your event</h1>
    <p>Experience unforgettable moments with Ebentify.</p>
    <?php if (!isset($_SESSION['user_id'])): ?>
  <a href="/Event_Management_System_Proj/AUTHENTICATION/signup.html" class="btn1">Get Started</a>
<?php endif; ?>
  </div>
  <img src="IMAGES/image1.jpg" class="home-image">
</section>

<!--FEATURED & UPCOMING EVENTS-->
<section class="feature-event" id="feature-event">
  <div class="content">
    <h2>Featured Events</h2>
    <p1>Discover the most exciting events happening right now.
       From live shows to exclusive gatherings, these are the ones you won’t 
       want to miss.</p1>
    <div class="eventlist">
      <!-- Events go here -->
    </div>
  </div>
</section>

</body>
</html> 