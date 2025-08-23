<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>CardZap</title>
    <link rel="stylesheet" href="../css/visitor_homepage.css">
  </head>
  <body>
    <div class="app">
      <!-- Sidebar -->
      <aside class="sidebar">
        <div class="brand">
          <strong>FlashLearn</strong>
        </div>
        <nav>
          <ul class="nav-list">
            <li><a class="nav-item" href="profilepage.php">Profile</a></li>
            <li><a class="nav-item" href="friendspage.php">Friends</a></li>
            <li><a class="nav-item" href="student_yourcards.php">Your Cards</a></li>
            <li><a class="nav-item" href="student_enrolled.php">Enrolled</a></li>
            <li><a class="nav-item" href="student_settings.php">Settings</a></li>
          </ul>
        </nav>
      </aside>

      <!-- Header -->
      <header class="topbar">
        <div class="page-title">Home</div>
        <div class="notification-container">
          <button class="notification-btn">🔔</button>
          <div class="notification-popup">
            <div class="notification-header">Notifications</div>
            <div class="notification-content">No new notifications.</div>
          </div>
        </div>
        <a class="login-btn" href="loginpage.php">Log in</a>
      </header>

      <!-- Main content -->
      <main class="content">
        <button class="add-card">+</button>
      </main>
    </div>

    <script src="../javascript/visitor_homepage.js"></script>
  </body>
</html>